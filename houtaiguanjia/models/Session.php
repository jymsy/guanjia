<?php
namespace houtaiguanjia\models;

use Sky\Sky;
use houtaiguanjia\components\BaseModel;
class Session extends BaseModel{
	public $sessionid;
	public $server;
	
	public function rules()
	{
		return array(
				array('sessionid', 'required','skipOnEmpty'=>false,'message'=>'{attribute}不能为空'),
				array('sessionid','match', 'pattern'=>'/^\w+[:-]?\w+$/', 'message'=>'格式错误'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
				'sessionid'=>'会话id',
				'server'=>'选择服务器',
		);
	}
	
	public function getUserId($mac, $server)
	{
		$db = Sky::$app->getComponent($server);
		return $db->createCommand(
			'select user_id from skyg_base.base_dev_user_map where dev_mac=:mac',
			array('mac'=>$mac)
		)->toValue();
	}
	
	public function getAdminMac($userId, $server)
	{
		$db = Sky::$app->getComponent($server);
		$mac = $db->createCommand(
				'SELECT dev_mac FROM `skyg_base`.`base_dev_user_map` where user_id=
	 			(SELECT main_user_id from `skyg_base`.`base_user_user_map` where sub_user_id=:userId)',
				array('userId'=>$userId)
		)->toValue();
		return $mac===null?'':$mac;
	}
	
	public function getTvInfo($mac, $server)
	{
		$db = Sky::$app->getComponent($server);
		$tvinfo=$db->createCommand(
				'select dev_mac,chip,model,platform,barcode,screen_size,system_version,tc_version
					from `skyg_base`.`base_device`
					where dev_mac=:mac',
				array(
						'mac'=>$mac,
				)
		)->toList();
		
		if (count($tvinfo)) {
			return $tvinfo[0];
		}else 
			return $tvinfo;
	}
}