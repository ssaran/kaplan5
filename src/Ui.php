<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 8.3.2015
 * Time: 11:29
 */

namespace K5;

use \K5\U as u;

class Ui
{
    CONST K5_LOC_HEADER = 'layout_header';
    CONST K5_LOC_SUBHEADER = 'layout_subHeader';
    CONST K5_LOC_CONTENT= 'layout_content';
    CONST K5_LOC_LEFT = 'layout_left';
    CONST K5_LOC_RIGHT = 'layout_right';
    CONST K5_LOC_FOOTER = 'layout_footer';

    private static array $_pageMeta = [];
    private static array $_pageVars = [];
    private static array $_output = [];
    private static $_layout = '';
    private static bool $_isAjax = false;
    private static bool $_isCMS = false;
    private static int $_bootstrapVersion = 4;
    private static string $_documentType = 'application/json';

    public static function SetDocumentType($dType) : void
    {
        self::$_documentType = $dType;
    }

    public static function GetDocumentType() : string
    {
        return self::$_documentType;
    }

    public static function SetAjax($ajax)
    {
        self::$_isAjax = $ajax;
    }

    public static function GetIsAjax()
    {
        return self::$_isAjax;
    }

    public static function SetCms(bool $isCms) : void
    {
        self::$_isCMS = $isCms;
    }

    public static function GetIsCms() : bool
    {
        return self::$_isCMS;
    }

    public static function SetBootstrapVersion(int $ver = 4) : void
    {
        self::$_bootstrapVersion = $ver;
    }

    public static function GetBootstrapVersion() : int
    {
        return self::$_bootstrapVersion;
    }

    public static function SetLayout($layout) : void
    {
        self::$_layout = $layout;
    }

    public static function SetCanvas($layout) : void
    {
        self::$_layout = $layout;
    }

    public static function ClearOutput() : void
    {
        Ui::$_output = [];
    }

    public static function Append($element) : void
    {
        if(isset($element->DomID)) {
            Ui::$_output[$element->DomID] = $element;
        } else {
            if(is_array($element)) {
                foreach($element as $e) {
                    Ui::$_output[$e->DomID] = $e;
                }
            }
        }
    }

    public static function AppendStd($element) : void
    {
        Ui::$_output = (array) $element;
    }

    public static function GetOutput($isAjax=false) : array
    {
        $ret = Ui::$_output;
        Ui::ClearOutput();
        if(self::$_isAjax) {
            return $ret;
        }

        $parsed = self::_parseForHTTP($ret,$isAjax);
        $layout = new self::$_layout();

        return [
            'content'=> $layout->Render($parsed['html']),
            'CSSHeader'=> $parsed['css'],
            'CSSHeaderEmbed'=> $parsed['css_embed'],
            'CSSForced'=> $parsed['css_forced'],
            'JSHeader'=>$parsed['js']['header'],
            'JSHeaderEmbed'=>$parsed['js']['embed_header'],
            'JSHeaderForced'=>$parsed['js']['forced_header'],
            'JSEmbed'=>$parsed['js']['embed'],
            'JSLib'=>$parsed['js']['link'],
            'JSForced'=>$parsed['js']['forced'],
            'JSDocumentReady'=>$parsed['js']['documentReady'],
            'JSInject'=>$parsed['js']['inject'],
        ];
    }

    public static function PrepareJavascriptContent($content,$domID=false,$mode='add',$refresh=false,$k5Type='link')
    {
        $js = new \K5\Entity\View\Javascript();
        $js->DomID = $domID;
        $js->Content = $content;
        $js->Mode = $mode;
        $js->K5Type = $k5Type;
        $js->Refresh = $refresh;
        $js->IsHashed = false;
        $r = [];
        $r[$js->DomID] = $js;
        self::Append($r);
    }


    public static function JSResetForm($idForm)
    {
        $key = U::randomChars(8,true);
        $content = "
                Main.resetForm('".$idForm."');
";
        self::PrepareJavascriptContent($content, 'reset_form_'.$key,'add','','documentReady');
    }

    public static function JSAlert($message,$title='',$footer='',$type='sucess')
    {
        $message = addslashes(str_replace( "\n", '<br>', $message));
        $title = str_replace( "\n", '<br>', $title);
        $footer = str_replace( "\n", '<br>', $footer);
        $key = U::randomChars(8,true);
        $content = '     
                Util.JSAlert("'.$title.'","'.$message.'","'.$footer.'","'.strtolower($type).'");
';
        self::PrepareJavascriptContent($content, 'js_alert_'.$key,'add','','documentReady');
    }

    public static function JSError($message,$title='',$footer='',$modalSize='medium')
    {
        $message = addslashes(str_replace( "\n", '<br>', $message));
        $title = str_replace( "\n", '<br>', $title);
        if(!empty($footer)) {
            $footer = str_replace( "\n", '<br>', $footer);
        }

        $key = U::randomChars(8,true);
        $content = '
            Util.JSAlert("mid_'.$key.'","'.$title.'","'.$message.'","'.$footer.'","'.$modalSize.'");
';
        self::PrepareJavascriptContent($content, 'js_alert_'.$key,'add','','documentReady');
    }

    public static function JSNotify($message,$type='info')
    {
        $message = addslashes(str_replace( "\n", '<br>', $message));
        $key = U::randomChars(8,true);
        $content = '
                Util.JSNotify("'.$message.'","'.$type.'")
';
        self::PrepareJavascriptContent($content, 'js_notify_'.$key,'add','','documentReady');
    }

