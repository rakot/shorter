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
	Yii::t('admin','Add'),
);\n";
?>

$this->menu=array(
array('label'=>Yii::t('admin','List').' '.<?php echo $this->modelClass?>::getInCase(true,'accusative'), 'url'=>array('admin')),
);
?>

<h1><?php echo '<?php'?> echo Yii::t("admin",'Add')?> <?php echo '<?php'?> echo <?php echo $this->modelClass?>::getInCase(false,'accusative'); <?php echo '?>'?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
