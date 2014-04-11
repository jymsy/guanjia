<div class="form man">
    <?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm',array('htmlOptions'=>array('class'=>"form-horizontal"))); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'server',array('class'=>"col-sm-2 control-label")); ?>
        <div class="col-xs-3">
            <?php echo $form->dropDownList($model,'server',$serverlist,array('class'=>"form-control")); ?>
            <?php echo $form->error($model,'server'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'key', array('class'=>"col-sm-2 control-label")); ?>
        <div class="col-xs-6">
            <?php echo $form->textField($model,'key',array('size'=>50, 'class'=>"form-control")); ?>
            <?php echo $form->error($model,'key'); ?>
        </div>

        <div class="buttons">
            <?php echo Sky\help\Html::submitButton('确定',array('name'=>'submit','class'=>"btn btn-primary")); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>