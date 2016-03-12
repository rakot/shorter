<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Url shorter</title>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <style>
        .errorMessage, .errorSummary {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <h3>Url shorter</h3>
        <div class="info">

            <?php if(Yii::app()->user->hasFlash('short')): ?>

                <div class="flash-success">
                    <?php echo Yii::app()->user->getFlash('short'); ?>
                </div>

                <div>
                    <a href="<?php echo Yii::app()->getBaseUrl(true),'/',$model->shorten; ?>"><?php echo Yii::app()->getBaseUrl(true),'/',$model->shorten; ?></a>
                </div>

            <?php else: ?>

            <div class="form">

                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'shorten-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>

                <p class="note">Fields with <span class="required">*</span> are required.</p>

                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <?php echo $form->labelEx($model,'url'); ?>
                    <?php echo $form->textField($model,'url'); ?>
                    <?php echo $form->error($model,'url'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'shorten'); ?>
                    <?php echo $form->textField($model,'shorten'); ?>
                    <?php echo $form->error($model,'shorten'); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Submit'); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->

            <?php endif; ?>
        </div>
    </div>
</body>
</html>