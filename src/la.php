<?php
/*
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 26.11.2019
 * Time: 8:43
 */

class la
{
    public static object $keys;
    public static array $values;
    private static string $lang;

    /**
     * @param object $keys
     * @param array $values
     * @param string $lang
     * @return void
     */
    public static function Setup(object $keys,array $values,string $lang = 'tr') : void
    {
        self::$keys = $keys;
        self::$values = $values;
        self::$lang = $lang;
    }

    public static function GetLanguage() : string
    {
        return self::$lang;
    }

    public static function ng(string $key) : string
    {
        if(!property_exists(self::$keys,$key)) {
            return "?".$key;
        }
        if(!isset(self::$values[$key])) {
            return "!".$key;
        }
        if(empty(self::$values[$key])) {
            return ":".$key;
        }
        return self::$values[$key];
    }
    public static function ToJs() : array
    {
        $r = [];
        foreach(self::$values as $k => $v) {
            $r[$k] = '"'.$k.'":"'.$v.'"';
        }
        return $r;
    }
}
