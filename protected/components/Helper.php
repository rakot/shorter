<?php



class Helper
{
    static function translit($str)
    {
//        $str = mb_strtolower($str,'UTF-8');
        $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "Ts", "Ч" => "Ch",
            "Ш" => "Sh", "Щ" => "Sch", "Ъ" => "", "Ы" => "Y", "Ь" => "",
            "Э" => "E", "Ю" => "Yu", "Я" => "Ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "_", "." => "", "/" => "", "," => ""
        );
        $str = strtr($str, $tr);
        $str = preg_replace('/[^a-zA-Z0-9]/',' ',$str);
        return preg_replace('/[^a-zA-Z0-9]{2,}/',' ',$str);
    }

    static function url_translit($str)
    {
        $str = mb_strtolower($str,'UTF-8');
        $tr = array(
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g",
            "Д" => "d", "Е" => "e", "Ё" => "e", "Ж" => "j", "З" => "z", "И" => "i",
            "Й" => "y", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",
            "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
            "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "ts", "Ч" => "ch",
            "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "y", "Ь" => "",
            "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "_", "." => "", "/" => "", "," => ""
        );
        $str = strtr($str, $tr);
        $str = preg_replace('/[^a-zA-Z0-9]/','_',$str);
        return preg_replace('/[^a-zA-Z0-9]{2,}/','_',$str);
    }

    static function invert($str)
    {
        $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "Ts", "Ч" => "Ch",
            "Ш" => "Sh", "Щ" => "Sch", "Ъ" => "", "Ы" => "Y", "Ь" => "",
            "Э" => "E", "Ю" => "Yu", "Я" => "Ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",


            'Ght' => 'Йт',
            'ght' => 'йт',

            'Sch' => 'Ш',
            'sch' => 'ш',

            'Sh'  => 'Ш',
            'sh'  => 'ш',

            'Ch'  => 'Ч',
            'ch'  => 'ч',

            'Ee'  => 'И',
            'ee'  => 'и',

            'Th'  => 'З',
            'th'  => 'з',

            'Ck'  => 'К',
            'ck'  => 'к',

            'Wh'  => 'Уа',
            'wh'  => 'уа',

            'A'   => 'А',
            'a'   => 'а',

            'B'   => 'Б',
            'b'   => 'б',

            'C'   => 'К',
            'c'   => 'к',

            'D'   => 'Д',
            'd'   => 'д',

            'E'   => 'Е',
            'e'   => 'е',

            'F'   => 'Ф',
            'f'   => 'ф',

            'G'   => 'Г',
            'g'   => 'г',

            'H'   => 'Х',
            'h'   => 'х',

            'I'   => 'И',
            'i'   => 'и',

            'J'   => 'Дж',
            'j'   => 'дж',

            'K'   => 'К',
            'k'   => 'к',

            'L'   => 'Л',
            'l'   => 'л',

            'M'   => 'М',
            'm'   => 'м',

            'N'   => 'Н',
            'n'   => 'н',

            'O'   => 'О',
            'o'   => 'о',

            'P'   => 'П',
            'p'   => 'п',

            'Q'   => 'К',
            'q'   => 'к',

            'R'   => 'Р',
            'r'   => 'р',

            'S'   => 'С',
            's'   => 'с',

            'T'   => 'Т',
            't'   => 'т',

            'U'   => 'У',
            'u'   => 'у',

            'V'   => 'В',
            'v'   => 'в',

            'W'   => 'В',
            'w'   => 'в',

            'X'   => 'Кс',
            'x'   => 'кс',

            'Y'   => 'Ы',
            'y'   => 'ы',

            'Z'   => 'З',
            'z'   => 'з',
        );
        return strtr($str, $tr);
    }

    /**
     * Awesome helper function from Kohana <3
     *
     * @static
     * @param array $arr
     * @param string $key
     * @param null $default
     * @return mixded
     */
    public static function ArrGet(&$arr, $key, $default = null)
    {
        return (isset($arr[$key])) ? $arr[$key] : $default;
    }

    public static function AddFileSuffix($file, $suffix)
    {
        return preg_replace('/\.[^\.]{3,4}$/', $suffix.'${0}', $file);
    }

    public static function format_bytes($a_bytes)
    {
        if ($a_bytes < 1024) {
            return $a_bytes .' B';
        } elseif ($a_bytes < 1048576) {
            return round($a_bytes / 1024, 2) .' KB';
        } elseif ($a_bytes < 1073741824) {
            return round($a_bytes / 1048576, 2) . ' MB';
        } else{
            return round($a_bytes / 1073741824, 2) . ' GB';
        }
    }

    public static function format_meters($m)
    {
        if($m < 1000) return $m.'м';
        $km = floor($m/1000);
        $m = $m%1000;
        if($m == 0) return $km.'км';
        return $km.'км '.$m.'м';
    }

    public static function format_hour($s)
    {
        return gmdate("H:i:s", $s);
    }

    public static function createDirs($dir, $name, $symbols=3, $parts=3)
    {
        if(!is_dir($dir))
        {
            throw new Exception('Папка '.$dir.' не существует');
        }
        if(!is_writable($dir))
        {
            throw new Exception('Папка '.$dir.' не доступна для записи');
        }
        for($i=0;$parts>$i;$i++)
        {
            $dirPart = substr($name,$i*$symbols,$symbols);
            $dir .= $dirPart.'/';
            if(!file_exists($dir))
            {
                mkdir($dir);
                chmod($dir,0777);
            }
        }
        return $dir.$name;
    }

    public static function getSubDirs($name, $symbols=3, $parts=3)
    {
        $dir = '';
        for($i=0;$parts>$i;$i++)
        {
            $dirPart = substr($name,$i*$symbols,$symbols);
            $dir .= $dirPart.'/';
        }
        return $dir.$name;
    }
}