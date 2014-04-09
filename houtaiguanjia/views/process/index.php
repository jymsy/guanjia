<h1>查看进程状态</h1>
<div class="form man">
    <?php $form=$this->beginWidget('Sky\web\widgets\ActiveForm',array('htmlOptions'=>array('class'=>"form-horizontal"),'method'=>'get')); ?>
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

<div id="server" name="<?php echo $model->attributes['server']?>">

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
                    <input name="<?php echo $procList['name'];?>" type="checkbox" checked data-size="small" data-on-color="success" data-off-color="danger"/>
                </td>
                <?php else: ?>
                    <td><?php echo "停止时间:".$procList['stop_time']?></td>
                <td>
                    <input name="<?php echo $procList['name'];?>" type="checkbox" data-size="small" data-on-color="success" data-off-color="danger"/>
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
<div>

</div>

<script>
    $('input:checkbox').bootstrapSwitch();
    $('input:checkbox').on('switchChange.bootstrapSwitch', function(event, state) {
        console.log(this.getAttribute('name')); // DOM element
        var server = $('#server').attr('name');
        console.log(server);
//        console.log(event); // jQuery event
        console.log(state.value); // true | false

        $.get('index.php',
            {
                _r:'process/startstop',
                server:server,
                name:this.getAttribute('name'),
                start:state.value
            },function(data){

//                alert(data.code+data.msg);
                if(data.code!=200){

                }else{

                }
                window.location.reload();
            });
    });
</script>


