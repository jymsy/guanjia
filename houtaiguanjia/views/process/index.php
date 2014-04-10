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


    <?php echo Sky\help\Html::hiddenField('server',$model->attributes['server'])?>
<!--<div id="server" name="--><?php //echo $model->attributes['server']?><!--">-->

</div>
<?php if($model->status===houtaiguanjia\models\Process::STATUS_SUCCESS):?>
    <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>进程名</th>
                <th>状态</th>
                <th>参数</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($result['result'] as $procList):?>
            <?php if($procList['status']=='RUNNING'):?>
                <tr class="success">
            <?php else: ?>
                <tr class="danger">
            <?php endif;?>
                <td><?php echo $procList['name'];?></td>
                <td><?php echo $procList['status'];?></td>
                <?php if($procList['status']=='RUNNING'):?>
                    <td><?php echo "进程号:".$procList['pid']." 内存:".$procList['mem']."Kb 运行时间:".$procList['up_time']?></td>
                <td>
                    <?php echo Sky\help\Html::hiddenField('action','stop')?>
                    <?php echo Sky\help\Html::submitButton('停止',array('name'=>$procList['name'],'class'=>"btn btn-danger btn-xs")); ?>
                </td>
                <?php else: ?>
                    <td><?php echo "停止时间:".$procList['stop_time']?></td>
                <td>
                    <?php echo Sky\help\Html::hiddenField('action','start')?>
                    <?php echo Sky\help\Html::submitButton('启动',array('name'=>$procList['name'],'class'=>"btn btn-success btn-xs")); ?>
                </td>
                <?php endif;?>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php endif;?>
<?php if($model->status===houtaiguanjia\models\Process::STATUS_ERROR): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong> <?php echo $result['result'];?>
    </div>
<?php endif;?>
<?php $this->endWidget(); ?>
</div>
<script>
//    $('input:checkbox').bootstrapSwitch();
//    $('input:checkbox').on('switchChange.bootstrapSwitch', function(event, state) {
//        //        console.log(event); // jQuery event
//        //        console.log(state.value); // true | false
//        //        console.log(this.getAttribute('name')); // DOM element
//        //        var server = $('#server').attr('name');
//        //        console.log(server);
//
//        $.get('index.php',
//            {
//                _r:'process/startstop',
//                server:$('#server').attr('name'),
//                name:this.getAttribute('name'),
//                start:state.value
//            },function(data){
//
////                alert(data.code+data.msg);
//                if(data.code==200){
//                    alert("启动成功");
//                }else{
//                    alert("启动失败！\n"+data.msg);
//                }
//                window.location.reload();
//            });
//    });

</script>


