<?php
use houtaiguanjia\components\MagApplication;
defined('SKY_DEBUG') or define('SKY_DEBUG',true);
require_once(__DIR__.'/../framework/sky.php');
require_once(__DIR__.'/components/MagApplication.php');
$config=__DIR__.'/config/main_debug.php';

// \Sky\Sky::createWebApplication($config)->run();
$app=new MagApplication($config);
$app->run();