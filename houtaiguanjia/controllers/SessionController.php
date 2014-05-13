<?php
namespace houtaiguanjia\controllers;

use Sky\base\Controller;
use houtaiguanjia\models\Session;
use Sky\Sky;
use houtaiguanjia\models\Mac;
class SessionController extends Controller{
	public $layout='manager';
	private $_normalUser= false;
	private $_server=array(
		'dev'=>array('db'=>'db','redis'=>'redis'),
        'devglobal'=>array('db'=>'db','redis'=>'redis'),
		'beta'=>array('db'=>'betadb','redis'=>'betaredis'),
		'sky'=>array('db'=>'skydb','redis'=>'skyredis')
	);
	
	public function getPageTitle()
	{
		if($this->action->id==='Index')
			return '后台管家-会话管理';
		else
			return '后台管家-'.ucfirst($this->action->id);
	}
	
	public function actionIndex()
	{
		$model=new Session();
		$list=array('dev'=>'dev','beta'=>'beta','sky'=>'sky');
		if (isset($_POST['houtaiguanjia_models_Session'])) 
		{
			$model->attributes=$_POST['houtaiguanjia_models_Session'];
			if($model->validate())
			{
				$ret = $this->getInfo($model->attributes['sessionid'],$model,$model->attributes['server']);
				$model->status=Session::STATUS_SUCCESS;
				$this->render('index',array('model'=>$model,'data'=>$ret,'serverlist'=>$list));
				return ;
			}
		}
		$this->render('index',array('model'=>$model,'serverlist'=>$list));
	}
	
	public function actionCreate()
	{
		$model = new Mac();
		$list=array('dev'=>'dev','beta'=>'beta');
		if (isset($_POST['houtaiguanjia_models_Mac']))
		{
			$model->attributes=$_POST['houtaiguanjia_models_Mac'];
			if($model->validate())
			{
				if (isset($_POST['generate'])) 
				{
// 					var_dump($_POST);
					$arr['user_id']=$_POST['user_id'];
					$arr['dev_mac']=$model->attributes['mac'];
					$arr['ss_ip']=Sky::$app->getRequest()->getUserHostAddress();
					
					$sess=$this->generateSession($model->attributes['mac']);
// 					$redis = Sky::$app->redis;
					$redis = Sky::$app->getComponent($this->_server[$model->attributes['server']]['redis']);
					$redis->tranStart();
					$redis->hashSet($sess, $arr);
					$redis->setKeyExpire($sess, 3600);
					$redis->tranCommit();
					
					$model->status=Mac::STATUS_SUCCESS;
					$this->render('create',array('model'=>$model,'sess'=>$sess, 'serverlist'=>$list));
					return ;
				}else{
					$info=$this->getInfoByMac($model->attributes['mac'], $model->attributes['server']);
					$model->status=Mac::STATUS_FEEDBACK;
					$this->render('create',array('model'=>$model,'data'=>$info, 'serverlist'=>$list));
					return ;
				}

			}
		}

		$this->render('create',array('model'=>$model, 'serverlist'=>$list));
	}
	
	public function generateSession($mac)
	{
		$ip=Sky::$app->getRequest()->getUserHostAddress();
		return md5($ip.microtime(true).rand(100000,999999999999)).'-test';
		
	}
	
	public function getInfoByMac($mac, $server)
	{
		$result['user_id']='';
		$result['chip']='';
		$result['model']='';
		$result['platform']='';
		$result['barcode']='';
		$result['screen_size']='';
		$result['system_version']='';
        $result['tc_version']='';
		
		$smodel = new Session();
		$tvinfo = $smodel->getTvInfo($mac, $this->_server[$server]['db']);
		foreach ($tvinfo as $key=>$value)
		{
			$result[$key]=$value;
		}
		$uid=$smodel->getUserId($mac, $this->_server[$server]['db']);
		$result['user_id']=$uid===null?'':$uid;
		return $result;
	}
	
	public function getUserInfo()
	{
		
	}
	
	/**
	 * @param unknown $sessionId
	 * @param Session $model
	 * @return string
	 */
	public function getInfo($sessionId, $model,$server)
	{
		$result['sessionid']=$sessionId;
		$result['user_id']='';
		$result['dev_mac']='';
		$result['ss_ip']='';
		$result['chip']='';
		$result['model']='';
		$result['platform']='';
		$result['barcode']='';
		$result['screen_size']='';
		$result['system_version']='';
        $result['tc_version']='';
		$tempSession = false;
		
		if (($pos=strpos($sessionId, ':')) === false)
		{
			$redis=Sky::$app->getComponent($this->_server[$server]['redis']);
			$sessInfo = $redis->hashGet($sessionId, null, 2);
			foreach ($sessInfo as $key => $value)
			{
				$result[$key]=$value;
			}
			if ($result['dev_mac']=='' && $result['user_id']!='') 
			{
				$this->_normalUser=true;
				$result['admin_mac']=$model->getAdminMac($result['user_id'],$this->_server[$server]['db']);
			}
		}else{
			$result['dev_mac']=substr($sessionId, $pos+1);
			$tempSession = true;
		}
		
		if (!$tempSession && $result['user_id']==='') {
			return $result;
		}
		$tvinfo = $this->_normalUser?$model->getTvInfo($result['admin_mac'],$this->_server[$server]['db']):$model->getTvInfo($result['dev_mac'],$this->_server[$server]['db']);
		foreach ($tvinfo as $key => $value)
		{
			$result[$key]=$value;
		}
// 		var_dump($result);
		return  $result;
	}
}