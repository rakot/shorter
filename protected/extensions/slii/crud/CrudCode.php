<?php

class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $baseControllerClass='AdminController';
    public $modelObject;

    protected $_rules;

	private $_modelClass;
	private $_table;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter'=>'trim'),
			array('model, controller, baseControllerClass', 'required'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_]\w*$/', 'message'=>'{attribute} should only contain word characters.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('model', 'validateModel'),
			array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'baseControllerClass'=>'Base Controller Class',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		return "The controller has been generated successfully. You may $link.";
	}

	public function validateModel($attribute,$params)
	{
		if($this->hasErrors('model'))
			return;
		$class=@Yii::import($this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		else if(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			else if(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
                $this->modelObject = CActiveRecord::model($class);
                $this->_rules = $this->modelObject->rules();
			}
		}
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				$this->files[]=new CCodeFile(
					$this->viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		}
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
        if($enum = $this->isEnum($column))
        {
            return "CHtml->activeCheckBox(\$model,'{$column->name}',array({$enum}))";
        }
        else if(substr($column->dbType,0,3)==='int' && substr($column->name,-8) === 'datetime')
        {
            return "CHtml::activeTextField(\$model,'{$column->name}',array('value'=>date('H:i:s d.m.Y',(\$model->{$column->name}) ? \$model->{$column->name} : time())))";
        }
        else if(substr($column->dbType,0,3)==='int' && substr($column->name,-4) === 'date')
        {
            return "CHtml::activeTextField(\$model,'{$column->name}',array('value'=>date('d.m.Y',(\$model->{$column->name}) ? \$model->{$column->name} : time())))";
        }
        else if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		else if(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}')";
	}

	public function generateActiveField($modelClass,$column)
	{
        if($relation = $this->isRelatedColumn($column->name))
        {
            if($relation[0] === CActiveRecord::HAS_ONE || $relation[0] === CActiveRecord::BELONGS_TO)
            {
                $list = "CHtml::listData(".$relation[1]."::model()->findAll(), '".CActiveRecord::model($relation[1])->tableSchema->primaryKey."', '".$this->selectNameColumn($relation[1])."')";
//                return "\$form->dropDownList(\$model,'{$column->name}', ".$list."  )";
                return "'';?>
        <div class=\"input-append\">
            <?php echo \$form->textField(\$model,'id_user',array()); ?>
        <span class=\"add-on pupup-search\" data-popup=\"User\"><i class=\"icon-search\"></i></span></div><?php ";
            }
        }
        if($enum = $this->isEnum($column))
        {
            return "\$form->dropDownList(\$model,'{$column->name}',array({$enum}))";
        }
        else if(substr($column->dbType,0,3)==='int' && substr($column->name,-8) === 'datetime')
        {
            return "\$form->textField(\$model,'{$column->name}',array('maxlength'=>20,'value'=>date('H:i:s d.m.Y',(\$model->{$column->name}) ? \$model->{$column->name} : time())))";
        }
        else if(substr($column->dbType,0,3)==='int' && substr($column->name,-4) === 'date')
        {
            return "\$form->textField(\$model,'{$column->name}',array('maxlength'=>20,'value'=>date('d.m.Y',(\$model->{$column->name}) ? \$model->{$column->name} : time())))";
        }
		else if($column->type==='boolean')
			return "\$form->checkBox(\$model,'{$column->name}')";
		else if(stripos($column->dbType,'text')!==false)
			return "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordField';
            else if(substr($column->name,-5) === 'image')
            {
                return "\$form->fileField(\$model,'file_{$column->name}')";
            }
			else
				$inputField='textField';

			if($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}

    public function selectNameColumn($class)
    {
        $class = CActiveRecord::model($class);
        if(method_exists($class,'nameColomn') && $class->nameColomn())
        {
            return $class->nameColomn();
        }
        else
        {
            return $this->guessNameColumn($class->tableSchema->columns);
        }
    }

    protected function isRelatedColumn($name)
    {
        $related = $this->modelObject->relations();
        foreach($related as $relName => $relation)
        {
            if(isset($relation[2]) && $relation[2] === $name)
            {
                $relation['relationName'] = $relName;
                return $relation;
            }
        }
        return false;
    }

    protected function isEnum($col)
    {
        foreach($this->_rules as $rule)
        {
            if($rule[1] === 'in')
            {
                $attributes=preg_split('/[\s,]+/',$rule[0],-1,PREG_SPLIT_NO_EMPTY);
                foreach($attributes as $attr)
                {
                    if(strcasecmp($attr,$col->name) === 0)
                    {
                        $enum = array();
                        foreach($rule['range'] as $val)
                        {
                            $enum[] = "'$val'=>Yii::t('admin','$val')";
                        }
                        return implode(',',$enum);
                    }
                }
            }
        }
        return false;
    }
    public function getImageFields()
    {
        $images = array();
        foreach($this->getTableSchema()->columns as $col)
        {
            if((substr($col->name,-5) === 'image'))
            {
                $images[] = '"'.$col->name.'"';
            }
        }
        return implode(', ',$images);
    }
}