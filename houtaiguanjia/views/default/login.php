<h1 style="text-align:center;">后台管家</h1>
<div class="form login">
<?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm'); ?>
	<p>请输入密码</p>
	<div class="form-group">
		<?php echo $form->passwordField($model,'password',array('class'=>"form-control",'placeholder'=>"Password")); ?>
	</div>
	<?php echo $form->error($model,'password'); ?>
	<?php echo Sky\help\Html::submitButton('确定', array('class'=>"btn btn-primary")); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
