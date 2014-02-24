<?php
return array(
		'db'=>array(
				'product'=>'mysql',
				'token'=>'TVOS',
// 				'server_master'=>'127.0.0.1:3306',
// 				'server_slave'=>'127.0.0.1:3306',
				'server_master'=>'42.121.113.121:3306',
				'server_slave'=>'42.121.113.121:3306',
				'user'=>'root',
				'password'=>'dota.123',
				'option'=>array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),
		),
		'betadb'=>array(
				'class'=>'Sky\db\ConnectionPool',
				'product'=>'mysql',
				'token'=>'BETA_TVOS',
				'server_master'=>'10.132.43.14:3306',
				'server_slave'=>'10.132.43.14:3306',
				'user'=>'root',
				'password'=>'dota.123',
				'option'=>array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),
		),
		'skydb'=>array(
				'class'=>'Sky\db\ConnectionPool',
				'product'=>'mysql',
				'token'=>'SKY_TVOS',
				'server_master'=>'10.132.59.103:3306',
				'server_slave'=>'10.132.59.103:3306',
				'user'=>'skyadmin',
				'password'=>'skytvos!123',
				'option'=>array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),
		),
);