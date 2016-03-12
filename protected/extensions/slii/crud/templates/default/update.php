<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
echo "\$this->breadcrumbs=array(
	{$this->modelClass}::getInCase(true,'nominative')=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('admin','Update'),
);\n";
?>

$this->menu=array(
    array('label'=>Yii::t("admin","Add").' '.<?php echo $this->modelClass?>::getInCase(false,'accusative'), 'url'=>array('create')),
    array('label'=>Yii::t("admin","View").' '.<?php echo $this->modelClass?>::getInCase(false,'accusative'), 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
    array('label'=>Yii::t("admin","List").' '.<?php echo $this->modelClass?>::getInCase(true,'accusative'), 'url'=>array('admin')),
);
?>

<h1><?php echo '<?php'?> echo Yii::t("admin",'Update')?> <?php echo '<?php'?> echo <?php echo $this->modelClass?>::getInCase(false,'accusative'); <?php echo '?> ', '<?php echo $model->'.$this->tableSchema->primaryKey.'; ?>'?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>