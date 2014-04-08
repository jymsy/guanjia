<h1>查看进程状态</h1>
<div class="form man">
    <?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm',array('htmlOptions'=>array('class'=>"form-horizontal"))); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'server',array('class'=>"col-sm-3 control-label")); ?>
        <div class="col-xs-3">
            <?php echo $form->dropDownList($model,'server',$serverlist,array('class'=>"form-control")); ?>
        </div>
        <?php echo $form->error($model,'server'); ?>
    </div>
    <div class="buttons">
        <?php echo Sky\help\Html::submitButton('确定',array('name'=>'submit','class'=>"btn btn-primary")); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>