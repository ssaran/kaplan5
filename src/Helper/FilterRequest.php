<?php
/**
 * User: Sancar Saran
 * Base
 * Date: 2.9.2017
 * Time: 11:28
 */

namespace K5\Helper;

use K5\Entity\Request\Setup;

class FilterRequest
{
    /**
     * @param Setup $setup
     * @param array $fields
     * @return Setup
     */
    public static function Exec(Setup $setup, array $fields) : Setup
    {
        $_f = new \Phalcon\Filter\FilterFactory();
        $_fields = [];
        foreach ($fields as $field) {
            $_fields = \K5\U::Entity2Array(new $field($setup),$_fields);
        }

        $setup = self::_requestSanitizer($setup,$_f,$_REQUEST,$_fields);

        /*
        $post = $_POST;

        $san = [];
        foreach($post as $k => $v) {
            if(isset($setup->Sanitized[$k])) {
                $san[$k] = $setup->Sanitized[$k];
            }
        }
        //$setup->Post = $san;


        $get = $_GET;
        $san = [];
        foreach($get as $k => $v) {
            if(isset($setup->Sanitized[$k])) {
                $san[$k] = $setup->Sanitized[$k];
            }
        }
        //$setup->Get = $san;
        */

        return $setup;
    }

    private static function _requestSanitizer (\K5\Entity\Request\Setup $setup,\Phalcon\Filter\FilterFactory $filter,$request,$fields) : \K5\Entity\Request\Setup
    {
        /**
         * @var  $f
         * @var  $field \K5\Http\Field
         */
        foreach ($fields as $f => $field) {
            $_s = false;
            if(isset($request[$f])) {
                $_l = $filter->newInstance();
                $_s = $_l->sanitize($request[$f],$field->filter);
            } else {
                if(isset($field->default_value)) {
                    $_s = $field->default_value;
                } else {
                    //\K5\U::linfo("".$f." |-------------------------------");
                }
            }
            $setup->Sanitized[$f] = $_s;
        }
        return $setup;
    }
}