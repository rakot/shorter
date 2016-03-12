<?php

Yii::import('zii.widgets.grid.CGridView');

    class MyGridView extends EExcelView {

        public $exportText = 'Скачать в формате: ';
        public $exportButtons = array('CSV');

        public function init()
        {
            $this->htmlOptions['class'] = 'my-grid-view';

            parent::init();
        }

        public function renderItems()
        {
            $this->htmlOptions['class'] = 'my-grid-view';

            foreach($this->columns as $column)
            {
                $column->headerHtmlOptions = array('class' => 'navbar navbar-inner');
            }

            parent::renderItems();
        }

        public function renderSummary()
        {
            $this->renderExportButtons();
            return parent::renderSummary();
        }
    }