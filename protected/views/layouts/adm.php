<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="language" content="ru" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap_cerulean.min.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />

    <?php if(isset(Yii::app()->params['brandBg'])):?>
    <style type="text/css">
        body {
            background: url("<?php echo Yii::app()->params['brandBg'];?>") center center fixed;
        }
    </style>
    <?php endif;?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script>
        base_path = '<?php echo Yii::app()->request->baseUrl; ?>/';
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin.js"></script>
</head>

<body>


<div class="navbar">
    <div class="navbar-inner">
        <div class="container" style="width: auto;">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/admin/">
                <?php if(isset(Yii::app()->params['brandLogo'])):?>
                <img src="<?php echo Yii::app()->params['brandLogo']?>" alt="logo" />
                <?php else:?>
                <?php echo CHtml::encode(Yii::app()->name); ?>
                <?php endif;?>
            </a>
            <div class="nav-collapse">
                <?php $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>'Эти пункты', 'url'=>array('/admin/User')),
                        array('label'=>'Можно изменить', 'url'=>array('/admin/Run')),
                        array('label'=>'В файле', 'url'=>array('/admin/interestingFact')),
                        array('label'=>'/protected/views/layouts/adm.php', 'url'=>array('/admin/interestingFact')),
                    ),
                    'htmlOptions' => array(
                        'class' => 'nav'
                    ),
                )); ?>
                <ul class="nav pull-right">
                <?php $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>'Exit ('.Yii::app()->user->name.')', 'url'=>array('/site/logout/'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                    'htmlOptions' => array(
                        'class' => 'nav'
                    ),
                )); ?>
                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->


<div class="container" id="page">
    <div id="backend-content">
        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
        <?php endif?>

        <?php echo $content; ?>
    </div>

	<div id="footer">
        <table class="table" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td id="footer-l"></td>
                <td id="footer-b">
                    Copyright &copy; <?php echo date('Y'); ?> by Sergey Vardanyan.<br/>
                    All Rights Reserved.<br/>
                </td>
                <td id="footer-r"></td>
            </tr>
        </table>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>