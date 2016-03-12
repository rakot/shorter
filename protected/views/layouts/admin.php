<?php $this->beginContent('//layouts/adm'); ?>
<div id="middle">
    <div id="l-container">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="sidebar">
        <div id="sideLeft">
        <?php
            $this->widget('zii.widgets.CMenu', array(
                'items'=>array_merge(array(
                    array(
                        'label' => 'Действия',
                        'itemOptions'=>array('class'=>'nav-header'),
                    )
                ),$this->menu),
                'htmlOptions'=>array('class'=>'nav nav-tabs nav-stacked'),
            ));
        ?>
        </div><!-- sidebar -->
    </div>
    <br class="clear" />
</div>
<?php $this->endContent(); ?>