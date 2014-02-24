<?php
namespace Sky\utils;

use Sky\base\Component;
use Sky\utils\Socket;
use Sky\Sky;
/**
 * 发送推送消息
 * 使用方法：
 * 'curl' => array(
 *           'class' => 'Sky\utils\Curl',
 *       );
 *   'push' => array(
 *           'class' => 'Sky\utils\PushMsg',
 *           'pushServer'=>'121.199.33.199',
 *           'pushPort'=>50034
 *       );
 *       
 *  $push=Sky::$app->push;
 *  $push->initMsg(PushMsg::BROAD,10001);
 *  $push->addUser(1234);
 *  $push->addMsg(time(), rand(0,100000),$str);
 *  $push->push();
 *  
 * @author Jiangyumeng
 *
 */
class PushMsg extends Component{
	const SINGLE='1';
	const GROUP='2';
	const BROAD='3';
	
	protected $_retType=array(
			'FailDecode','CmdFailFormat','CmdFailFormat',
			'orderError','tokenError'
	);
	
	public $serverName='';
	protected $pushServer='';
	protected $pushPort;
	/**
	 * @var int 1.单点消息, 2.组播消息  3.广播消息
	 */
	public $msgType;
	/**
	 * @var int 命令码 2000 表示 PushMsg
	 */
	public $cmd=2000;
	/**
	 * @var string 版本号默认1.0
	 */
	public $ver='1.0';
	/**
	 * @var int 应用id默认0
	 */
	public $appId=0;
	/**
	 * @var string 消息保存时间
	 */
	public $saveTime='0';
	public $seqno;
	/**
	 * @var string 密码
	 */
	public $passWord;
	protected $user=array();
	protected $userNum=0;
	protected $group=array();
	protected $groupNum=0;
	protected $msg=array();
	protected $msgNum=0;
	/**
	 * @var boolean 是否已经初始化
	 */
	protected $_init = false;
	
	public function init()
	{
		$addr=PushServer::getHost($this->serverName);
		$pos=strpos($addr, ':');
		$this->pushServer=substr($addr, 0,$pos);
		$this->pushPort=substr($addr, $pos+1);
	}
	
	/**
	 * 获取组名信息
	 * @throws \Exception 如果没有初始化
	 * @return array:|NULL 成功放回包含所有组名的数组，
	 * 失败返回null
	 */
	public function getGroup()
	{
		if (!$this->_init) {
			throw new \Exception('please call initMsg first.');
		}
		$curl=Sky::$app->curl;
		$time=time();
		$paramArr=array(
				'cmd'=>2001,
				'seqno'=>$time,
		);
		$token=$this->packToken(2001, $this->passWord, $time);
		
		$data=http_build_query($paramArr)."&token=$token&ver=$this->ver&appid=$this->appId";
		$result = $curl->post($this->pushServer.':'.$this->pushPort, $data);
		
		if(($pos=strpos($result, 'result='))!==false)
		{
			$group=substr($result, $pos+7);
			if (!in_array($group, $this->_retType)) 
			{
				return explode('#', $group);
			}else 
				return null;
		}else 
			return null;
	}
	
	/**
	 * @param unknown $msgType
	 * @param number $appId
	 * @param number $saveTime
	 * @param string $passWord
	 */
	public function initMsg($msgType=self::SINGLE,$appId=0,$saveTime=0,$passWord='')
	{
		$this->msgType=$msgType;
		$this->appId=$appId;
		$this->saveTime=$saveTime;
		$this->seqno=time();
// 		$this->seqno=1;
		if ($passWord=='') {
			$this->passWord=PUSHPWD;
		}else{
			$this->passWord=$passWord;
		}
		$this->_init = true;
	}
	
	/**
	 * 为消息添加一个用户
	 * @param int $userId
	 */
	public function addUser($userId)
	{
		$this->user[]=$userId;
		$this->userNum++;
	}
	
	/**
	 * 为消息添加一个组
	 * @param string $groupIdName
	 */
	public function addGroup($groupIdName)
	{
		$this->group[]=$groupIdName;
		$this->groupNum++;
	}
	
	/**
	 * 添加一个消息
	 * @param int $msgTime
	 * @param int $msgId
	 * @param string $msg
	 */
	public function addMsg($msgTime,$msgId,$msg)
	{
		$this->msg[]=array($msgTime,
				$msgId,
				strlen($msg),
				$msg);
	
		$this->msgNum++;
	}
	
