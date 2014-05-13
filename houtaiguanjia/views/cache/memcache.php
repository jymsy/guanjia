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

<?php if($model->status===houtaiguanjia\models\Cache::STATUS_SUCCESS):?>
    <table class="table table-condensed table-bordered cache">
        <tbody>
                <tr>
                    <th>值</th>
                    <td><?php echo nl2br(htmlentities($result['value'], ENT_COMPAT, 'UTF-8'));?></td>
                </tr>
        </tbody>
    </table>
    <?php echo Sky\help\Html::button('删除',array('id'=>'delete','server'=>$model->attributes['server'],'name'=>$model->attributes['key'],'class'=>"btn btn-danger")); ?>
    <div id="delinfo"></div>
<?php endif;?>
<?php if($model->status===houtaiguanjia\models\Cache::STATUS_ERROR): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong> <?php echo $result['msg'];?>
    </div>
<?php endif;?>
<script>
    $('#delete').click(function(){
        $.post('index.php',
            {
                _r:"cache/deleteMem",
                server:$(this).attr("server"),
                key:$(this).attr("name")
            },function(data){
                if(data.code==200){
                    $('#delinfo').html('<div class="alert alert-success alert-dismissable">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.msg);
                }else{
                    $('#delinfo').html('<div class="alert alert-danger alert-dismissable">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.msg);
                }
            });
    });
</script>