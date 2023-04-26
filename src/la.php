<?php
/*
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 26.11.2019
 * Time: 8:43
 */

class la
{
    /** @var \Common\Lang\keys */
    public static $keys;
    public static $values;

    private static $lang;

    public static function Setup($lang='Tr')
    {
        self::$keys = new \Common\Lang\Keys();
        self::$values = new \stdClass();
        self::$lang = $lang;
        self::LoadValues($lang);
    }

    public static function GetLanguage()
    {
        return self::$lang;
    }

    public static function ng($key)
    {
        if(!isset(self::$keys->{$key})) {
            return "?".$key;
        }

        if(!isset(self::$values->{$key})) {
            return "!".$key;
        }

        if(empty(self::$values->{$key})) {
            return ":".$key;
        }
        return self::$values->{$key};
    }

    public static function LoadValues($lang='Tr')
    {
        $vClass = '\Common\Lang\\'.$lang;
        if(class_exists($vClass)) {
            self::$values = new $vClass();
        }
    }

    public static function ToJs()
    {
        $r = [];
        foreach(self::$values as $k => $v)
        {
            $r[$k] = '"'.$k.'":"'.$v.'"';
        }
        return $r;
    }
}