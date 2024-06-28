<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 7.10.2019
 * Time: 14:24
 */

namespace K5\Helper;

class Asset
{

    /**
     * @param \K5\Entity\View\BaseAsset $collection
     * @param bool $refreshJs
     * @param bool $refreshCss
     * @return \K5\Entity\View\BaseAsset
     */
    public static function Base(\K5\Entity\View\BaseAsset $collection,bool $refreshJs=false,bool $refreshCss=false,$prefix='/vendor/ssaran') : \K5\Entity\View\BaseAsset
    {
        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/main.js";
        $js->DomID = "JsLib_k5_main";
        $js->Refresh = $refreshJs;
        $collection->Append($js);


        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/util.js";
        $js->DomID = "JsLib_k5_util";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/modal.js";
        $js->DomID = "JsLib_k5_modal";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/modal5.js";
        $js->DomID = "JsLib_k5_modal5";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/toast.js";
        $js->DomID = "JsLib_k5_toast";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/ui.js";
        $js->DomID = "JsLib_k5_ui";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/tpl.js";
        $js->DomID = "JsLib_k5_tpl";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/helper/Paginator.js";
        $js->DomID = "JsLib_k5_Paginator";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $prefix."/k5/js/Module.js";
        $js->DomID = "JsLib_k5_Module_Base";
        $js->Refresh = $refreshJs;
        $js->Defer = true;
        $collection->Append($js);

        return $collection;
    }
}


