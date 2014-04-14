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
    <div class="col-md-8">
        <table class="table table-condensed">
                <tr><th>类型</th><td><?php echo $result['type'];?></td></tr>
                <tr><th>TTL</th><td><?php echo $result['ttl'];?></td></tr>
        </table>
    </div>
        <table class="table table-condensed table-bordered cache">
            <tbody>
        <?php switch($result['type']):
            case 'string': ?>
                <tr>
                    <th>值</th>
                    <td><?php echo nl2br(htmlentities($result['values'], ENT_COMPAT, 'UTF-8'));?></td>
                </tr>
            <?php break;?>
            <?php case 'hash': ?>
                <tr><th>键</th><th>值</th></tr>
                <?php foreach($result['values'] as $key=>$value):?>
                    <tr>
                        <td><?php echo htmlentities($key, ENT_COMPAT, 'UTF-8');?></td>
                        <td><?php echo nl2br(htmlentities($value, ENT_COMPAT, 'UTF-8'));?></td>
                    </tr>
                <?php endforeach;?>
            <?php break;?>
        <?php endswitch;?>
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
                _r:"cache/deleteRedis",
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