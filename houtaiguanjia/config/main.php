<?php
$config=array(
		'basePath'=>__DIR__.DIRECTORY_SEPARATOR.'..',
		'name'=>'houtaiguanjia',
		'defaultController'=>'default',
		'components'=>array(
				'errorHandler'=>array(
						'class'=>'Sky\base\ErrorHandler',
						'errorAction'=>'default/error',
				),
				'user' => array(
						'class' => 'Sky\web\User',
						'identityClass' => 'houtaiguanjia\models\User',
						'loginUrl'=>Sky\Sky::$app->createUrl('default/login'),
				),
				'urlManager'=>array(
// 						'urlFormat'=>'path',
						'useParamName'=>true,
// 						'needCompatibility'=>true,
				),
				'redis' => array(
						'class' => 'Sky\utils\RedisClient',
// 						'masterhost' => '10.135.9.137:6379',
// 						'slavehost' => '10.135.9.137:6379',
						'masterhost' => '127.0.0.1:6379',
						'slavehost' => '127.0.0.1:6379',
						'persistent' => true,
						'timeout' => 10
				),
				'betaredis' => array(
						'class' => 'Sky\utils\RedisClient',
						'masterhost' => '10.132.43.14:6379',
						'slavehost' => '10.132.43.14:6379',
						'persistent' => true,
						'timeout' => 10
				),
				'skyredis' => array(
						'class' => 'Sky\utils\RedisClient',
						'masterhost' => '10.132.59.105:6379',
						'slavehost' => '10.132.59.105:6379',
						'persistent' => true,
						'timeout' => 10
				),
                'dgredis' => array(
                    'class' => 'Sky\utils\RedisClient',
                    'masterhost' => '10.132.10.156:6379',
                    'slavehost' => '10.132.10.156:6379',
                    'persistent' => true,
                    'timeout' => 10
                ),
                'dbgredis' => array(
                    'class' => 'Sky\utils\RedisClient',
                    'masterhost' => '10.135.9.137:6380',
                    'slavehost' => '10.135.9.137:6380',
                    'persistent' => true,
                    'timeout' => 10
                ),
                'relgredis' => array(
                    'class' => 'Sky\utils\RedisClient',
                    'masterhost' => '10.132.59.105:6379',
                    'slavehost' => '10.132.59.105:6380',
                    'persistent' => true,
                    'timeout' => 10
                ),
                'devmem'=>array(
                    'class' => 'Sky\caching\MemCache',
                    'keyPrefix'=>'',
                    'hashKey'=>false,
                    'serializer'=>false,
                    'servers' => '127.0.0.1:11211',
                ),
                'skymem'=>array(
                    'class' => 'Sky\caching\MemCache',
                    'keyPrefix'=>'',
                    'hashKey'=>false,
                    'serializer'=>false,
                    'servers' => '10.132.59.105:11211',
                ),
				'session'=>array(
					'class'=>'Sky\web\Session',
				),
		),

		// 可以使用 \Sky\Sky::$app->params['paramName'] 访问的应用级别的参数
// 		'params'=>require(__DIR__.DIRECTORY_SEPARATOR.'params.php'),
		'params'=>array(
				'password'=>'guest',
// 				'dev'=>array(array('10.135.9.137',9999),),
				'dev'=>array(array('127.0.0.1',9999),),
				'sky'=>array(
					array('10.132.59.1',9999),//121.199.45.30
					array('10.132.58.92',9999),//121.199.45.36
					array('10.132.58.91',9999),//121.199.45.29
					array('10.132.59.104',9999),//121.199.45.32
				),
                'wolf'=>array(
//                    'dev'=>array('10.135.9.137',3838),
                    'dev'=>array('42.121.113.121',3838),
                    'beta'=>array('10.132.43.14',3839),
                    'sky'=>array('10.132.59.1',3839),
                    'tvos'=>array('10.132.43.150',3839),
                    'dongle'=>array('10.132.10.156',3839),
                ),
                'redisList'=>array(
                    'redis'=>'dev','betaredis'=>'beta','skyredis'=>'sky','dgredis'=>'dongle',
                ),
                'memList'=>array(
                    'devmem'=>'dev','skymem'=>'sky',
                ),
		),
		'modules'=>require(__DIR__.DIRECTORY_SEPARATOR.'modules.php'),
);

$database =  require(__DIR__.DIRECTORY_SEPARATOR.'db.php');
if (!empty($database)) {
	$config['components']=array_merge($config['components'],$database);
}
return $config;