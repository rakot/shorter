<?php

/**
 * This is the model class for table "urls".
 *
 * The followings are the available columns in table 'urls':
 * @property string $id_urls
 * @property string $url
 * @property string $shorten
 * @property string $used
 * @property string $created_at
 */
class Url extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Url the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'urls';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shorten, created_at', 'required'),
			array('url', 'length', 'max'=>2000),
			array('shorten', 'length', 'max'=>10),
			array('shorten', 'unique'),
			array('used, created_at', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_urls, url, shorten, used, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_urls' => 'Id Urls',
			'url' => 'Url',
			'shorten' => 'Shorten',
			'used' => 'Used',
			'created_at' => 'Created At',
		);
	}

    /**
     * Return Model name in needed case
     */
    public static function getInCase($plural = true,$case = 'nominative')
    {
        $data = array(
            'singular' => array(
                'nominative' => 'Url',
                'accusative' => 'Url', //Идёт после слова Удалить
            ),
            'plural' => array(
                'nominative' => 'Urls',
                'accusative' => 'Urls', //Идёт после слова Список
            ),
        );
        if($plural)
        {
            return $data['plural'][$case];
        }
        else
        {
            return $data['singular'][$case];
        }
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_urls',$this->id_urls,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('shorten',$this->shorten,true);
		$criteria->compare('used',$this->used,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}