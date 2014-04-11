<?php
namespace houtaiguanjia\controllers;
use houtaiguanjia\models\Cache;
use Sky\base\Controller;
use Sky\Sky;

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
                $this->getRedisKeyInfo($model->attributes['server'],$model->attributes['key']);
            }
        }
        $this->render('index',array('model'=>$model,'serverlist'=>Sky::$app->params['redisList']));
    }

    public function actionMemcache()
    {
        $model=new Cache();
        $this->render('index',array('model'=>$model,'serverlist'=>Sky::$app->params['redisList']));
    }

    protected function getRedisKeyInfo($server,$key)
    {
        $redis=Sky::$app->getComponent($server);
        if(!$redis){
//            $type = $redis->
        }
    }

}