<?php $this->beginContent('/layouts/main'); ?>
    <div class="container">
        <div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <?php echo \Sky\help\Html::link('Redis',array('cache/index'),array('class'=>'list-group-item'));?>
                <?php echo \Sky\help\Html::link('Memcache',array('cache/memcache'),array('class'=>'list-group-item'));?>
            </div>
        </div>
        <div class="col-xs-9 col-sm-8">
            <div id="content">
                <?php echo $content; ?>
            </div><!-- content -->
        </div>
        <div class="col-xs-4 col-sm-3">
            &nbsp;
        </div>
    </div>
<?php $this->endContent(); ?>