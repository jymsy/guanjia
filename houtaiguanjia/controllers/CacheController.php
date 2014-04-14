<?php
namespace houtaiguanjia\controllers;
use houtaiguanjia\models\Cache;
use Sky\base\Controller;
use Sky\Sky;
use Sky\web\Response;

/**
 * Created by IntelliJ IDEA.
 * User: jym
 * Date: 14-4-11
 * Time: 下午3:58
 */

class CacheController extends Controller{
    public $layout='cache';

    public function getPageTitle()
    {
        if($this->action->id==='Index')
            return '后台管家-缓存管理';
        else
            return '后台管家-'.ucfirst($this->action->id);
    }

    public function actionIndex()
    {
        $model=new Cache();
        if (isset($_POST['houtaiguanjia_models_Cache'])) {
            $model->attributes = $_POST['houtaiguanjia_models_Cache'];
            if ($model->validate()) {
                $result = $this->getRedisKeyInfo($model->attributes['server'],$model->attributes['key']);
                if($result['code']==500){
                    $model->status=Cache::STATUS_ERROR;
                }else{
                    $model->status=Cache::STATUS_SUCCESS;;
                }
                $this->render('index',array('model'=>$model,'serverlist'=>Sky::$app->params['redisList'],'result'=>$result));
                return '';
            }
        }
        $this->render('index',array('model'=>$model,'serverlist'=>Sky::$app->params['redisList']));
    }

    public function actionMemcache()
    {
        $model=new Cache();
        $this->render('index',array('model'=>$model,'serverlist'=>Sky::$app->params['redisList']));
    }

    public function actionDeleteRedis($server, $key)
    {
        $response = Sky::$app->getResponse();
        $response->format=Response::FORMAT_JSON;
        $result = array();
        $redis=Sky::$app->getComponent($server);
        if($redis!=null){
            $count = $redis->delete($key);
            if($count>0){
                $result['code']=200;
                $result['msg']='删除 '.$key.' 成功';
            }else{
                $result['code']=500;
                $result['msg']='删除 '.$key.' 失败';
            }
        }else{
            $result['code']=500;
            $result['msg']='redis 配置错误';
        }
        return $result;
    }

    protected function getRedisKeyInfo($server,$key)
    {
        $result = array();
        $redis=Sky::$app->getComponent($server);
        if($redis!=null){
            if(!$redis->exists($key)){
                $result['code']=500;
                $result['msg']='Key:'.$key.' 不存在';
                return $result;
            }

            $type = $this->getKeyContent($redis,$key,$values);
            $ttl = $redis->ttl($key).'秒';
            if($ttl == -1)
                $ttl='未设置';
            $result['code']=200;
            $result['type']=$type;
            $result['ttl']=$ttl;
            $result['values']=$values;
            var_dump($result);
        }else{
            $result['code']=500;
            $result['msg']='redis 配置错误';
        }
        return $result;
    }

    protected function getKeyContent($redis, $key,&$values)
    {
        $type = $redis->type($key);
        $values = null;
        switch($type)
        {
            case \Redis::REDIS_HASH:
                $values = $redis->hashGet($key,null,2);
                return 'hash';
            case \Redis::REDIS_LIST:
//                $size =
//                $values = $redis->
                return 'list';
            case \Redis::REDIS_STRING:
                $values = $redis->get($key);
                return 'string';
            case \Redis::REDIS_SET:
                return 'set';
            case \Redis::REDIS_ZSET:
                return 'zset';
            case \Redis::REDIS_NOT_FOUND;
                return 'not found';
        }
    }

}