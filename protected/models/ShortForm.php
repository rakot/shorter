<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ShortForm extends CFormModel
{
    public $url;
    public $shorten;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('url', 'required'),
            array('url', 'validUrlCode'),
            // verifyCode needs to be entered correctly
            array('shorten', 'safe'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'shorten'=>'Short string',
        );
    }

    public function validUrlCode($attribute,$params)
    {
        try {
            $ch = curl_init($this->$attribute);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            if(curl_errno($ch))
            {
                $this->addError($attribute, 'Wrong URL');
            } else {
                $info = curl_getinfo($ch);
                $code = (int)$info['http_code'];
                if($code >= 200 && $code < 300) {
                    // OK
                } else {
                    $this->addError($attribute, 'Wrong URL(Code)');
                }
            }
            curl_close($ch);
        //$this->$attribute
        } catch(Exception $e) {
            $this->addError($attribute, 'Wrong URL');
        }
    }

    public function saveUrl() {
        $url = new Url();
        $url->created_at = time();
        $url->used = 0;
        $url->url = $this->url;

        if($this->shorten) {
            $url->shorten = $this->shorten;
            if($url->save()) {
                return $url;
            } else {
                $this->addError('shorten', 'Short string already taken');
            }
        } else {
            $max_try = 10;
            $url_str = $this->url;
            while(!$url->validate() && $max_try--) {
                $url->shorten = $this->generateShortFromLong($url_str);
                $url_str .= rand(1000, 9999);
            }

            if($url->save()) {
                return $url;
            } else {
                $this->addError('shorten', 'Something went wrong');
            }
        }

        return false;
    }

    protected function generateShortFromLong($long) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $count = strlen($alphabet);

        $long = md5($long);
        $short_str = '';
        for($i = 0; $i < 9 ; $i++) {
            $dec = hexdec(substr($long,$i*4, 4));
            $short_str .= $alphabet[$dec%$count];
        }

        return $short_str;
    }
}