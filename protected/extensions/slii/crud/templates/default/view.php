<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('admin','$label')=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
    array('label'=>Yii::t("admin","Add").' '.<?php echo $this->modelClass?>::getInCase(false,'accusative'), 'url'=>array('create')),
    array('label'=>Yii::t("admin","Update").' '.<?php echo $this->modelClass?>::getInCase(false,'accusative'), 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
    array('label'=>Yii::t("admin","Delete").' '.<?php echo $this->modelClass?>::getInCase(false,'accusative'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>Yii::t('admin','Are you sure you want to delete this item?'))),
    array('label'=>Yii::t("admin","List").' '.<?php echo $this->modelClass?>::getInCase(true,'accusative'), 'url'=>array('admin')),
);
?>

<h1><?php echo '<?php'?> echo Yii::t("admin",'View')?> <?php echo '<?php'?> echo <?php echo $this->modelClass?>::getInCase(false,'accusative'); <?php echo '?> ', '<?php echo $model->'.$this->tableSchema->primaryKey.'; ?>'?></h1>


<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
{
    if($relation = $this->isRelatedColumn($column->name))
    {
        if($relation[0] === CActiveRecord::HAS_ONE || $relation[0] === CActiveRecord::BELONGS_TO)
        {
            echo "\t\tarray(\n";
            echo "\t\t\t'name' => '".$column->name."',\n";
            echo "\t\t\t'value' => (\$model->".$relation['relationName'].") ? \$model->".$relation['relationName']."->".$this->selectNameColumn($relation[1])." : '',\n";
            echo "\t\t),\n";
            continue;
        }
    }
    if($enum = $this->isEnum($column))
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'value' => Yii::t('admin',\$model->".$column->name."),\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-8) === 'datetime')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'value' => date('H:i:s d.m.Y',\$model->".$column->name."),\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-4) === 'date')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'value' => date('d.m.Y',\$model->".$column->name."),\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-5) === '_html')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'type' => 'raw',\n";
        echo "\t\t),\n";
    }
    elseif(substr($column->name,-5) === 'image')
    {
        echo "\t\tarray(\n";
        echo "\t\t\t'name' => '".$column->name."',\n";
        echo "\t\t\t'type' => 'raw',\n";
        echo "\t\t\t'value' => (\$model->".$column->name.") ? '<img src=\"'.Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploads'].'".$this->modelClass."/'.Helper::getSubDirs(\$model->".$column->name.").'\" />' : '',\n";
        echo "\t\t),\n";
    }
    else
    {
        echo "\t\t'".$column->name."',\n";
    }
}
?>
	),
)); ?>
