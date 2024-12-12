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

        return self::_requestSanitizer($setup,$_f,$_REQUEST,$_fields);
    }

    private static function _requestSanitizer (\K5\Entity\Request\Setup $setup,\Phalcon\Filter\FilterFactory $filter,$request,$fields) : \K5\Entity\Request\Setup
    {
        foreach ($fields as $f => $field) {
            $_s = false;
            if(isset($request[$f])) {
                $_l = $filter->newInstance();
                $_s = $_l->sanitize($request[$f],$field->filter);
            } else {
                if(isset($field->default_value)) {
                    $_s = $field->default_value;
                }
            }
            $setup->Sanitized[$f] = $_s;
        }
        return $setup;
    }
}
