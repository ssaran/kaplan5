<?php
/**
 * User: Sancar Saran
 * Base
 * Date: 2.9.2017
 * Time: 11:28
 */

namespace K5\Helper;

class InitModule
{
    /**
     * @param \K5\Entity\Request\Setup $setup
     * @param string $route_class
     * @param string $dom_class
     * @param string $css_class
     * @param string $module
     * @param string $issuer
     * @return \K5\Entity\Request\Setup
     */
    public static function Exec(\K5\Entity\Request\Setup $setup, string $route_class,
                                string $dom_class, string $css_class, string $module,string $issuer)
    {
        /** INIT MODULE !!! */
        if($setup->Headers->Employer == $issuer) {
            $setup->Headers->Employer = '';
        }

        $setup->Headers->ApiPrefix = ($issuer !== '' ) ? $issuer.'_' : '';
        $setup->Headers->ApiPrefix = (!empty($setup->Headers->Employer)) ? $setup->Headers->Employer.'_'.$setup->Headers->ApiPrefix : $setup->Headers->ApiPrefix;



        $setup->Dom = \K5\V::ParseDom(new $dom_class(),"",$setup->Headers->ApiPrefix);
        $setup->Css = \K5\V::ParseCss(new $css_class(),"",$setup->Headers->ApiPrefix);
        $setup->Routes = \K5\PreRouter::ParseDefault(new $route_class());

        return $setup;
    }
}