	/**
	 * 发送消息
	 */
	public function push()
	{
		$msgBody='';
	
		foreach ($this->msg as $msg)
		{
			$msgBody.=$this->packMsg($msg,$this->msgType);
		}
	
		$msgBodyLen=11+strlen($msgBody);
	
		$msgBody=$this->packMsgBody($msgBody, $msgBodyLen);
	
		$hexBody=base64_encode($msgBody);
	
		// 		$hexBody=$msgBody;
		$curl=Sky::$app->curl;
		$paramArr=array(
				'cmd'=>$this->cmd,
				'seqno'=>$this->seqno,
// 				'token'=>md5($this->cmd.$this->passWord.$this->seqno),
				'savetime'=>$this->saveTime,
				'ver'=>$this->ver,
				'appid'=>$this->appId,
		);
		// 		'msg'=>$hexBody,
		$token=$this->packToken();
		$data = http_build_query($paramArr).'&token='.$token.'&msg='.$hexBody;
		return $curl->post($this->pushServer.':'.$this->pushPort,$data);
	}
	
	/**
	 * 打包token字段
	 * @return string token字段
	 */
	private function packToken($cmd='',$passWord='',$seqno='')
	{
		if ($cmd=='')
			$cmd=$this->cmd;
		if ($passWord=='')
			$passWord=$this->passWord;
		if ($seqno=='')
			$seqno=$this->seqno;
		
		$tokenArr=array(
			'cmdLen'=>array('n',strlen($cmd)),
			'cmd'=>array('a*',$cmd),
			'passwordLen'=>array('n',strlen($passWord)),
			'password'=>array('a*',$passWord),
			'seqnoLen'=>array('n',strlen($seqno)),
			'seqno'=>array('a*',$seqno)	
		);
		$token=Socket::packByArr($tokenArr);
		return base64_encode("\x0a".pack('n',strlen($token)).$token."\x0b");
	}
	
	/**
	 * 组包消息体。
	 * @param string $msgBody 消息体
	 * @param integer $msgBodyLen 消息体长度
	 * @return string
	 */
	private function packMsgBody($msgBody,$msgBodyLen)
	{
		return "\x0a".pack('n',$msgBodyLen).pack('N',$this->appId).pack('C',$this->msgType).pack('n',$this->msgNum).$msgBody."\x0b";
	}
	
	/**
	 * 清空push对象属性
	 */
	public function clear()
	{
		$this->user= array();
		$this->msg = array();
		$this->group=array();
		$this->userNum=0;
		$this->groupNum=0;
		$this->msgNum=0;
	}
	
	/**
	 * 组包消息
	 * @param string $msg 消息
	 * @param unknown $msgType 消息类型
	 * @return string
	 */
	protected function packMsg($msg,$msgType)
	{
		$msgArrHead=array(
				'msgTime'=>array('N',$msg[0]),
				'msgId'=>array('N',$msg[1]),
				'msgLen'=>array('n',$msg[2]),
				'msg'=>array('a*',$msg[3]),
		);
			
		$msgStr=Socket::packByArr($msgArrHead);
	
		if($msgType==self::SINGLE)
		{
			$msgStr.=pack('n',$this->userNum);
			foreach ($this->user as $user)
			{
				$msgStr.=pack('N',$user);
			}
	
		}elseif ($msgType==self::GROUP)
		{
			$msgStr.=pack('n',$this->groupNum);
			foreach ($this->group as $groupName)
			{
				$msgArrMid=array(
						'groupLen'=>array('n',strlen($groupName)),
						'groupName'=>array('a*',$groupName),
				);
				$msgStr.=Socket::packByArr($msgArrMid);
			}
		}
			
		return $msgStr;
	}
	
	/**
	 * 格式化发送给客户端的消息格式。
	 * @param string $target 目标
	 * @param string $command 命令
	 * @param string $params 参数
	 * @param string $from 发消息的来源
	 * @param string $priority
	 */
	public static function formatClientMsg($target,$command,$params,$from='',$priority='LOW')
	{
		return "command#".time().'#[{"type":"skytvos","target":"'.$target.'","priority":"'.$priority.'","command":"'.$command.'","from":"'.$from.'","params":'.$params."}]#";
	}
}