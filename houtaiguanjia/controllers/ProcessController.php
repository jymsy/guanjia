<?php
namespace houtaiguanjia\controllers;
use houtaiguanjia\models\Process;
use Sky\Sky;
use Sky\utils\Socket;

/**
 * Created by IntelliJ IDEA.
 * User: jym
 * Date: 14-4-4
 * Time: 上午9:28
 */

class ProcessController extends \Sky\base\Controller{
    public $layout='process';

    public function getPageTitle()
    {
        if($this->action->id==='Index')
            return '后台管家-进程管理';
        else
            return '后台管家-'.ucfirst($this->action->id);
    }

    public function actionIndex()
    {
        $model=new Process();
        $list=array('dev'=>'dev','beta'=>'beta','sky'=>'sky','dongle'=>'dongle','tvos'=>'tvos');
        if (isset($_POST['houtaiguanjia_models_Process']))
        {
            $model->attributes=$_POST['houtaiguanjia_models_Process'];
            $result = $this->getProcessInfo($model->attributes['server']);
            var_dump($result);
            $this->render('index',array('model'=>$model,'serverlist'=>$list));
            return ;
        }
        $this->render('index',array('model'=>$model,'serverlist'=>$list));
    }

    /**
     * 从服务器获取进程信息
     * @param $server
     * @return array
     */
    protected function getProcessInfo($server)
    {
        $processInfo = array();
        $host = Sky::$app->params['wolf'][$server];
        $socket = new Socket();
        if(!$socket->connect($host[0],$host[1]))
        {
            $processInfo['code']=500;
            $processInfo['result']='connect error@'.$host[0].':'.$host[1];
            return $processInfo;
        }

        if(($ret=$socket->sendGet("status\n"))!==FALSE){
            $retArray = explode("\n",rtrim($ret,"\n"));
            $resultList = array();
            $length = count($retArray);
            if($length > 3){
                for($i=3;$i<$length;$i++){
                    $this->formatInfo(trim($retArray[$i]));
                }
            }
            $processInfo['code']=200;
//            $processInfo['result']=;
        }

    }

    /**
     * 格式化进程信息
     * @param $str
     * @return array
     */
    protected function formatInfo($str)
    {
        $result=array();
        $tempArr = explode("\t\t",$str);
        $result['name']=$tempArr[0];
        $tempDetailArr = explode("\t",$tempArr[1]);
        var_dump($tempDetailArr);
        $result['status']=$tempDetailArr[0];
        if($result['status']=='RUNNING'){
            $detail = $tempDetailArr[1];
            $mem=0;
            $upTime='';//cmdpid:14020, mem usage:22344 KB, up time:7h 12m 38s
            $ret=preg_match_all('/^cmdpid:(\d+), mem usage:(\d+) KB, up time:(.+)$/',$tempDetailArr[1],$matches);
            var_dump($matches);
        }else{
            $result['stop_time']=$tempDetailArr[1];
            return $result;
        }
    }
}