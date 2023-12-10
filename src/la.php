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

    private static string $lang;

    public static function Setup($keys,$values,$lang='Tr') : void
    {
        self::$keys = $keys;
        self::$values = $values;
        self::$lang = $lang;
    }

    public static function GetLanguage() : string
    {
        return self::$lang;
    }

    public static function ng($key) : string
    {
        if(!property_exists(self::$keys,$key)) {
            return "?".$key;
        }
        if(!property_exists(self::$values,$key)) {
            return "!".$key;
        }
        /*if(!isset(self::$keys->{$key})) {
            return "?".$key;
        }

        if(!isset(self::$values->{$key})) {
            return "!".$key;
        }
        */
        if(empty(self::$values->{$key})) {
            return ":".$key;
        }
        return self::$values->{$key};
    }

    public static function ToJs() : array
    {
        $r = [];
        foreach(self::$values as $k => $v)
        {
            $r[$k] = '"'.$k.'":"'.$v.'"';
        }
        return $r;
    }
}