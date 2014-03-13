<h1>根据电视mac创建session</h1>
<div class="alert alert-info">
<p>输入电视mac，点击 “获取mac信息“ 会在设备表中查询该mac的信息，
<br>并显示在下面的表格中，如果点击“生成session”则会按照该信息生成session<br>
生成的session的过期时间为一小时。</p>
</div>
<div class="form man">
	<label class="required"><span class="required">*</span>不保证该mac创建的session一定能查到设备信息，只能在dev或beta上创建<span class="required">*</span></label>
	<?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm',array('htmlOptions'=>array('class'=>"form-horizontal"))); ?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'server', array('class'=>"col-sm-2 control-label")); ?>
			<div class="col-xs-3">
				<?php echo $form->dropDownList($model,'server',$serverlist,array('class'=>"form-control",'title'=>"在dev还是beta创建session")); ?>
			</div>
			<?php echo $form->error($model,'server'); ?>
		</div><!-- row -->
		<div class="form-group">
			<?php echo $form->labelEx($model,'mac', array('class'=>"col-sm-2 control-label")); ?>
			<div class="col-xs-4">
				<?php echo $form->textField($model,'mac',array('size'=>20, 'class'=>"form-control",'title'=>"必须全部小写，去掉冒号")); ?>
			</div>
			<?php echo $form->error($model,'mac'); ?>
		</div>
		<div class="buttons">
			<?php echo Sky\help\Html::submitButton('获取mac信息',array('name'=>'submit','class'=>"btn btn-primary")); ?>
			<?php if ($model->status===houtaiguanjia\models\Mac::STATUS_FEEDBACK): ?>
				<?php echo Sky\help\Html::submitButton('生成session',array('name'=>'generate','class'=>"btn btn-primary")); ?>
			<?php endif; ?>
		</div>
		<?php if ($model->status===houtaiguanjia\models\Mac::STATUS_FEEDBACK): ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>uid</th><td><?php echo $data['user_id']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('user_id',$data['user_id'])?>
					<tr><th>chip</th><td><?php echo $data['chip']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('chip',$data['chip'])?>
					<tr><th>model</th><td><?php echo $data['model']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('model',$data['model'])?>
					<tr><th>platform</th><td><?php echo $data['platform']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('platform',$data['platform'])?>
					<tr><th>barcode</th><td><?php echo $data['barcode']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('barcode',$data['barcode'])?>
					<tr><th>screen_size</th><td><?php echo $data['screen_size']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('screen_size',$data['screen_size'])?>
					<tr><th>system_version</th><td><?php echo $data['system_version']?></td></tr>
					<?php echo Sky\help\Html::hiddenField('system_version',$data['system_version'])?>
				</thead>
			</table>
		<?php endif; ?>
	<?php $this->endWidget(); ?>
	<?php if ($model->status===houtaiguanjia\models\Mac::STATUS_SUCCESS): ?>
		<div class="success">
			<?php echo "生成session成功：$sess"; ?>
		</div>
	<?php endif;?>
</div>

