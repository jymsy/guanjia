<?php
namespace houtaiguanjia\controllers;

use Sky\base\Controller;
use houtaiguanjia\models\Trace;
use Sky\utils\Socket;
use Sky\Sky;
class TraceController extends Controller{
	public $layout='column1';
	public $prefix='trace:';
	private $_server=array(
			'dev'=>array('db'=>'db','redis'=>'redis'),
			'beta'=>array('db'=>'betadb','redis'=>'betaredis'),
			'sky'=>array('db'=>'skydb','redis'=>'skyredis')
	);
	
	public function getPageTitle()
	{
		if($this->action->id==='Index')
			return '后台管家-用户追踪';
		else
			return '后台管家-'.ucfirst($this->action->id);
	}
	
	public function actionIndex()
	{
		$model = new Trace();
		$msg = '';
		$list=array('dev'=>'dev','sky'=>'sky');
		if (isset($_POST['houtaiguanjia_models_Trace']))
		{
			$model->attributes=$_POST['houtaiguanjia_models_Trace'];
			if($model->validate())
			{
// 				if (isset($_POST['stop']))
// 				{
// 					$result = $this->modifySettings($model->attributes['uid'], false);
// 					if($result === TRUE)
// 					{
// // 						$model->status = Trace::STATUS_SUCCESS;
// 					}else{
// 						$model->status = Trace::STATUS_STOP_ERROR;
// 						$msg = $result;
// 					}
// 				}else
				{
					$result = $this->modifySettings($model->attributes['uid'], $model->attributes['server']);
					if($result === TRUE)
					{
						$model->status = Trace::STATUS_SUCCESS;
					}else{
						$model->status = Trace::STATUS_ERROR;
						$msg = $result;
					}
				}
				$this->render('index', array('model'=>$model, 'msg'=>$msg, 'serverlist'=>$list));
				return ;
			}
		}
		$this->render('index', array('model'=>$model,'serverlist'=>$list));
	}
	
	public function actionStop($uid, $server)
	{
		$result = $this->modifySettings($uid, $server, false);
		$redis = Sky::$app->getComponent($this->_server[$server]['redis']);
		$redis->delete($this->prefix.$uid);
		return $result === TRUE?'':$result;
	}
	
	public function actionGetInfo($uid, $server)
	{
		$redis =Sky::$app->getComponent($this->_server[$server]['redis']);
		$result = $redis->listGet($this->prefix.$uid, 0, -1);
// 		var_dump($result);
		return implode("\n------\n", $result);
	}
	
	public function modifySettings($uid, $server, $trace=true)
	{
		$socketArr = array();
		$hostArr = Sky::$app->params[$server];
		
		foreach ($hostArr as $i=>$host)
		{
			$socketArr[$i] = new Socket();
			if(!$socketArr[$i]->connect($host[0], $host[1]))
			{
				return 'connect error@'.$host[0];
			}
		}
		
		foreach ($socketArr as $socket)
		{
			if ($trace) {
				if($ret=$socket->sendGet("trace $uid"))
				{
					if($ret != 'begin')
						return $ret;
				}
			}else{
				if($ret=$socket->sendGet("stop $uid"))
				{
					if($ret != 'stop')
						return $ret;
				}
			}
		}
		return true;
	}
}