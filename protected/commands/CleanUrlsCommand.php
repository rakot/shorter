<?php

class CleanUrlsCommand extends CConsoleCommand
{
    public function actionIndex() {
        $maxTime = time() - (60*60*24*15);

        $sql = "DELETE FROM urls WHERE created_at < $maxTime";

        Yii::app()->db->createCommand($sql)->execute();

        return 'OK';
    }
}