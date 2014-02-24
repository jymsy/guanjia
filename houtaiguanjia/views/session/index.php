<h1>获取TVInfo</h1>
<div class="alert alert-info">
<p>如果session查出的mac为空，则该用户为普通用户，<br>
会拿uid到base_user_user_map表中查询对应的管理员uid，<br>
并通过管理员uid查询对应的mac，再查询mac对应的电视信息。<br>
如果查出的管理员uid为空或mac为空，而且还有电视信息，说明设备表中有mac为空的信息。</p>
</div>
<div class="form man">
	<?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm'); ?>
		<div class="row">
			<?php echo $form->labelEx($model,'server'); ?>
		<div class="col-xs-3">
			<?php echo $form->dropDownList($model,'server',$serverlist, array('class'=>"form-control")); ?>
			<div class="tooltip">从dev、beta还是sky的redis查询session</div>
			<?php echo $form->error($model,'server'); ?>
			</div>
		</div><!-- row -->
			<div class="row">
				<?php echo $form->labelEx($model,'sessionid'); ?>
				
				<?php echo $form->textField($model,'sessionid',array('size'=>50, 'class'=>"form-control")); ?>
				<div class="tooltip">
					sessionId，新框架ssession有两种格式：
					<ul>
						<li>正常登陆后获得的session，形如：<code>015c587a0d23c0e24a2c515c80b849bd-forold</code></li>
						<li>登录失败后客户端组的临时会话，形如：<code>xxxxxxxx:abcdefgh0011</code></li>
					</ul>
				</div>
				<?php echo $form->error($model,'sessionid'); ?>

			</div><!-- row -->
			<div class="buttons">
				<?php echo Sky\help\Html::submitButton('提交',array('name'=>'submit','class'=>"btn btn-primary")); ?>
			</div>
	<?php $this->endWidget(); ?>
</div>

<?php if($model->status===houtaiguanjia\models\Session::STATUS_SUCCESS):?>
<table>
	<thead>
		<tr><th>sessionid</th><td><?php echo $data['sessionid']?></td></tr>
		<tr><th>uid</th><td><?php echo $data['user_id']?></td></tr>
		<tr><th>mac</th><td><?php echo $data['dev_mac']?></td></tr>
		<?php if(isset($data['admin_mac'])):?>
			<tr><th>admin_mac</th><td><?php echo $data['admin_mac']?></td></tr>
		<?php endif;?>
		<tr><th>ip</th><td><?php echo $data['ss_ip']?></td></tr>
		<tr><th>chip</th><td><?php echo $data['chip']?></td></tr>
		<tr><th>model</th><td><?php echo $data['model']?></td></tr>
		<tr><th>platform</th><td><?php echo $data['platform']?></td></tr>
		<tr><th>barcode</th><td><?php echo $data['barcode']?></td></tr>
		<tr><th>screen_size</th><td><?php echo $data['screen_size']?></td></tr>
		<tr><th>system_version</th><td><?php echo $data['system_version']?></td></tr>
	</thead>
</table>
<?php endif;?>