<?php
namespace houtaiguanjia\models;
use houtaiguanjia\components\BaseModel;

/**
 * Created by IntelliJ IDEA.
 * User: jym
 * Date: 14-4-11
 * Time: 下午5:09
 */

class Cache extends BaseModel{
    public $key;
    public $server;

    public function rules()
    {
        return array(
            array('key', 'required','skipOnEmpty'=>false,'message'=>'{attribute}不能为空'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'key'=>'缓存Key',
            'server'=>'Cache服务器',
        );
    }
}