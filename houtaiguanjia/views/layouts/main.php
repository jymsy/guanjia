<!DOCTYPE>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
    <link href="./assets/css/bootstrap-switch.css" rel="stylesheet">
    <script type="text/javascript" src="./assets/js/jquery-1.11.0.min.js"></script>
    <script src="./assets/js/bootstrap-switch.js"></script>
    <script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

	<link rel="stylesheet" type="text/css" href="./assets/css/main.css" />
	<link rel="stylesheet" type="text/css" href="./assets/css/metro.css" />
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
	  		<li><a id="tttt" href="/houtaiguanjia/index.php?_r=session/index">会话管理</a></li>
	  		<li><a id="ttttd" href="/houtaiguanjia/index.php?_r=guide/index">常用网址</a></li>
	  		<li><a id="tttts" href="/houtaiguanjia/index.php?_r=trace/index">用户追踪</a></li>
	  		<li><a id="tttta" href="/houtaiguanjia/index.php?_r=process/index">进程管理</a></li>
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
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by 软件研究院网络技术组<br/>
		All Rights Reserved.<br/>
		Powered by Sky Framework.
	</div><!-- footer -->
</div><!-- page -->

<script type="text/javascript">
$(function(){
	var url = window.location.href;
	var id;
	$('#mytab a').each(function(){
		var current = $(this).attr('href');
		if(url.indexOf(current)>=0)
		{
			id=$(this).attr('id');
		}
//		alert($(this).attr('href'));
	});
// 	alert(id);
	$('#'+id).attr('id','active');
});
</script>
</body>
</html>