    public static function JSCloseModal($modalID)
    {
        $key = U::randomChars(8,true);
        $content = '
                $("#'.$modalID.'").modal("hide");
';
        self::PrepareJavascriptContent($content, 'js_closemodal_'.$key,'add','','documentReady');
    }

    public static function SendWsPackage($package)
    {
        $key = U::randomChars(8,true);
        $content = '
                if (typeof myWs !== "undefined") {
                    let __msg = JSON.parse(\''.json_encode($package).'\');
                    myWs.sendPackage(__msg);
                } else {
                    console.error("myWs not found");
                    console.error(window.myWS);
                }
';
        self::PrepareJavascriptContent($content, 'js_sendWsPackage_'.$key,'add','','documentReady');
    }

    public static function JSReloadFromDomID($modalID)
    {
        $key = U::randomChars(8,true);
        $content = '
                Ui.xhrCallFromDomElement("'.$modalID.'");
';
        self::PrepareJavascriptContent($content, 'js_JSRealodFromDomID_'.$key,'add','','documentReady');
    }

    public static function AjaxCall($url,$type,$data,$ext='',$isNoHistory=false)
    {
        if(!$isNoHistory) {
            $content = "
                Main.xhrCall('".$url."','".$type."','json',".json_encode($data).");
";
        } else {
            $content = "
                Main.xhrCall('".$url."','".$type."','json',".json_encode($data).",false);
";
        }

        $content.=$ext;
        $key = U::randomChars(8,true);

        Ui::PrepareJavascriptContent($content, 'ajax_call_'.$key,'add','','documentReady');
    }

    private static function _parseForHTTP($_output,$isAjax=false)
    {
        $r = [];
        $r['css'] = [];
        $r['css_embed'] = [];
        $r['css_forced'] = [];
        $r['js']['embed'] = [];
        $r['js']['embed_header'] = [];
        $r['js']['forced_header'] = [];
        $r['js']['link'] = [];
        $r['js']['forced'] = [];
        $r['js']['header'] = [];
        $r['js']['inject'] = [];
        $r['js']['documentReady'] = [];
        $r['html'] = [];

        if(!is_iterable($_output)) {
            return $r;
        }

        foreach($_output as $o){

            if(is_a($o,'K5\Entity\View\Javascript')) {
                switch ($o->K5Type) {
                    case "link":
                    case "lib":
                        $r['js']['link'][] = '<script src="'.$o->Content.'"></script>';
                        if(!$o->Embed) {
                            $r['js']['forced'][] = '<script src="'.$o->Content.'"></script>';
                        } else {
                            $r['js']['embed'][] = $o->Content;
                        }
                        break;

                    case "head":
                        $r['js']['header'][] = '<script src="'.$o->Content.'"></script>';
                        if(!$o->Embed) {
                            $r['js']['forced_header'][] = '<script src="'.$o->Content.'"></script>';
                        } else {
                            $r['js']['embed_header'][] = $o->Content;
                        }
                        break;

                    case "inject":
                        $r['js']['inject'][] = $o->Content;
                        break;

                    case "documentReady":
                        $r['js']['documentReady'][] = $o->Content;
                        break;
                }

            }
            if(is_a($o,'K5\Entity\View\Css')) {
                $r['css'][] = '<link rel="stylesheet" href="' . $o->Content . '">';
                if(!$o->Embed) {
                    $r['css_forced'][] = '<link rel="stylesheet" href="' . $o->Content . '">';
                } else {
                    $r['css_embed'][] = $o->Content;
                }
            }

            if(is_a($o,'K5\Entity\View\Html')) {
                $r['html'][$o->K5Destination][] = $o->Content;
            }

            if(is_a($o,'K5\Entity\View\JavascriptLib')) {
                $r['js']['link'][] = '<script src="'.$o->Content.'"></script>';
                if(!$o->Embed) {
                    $r['js']['forced'][] = '<script src="'.$o->Content.'"></script>';
                } else {
                    $r['js']['embed'][] = $o->Content;
                }
            }
        }

        return $r;
    }

    /**
     * setMeta#
     * assign html data to page layout location
     */
    public static function setMeta($key = "-", $data = "")
    {
        self::$_pageMeta[$key][] = $data;
    }

    /**
     * setOMeta#
     * assign html data to page layout location
     */
    public static function setOMeta($key = "-", $data = "")
    {
        self::$_pageMeta['other'][$key][] = $data;
    }

    /**
     * getMeta#
     * get page layout location data
     */
    public static function getMeta($key = false)
    {
        return ($key !== false and isset(self::$_pageMeta[$key])) ? implode(" " ,self::$_pageMeta[$key]) : '';
    }

    /**
     * getOMeta#
     * get page layout location data
     */
    public static function getOMeta()
    {
        $r = '';
        if(isset(self::$_pageMeta['other']) && sizeof(self::$_pageMeta['other'] > 0)) {
            foreach(self::$_pageMeta['other'] as $k => $v) {
                $r.= "\t<meta ".$k." content=\"".implode(" ",str_replace(array('"','\'')," ",$v))."\" />\n";
            }
        }
        return $r;
    }

    /**
     * @param string $key
     * @param string $data
     */
    public static function setVar($key = "-", $data = "")
    {
        self::$_pageVars[$key] = $data;
    }

    /**
     * @param bool $key
     * @return string
     */
    public static function getVar($key = false)
    {
        return ($key !== false && isset(self::$_pageVars[$key])) ? self::$_pageVars[$key] : '';
    }

    public static function getAllVars()
    {
        return self::$_pageVars;
    }
}
