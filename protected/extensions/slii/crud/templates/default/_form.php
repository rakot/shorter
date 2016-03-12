<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
\$this->widget(
      'application.widget.emultiselect.EMultiSelect',
      array('sortable'=>true, 'searchable'=>true)
);
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
 ?>\n"; ?>

	<p class="note">
        <?php echo "<?php echo Yii::t('admin','Fields with <span class=\"required\">*</span> are required'); ?>\n"; ?>.
    </p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>

	<div class="row">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
    <?php if(substr($column->name,-5) === '_html'):?>
    <?php echo '<?php $this->widget(\'ImperaviRedactorWidget\', array(
            // you can either use it for model attribute
            \'model\' => $model,
            \'attribute\' => \''.$column->name.'\',

            // some options, see http://imperavi.com/redactor/docs/
            \'options\' => array(
                \'lang\' => \'ru\',
            ),
        )); ?>'?>

    <?php else:?>
    <?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
    <?php endif;?>
    <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
	</div>
    <?php if(substr($column->name,-5) === 'image'):?>
    <?php echo '<?php if($model->'.$this->tableSchema->primaryKey.'){?>'?>
    <div class="row">
        <?php echo "<?php echo \$form->labelEx(\$model,'delete_$column->name',array('label'=>Yii::t('admin','Delete Image?'))); ?>\n"; ?>
        <?php echo "<?php echo \$form->checkBox(\$model,'delete_$column->name',array('value' => 'yes', 'uncheckValue'=>'no')); ?>\n"; ?>
    </div>
    <?php echo '<?php }?>'?>
    <?php endif;?>

<?php
}
?>
	<div class="row buttons">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save')); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->