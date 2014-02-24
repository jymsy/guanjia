<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="./assets/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="./assets/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="./assets/css/ie.css" media="screen, projection" />
	<![endif]-->
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
	<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	
	<link rel="stylesheet" type="text/css" href="./assets/css/main.css" />
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="./assets/js/tooltip.js"></script>
	
	<title><?php echo \Sky\help\Html::encode($this->getPageTitle()); ?></title>
	<script type="text/javascript" src="./assets/js/main.js"></script>
</head>
<body lang="zh-cn">
<div class="container" id="page">
	<div id="header">
		<div class="top-menus">
			<?php if(!\Sky\Sky::$app->getUser()->getIsGuest()): ?>
		    <?php echo \Sky\help\Html::link('注销',array('default/logout')); ?>
			<?php endif; ?>
		</div>
		<div id="logo"><?php echo \Sky\help\Html::link(\Sky\help\Html::image('./assets/images/logo.png'),array('default/index')); ?></div>
	</div><!-- header -->
	
	<?php if(!\Sky\Sky::$app->getUser()->getIsGuest()): ?>
		<ul id='mytab' class="nav nav-tabs">
	  		<li><a id="headpage" href="/houtaiguanjia/index.php?_r=default/index">首页</a></li>
	  		<li><a href="/houtaiguanjia/index.php?_r=session/index">会话管理</a></li>
	  		<li><a href="/houtaiguanjia/index.php?_r=guide/index">常用网址</a></li>
	  		<li><a href="/houtaiguanjia/index.php?_r=trace/index">用户追踪</a></li>
	  		<li><a href="/houtaiguanjia/index.php?_r=process/index">进程管理</a></li>
		</ul>
	<!-- <div id="mainmenu">
		<ul>
			<li><a href="/houtaiguanjia/index.php?_r=default/index">首页</a></li>
			<li><a href="/houtaiguanjia/index.php?_r=session/index">会话管理</a></li>
			<li><a href="/houtaiguanjia/index.php?_r=guide/index">常用网址</a></li>
			<li><a href="/houtaiguanjia/index.php?_r=trace/index">用户追踪</a></li>
			<li><a href="/houtaiguanjia/index.php?_r=process/index">进程管理</a></li>
		</ul>	
	</div>-->
	<?php endif; ?>
	<?php echo $content; ?>
</div><!-- page -->
<div id="footer">
	Copyright &copy; <?php echo date('Y'); ?> by 软件研究院网络技术组<br/>
	All Rights Reserved.<br/>
	Powered by <a href="http://www.skyworth.com/" rel="external">Sky Framework</a>.
</div><!-- footer -->
</body>
</html>