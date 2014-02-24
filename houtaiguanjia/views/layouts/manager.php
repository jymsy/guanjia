<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-4">
		<div id="sidebar">
			  <ul>
				<li><?php echo \Sky\help\Html::link('查询tvinfo',array('session/index'));?></li><br/>
				<li><?php echo \Sky\help\Html::link('生成session',array('session/create'));?></li><br/>
			</ul>
			
		</div><!-- sidebar -->
	</div>
	<div class="span-16">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-4 last">
		&nbsp;
	</div>
</div>
<?php $this->endContent(); ?>