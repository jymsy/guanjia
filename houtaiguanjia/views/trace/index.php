<h1>追踪用户请求，目前仅支持dev的用户</h1>
<p>通过传入用户id，可以实时获取用户访问后台的接口情况<br>
点击开始，则会开始追踪。
</p>
<div class="form man">
	<label class="required"><span class="required">*</span>在离开的时候一定要点击'停止追踪'<span class="required">*</span></label>
	<?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm'); ?>
		<div class="row">
			<?php echo $form->labelEx($model,'server'); ?>
			<?php echo $form->dropDownList($model,'server',$serverlist); ?>
			<div class="tooltip">追踪dev还是sky的用户</div>
			<?php echo $form->error($model,'server'); ?>
		</div><!-- row -->
		<div class="row">
			<?php echo $form->labelEx($model,'uid'); ?>
			<?php echo $form->textField($model,'uid',array('size'=>20)); ?>
			<div class="tooltip">要追踪的用户id</div>
			<?php echo $form->error($model,'uid'); ?>
		</div><!-- row -->
		<div class="buttons">
			<?php echo Sky\help\Html::submitButton('开始',array('name'=>'submit', 'id'=>'starttrace')); ?>
			<?php if ($model->status===houtaiguanjia\models\Trace::STATUS_SUCCESS):?>
				<?php echo Sky\help\Html::button('停止追踪',array('name'=>'stop','id'=>'stoptrace')); ?>
				<script type="text/javascript">
				$("#starttrace").hide();
				 $("#houtaiguanjia_models_Trace_uid").attr("disabled","disabled");
				 $("#houtaiguanjia_models_Trace_server").attr("disabled","disabled");
				</script>
			<?php endif;?>
		</div>
	<?php if ($model->status===houtaiguanjia\models\Trace::STATUS_SUCCESS): ?>
<!-- 		<div class="success"> -->
			<?php //echo "设置成功!"; ?>
<!-- 		</div> -->
	<?php elseif($model->status===houtaiguanjia\models\Trace::STATUS_ERROR ||
		$model->status===houtaiguanjia\models\Trace::STATUS_STOP_ERROR):?>
		<div class="error">
			<?php echo "设置失败：$msg";?>
		</div>
	<?php endif;?>
	<?php $this->endWidget(); ?>
	<?php echo Sky\help\Html::textArea('result','',array('rows'=>30, 'cols'=>120, 'readonly'=>'readonly'))?>
	<?php if ($model->status===houtaiguanjia\models\Trace::STATUS_SUCCESS): ?>
		<script type="text/javascript">
			var interval; 

			window.onbeforeunload=function(){

				return '请点击‘停止追踪’再离开';
			}
			function chat() {
	 			$.get("index.php?_r=trace/getInfo&uid="+$('#houtaiguanjia_models_Trace_uid').val()+"&server="+$('#houtaiguanjia_models_Trace_server').val(),function(data){
// 					alert("Data: " + data);
					$("#result").val(data);
				});
			}
			$("#stoptrace").click(function(){
		 		clearTimeout(interval);  //关闭定时器
	 			$.get("index.php?_r=trace/stop&uid="+$('#houtaiguanjia_models_Trace_uid').val()+"&server="+$('#houtaiguanjia_models_Trace_server').val(),
	 		 			function(data, status){
					alert("Data: " + data + "\nStatus: " + status);
	 			});
	 			$("#starttrace").show();
	 			$("#stoptrace").hide();
	 			window.onbeforeunload=function(){};
	 			$("#houtaiguanjia_models_Trace_uid").removeAttr("disabled","");
	 			$("#houtaiguanjia_models_Trace_server").removeAttr("disabled","");
			})

			interval = setInterval(chat, "5000");

		</script>
	<?php endif;?>
</div>