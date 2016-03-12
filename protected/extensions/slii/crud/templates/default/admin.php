<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
echo "\$this->breadcrumbs=array(
	{$this->modelClass}::getInCase(true,'nominative')=>array('index'),
	Yii::t('admin','List'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t("admin","Add").' '.<?php echo $this->modelClass?>::getInCase(false,'accusative'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo '<?php'?> echo Yii::t("admin","List")," ",<?php echo $this->modelClass?>::getInCase(true,'accusative'); <?php echo '?>'?></h1>

<p>
<?php echo '<?php'?> echo Yii::t('admin','You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.');?>
</p>

<?php echo "<?php echo CHtml::link(Yii::t('admin','Advanced search'),'#',array('class'=>'search-button')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('application.components.MyGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";



    if($relation = $this->isRelatedColumn($column->name))
    {
        if($relation[0] === CActiveRecord::HAS_ONE || $relation[0] === CActiveRecord::BELONGS_TO)
        {
            echo "\t\tarray(\n";
            echo "\t\t\t'filter' => '<div class=\"input-append\" style=\"width: 90%;\">'.CHtml::activeTextField(\$model, '".$column->name."', array('id'=>false)).'<span class=\"add-on pupup-search\" data-popup=\"".$relation[1]."\"><i class=\"icon-search\"></i></span></div>',\n";
            echo "\t\t\t'name' => '".$column->name."',\n";
            echo "\t\t\t'value' => '(\$data->".$relation['relationName'].") ? \$data->".$relation['relationName']."->".$this->selectNameColumn($relation[1])."' : '',\n";
            echo "\t\t),\n";
            continue;
        }
    }
    if($enum = $this->isEnum($column))
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'filter' => array(".$enum."),\n";
        echo "\t\t\t'value' => 'Yii::t(\"admin\",\"\$data->".$column->name."\")',\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-8) === 'datetime')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'filter' => false,\n";
        echo "\t\t\t'value' => 'date(\"H:i:s d.m.Y\",\"\$data->".$column->name."\")',\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-4) === 'date')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'filter' => false,\n";
        echo "\t\t\t'value' => 'date(\"d.m.Y\",\"\$data->".$column->name."\")',\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-5) === '_html')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'filter' => false,\n";
        echo "\t\t\t'type' => 'raw',\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-5) === 'image')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'filter' => false,\n";
        echo "\t\t\t'type' => 'raw',\n";
        echo "\t\t\t'value' => '(\$data->".$column->name.") ? \\'<img src=\"'.Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploads'].'".$this->modelClass."/'.'\'.Helper::getSubDirs(\$data->".$column->name.").\'\" />\' : \'\' ',\n";
        echo "\t\t),\n";
    }
    else
    {
        echo "\t\t'".$column->name."',\n";
    }
}
if($count>=7)
	echo "\t\t*/\n";
?>
    (isset($search_mode) && $search_mode) ? array('value' => '\'<input type="button" class="selectInPopupButton" value="Выбрать">\'','type' => 'raw') : array('class'=>'CButtonColumn',),
	),
)); ?>
