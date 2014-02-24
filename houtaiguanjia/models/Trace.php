<?php
namespace houtaiguanjia\models;

use houtaiguanjia\components\BaseModel;
class Trace extends BaseModel{
	const STATUS_STOP_ERROR=4;
	public $uid;
	public $server;
	
	public function rules()
	{
		return array(
				array('uid', 'required','skipOnEmpty'=>false,'message'=>'{attribute}不能为空'),
				array('uid','match', 'pattern'=>'/^[0-9]+$/', 'message'=>'格式错误'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
				'uid'=>'用户id',
				'server'=>'选择服务器',
		);
	}
}