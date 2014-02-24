<?php
namespace houtaiguanjia\models;

use houtaiguanjia\components\BaseModel;
class Mac extends BaseModel{
	const STATUS_FEEDBACK=4;
	public $server;
	
	public $mac;
	public function rules()
	{
		return array(
				array('mac', 'required','skipOnEmpty'=>false,'message'=>'{attribute}不能为空'),
				array('mac','match', 'pattern'=>'/^[a-f0-9]{12}$/', 'message'=>'格式错误'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
				'mac'=>'电视mac',
				'server'=>'选择服务器',
		);
	}
}