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

        $setup = \Common\Helper\RequestSanitizer::Exec($setup,$_f,$_REQUEST,$_fields);
        $post = $setup->Post;

        $san = [];
        foreach($post as $k => $v) {
            if(isset($setup->Sanitized[$k])) {
                $san[$k] = $setup->Sanitized[$k];
            }
        }
        $setup->Post = $san;


        $get = $setup->Get;
        $san = [];
        foreach($get as $k => $v) {
            if(isset($setup->Sanitized[$k])) {
                $san[$k] = $setup->Sanitized[$k];
            }
        }
        $setup->Get = $san;

        return $setup;
    }
}