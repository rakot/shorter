<?php

    class IndexController extends Controller
    {
        public $layout = '//layouts/common';

        public function actionIndex()
        {
            $model=new ShortForm;
            if(isset($_POST['ShortForm']))
            {
                $model->attributes=$_POST['ShortForm'];
                if($model->validate())
                {
                    if($url = $model->saveUrl()) {
                        $model->shorten = $url->shorten;
                        Yii::app()->user->setFlash('short','Shorten URL successfully created.');
                    }
                }
            }
            $this->render('index',array('model'=>$model));
        }

        public function actionRedirecter($shorten) {


            if($shorten) {
                $url = Url::model()->findByAttributes(array(
                    'shorten' => $shorten
                ));
                if($url) {
                    $url->used += 1;
                    $url->save();
                    $this->redirect($url->url);
                    return 1;
                }
            }

            throw new CHttpException(404,'The specified post cannot be found.');
        }
    }