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
        $layout = is_object(self::$_layout) ? new self::$_layout() : new \K5\Helper\BaseLayout();

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
            'PageHead'=>$parsed['page_head'],
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

    /**
     * @param $content
     * @param $domId
     * @param $mode
     * @param $domDestination
     * @param $k5Destination
     * @return Entity\View\Html
     */
    public static function GetHtmlPacket($content,$domId,$mode='content-add',$domDestination='layout_content',$k5Destination='layout_content') : \K5\Entity\View\Html
    {
        $html = new \K5\Entity\View\Html();
        $html->Content = $content;
        $html->DomID = $domId;
        $html->DomDestination = $domDestination;
        $html->K5Destination = $k5Destination;
        $html->Mode = $mode;
        return $html;
    }

    /**
     * @param $content
     * @param $domId
     * @param $refresh
     * @param $mode
     * @param $k5Type
     * @return Entity\View\Javascript
     */
    public static function GetJavascriptPacket($content,$domId,$refresh=false,$mode='add',$k5Type='documentReady') : \K5\Entity\View\Javascript
    {
        $js = new \K5\Entity\View\Javascript();
        $js->Content = $content;
        $js->DomID = $domId;
        $js->K5Type = $k5Type;
        $js->Refresh = ($refresh) ? $refresh : false;
        $js->Mode = ($mode) ? $mode : '';
        return $js;
    }

    /**
     * @param $content
     * @param $domId
     * @param $refresh
     * @return Entity\View\JavascriptLib
     */
    public static function GetJavascriptLibPacket($content,$domId,$refresh=false) : \K5\Entity\View\JavascriptLib
    {
        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $content;
        $js->DomID = $domId;
        $js->Refresh = ($refresh) ? $refresh : false;

        return $js;
    }

    /**
     * @param $content
     * @param $domId
     * @param $refresh
     * @param $mode
     * @return Entity\View\Css
     */
    public static function GetCssPacket($content,$domId,$refresh=false,$mode=false) : \K5\Entity\View\Css
    {
        $css = new \K5\Entity\View\Css();
        $css->Content = $content;
        $css->DomID = $domId;
        $css->Refresh = ($refresh) ? $refresh : false;
        return $css;
    }

    /**
     * @param string $content
     * @param string $domId
     * @param string|null $title
     * @param string|null $footer
     * @param string $size
     * @param string $close
     * @param string|null $callback
     * @return Entity\View\BsModal
     */
    public static function GetModalPacket(string $content,string $domId,?string $title=null,?string $footer=null,
                                   string $size='medium',string $close= 'right', bool $isIframe=false) : \K5\Entity\View\BsModal
    {
        $e = new \K5\Entity\View\BsModal();
        $e->DomID = $domId;
        $e->Modal_DomID = $domId;
        $e->Modal_Body = $content;
        $e->Modal_Title = $title;
        $e->Modal_Footer = $footer;
        $e->Modal_Size = $size;
        $e->Modal_Close = $close;
        $e->IsIframe = $isIframe;

        return $e;
    }

    /**
     * @param $title
     * @param $tabId
     * @return Entity\View\Element
     */
    public static function GetTabTitlePacket($title,$tabId='main') : \K5\Entity\View\Element
    {
        $html = new \K5\Entity\View\Element();
        $html->Content = $title;
        $html->DomID = $tabId;
        $html->Type = 'tab_title';
        return $html;
    }

    /**
     * @param $content
     * @param $domID
     * @return Entity\View\Element
     */
    public static function GetDataPacket($content,$domID = 'data') : \K5\Entity\View\Element
    {
        $html = new \K5\Entity\View\Element();
        $html->Content = json_encode($content);
        $html->DomID = $domID;
        $html->Type = 'data';
        return $html;
    }

    /**
     * @param string $content
     * @return Entity\View\Element
     */
    public static function GetHeadLine(string $content) : \K5\Entity\View\Element
    {
        $html = new \K5\Entity\View\HeadLine();
        $html->Content = $content;
        $html->DomID = '-';
        $html->Type = 'head_line';
        return $html;
    }

    public static function JSResetForm($idForm) : void
    {
        $key = U::randomChars(8,true);
        $content = "
                Main.resetForm('".$idForm."');
";
        self::PrepareJavascriptContent($content, 'reset_form_'.$key,'add','','documentReady');
    }

    public static function JSAlert($message,$title='') : void
    {
        $message = addslashes(str_replace( "\n", '<br>', $message));
        $title = str_replace( "\n", '<br>', $title);
        $key = U::randomChars(8,true);
        $content = '     
                Modal5.Alert("'.$message.'","'.$title.'");
';
        self::PrepareJavascriptContent($content, 'js_alert_'.$key,'add','','documentReady');
    }

    public static function JSError($message,$title='',$size='small') : void
    {
        $message = addslashes(str_replace( "\n", '<br>', $message));
        $title = str_replace( "\n", '<br>', $title);
        $key = U::randomChars(8,true);
        $content = '
            Modal5.Error("'.$message.'","'.$title.'","'.$size.'");
';
        self::PrepareJavascriptContent($content, 'js_alert_'.$key,'add','','documentReady');
    }

    public static function JSNotify($message,$type='info') : void
    {
        $message = addslashes(str_replace( "\n", '<br>', $message));
        $key = U::randomChars(8,true);
        $content = '
                Util.JSNotify("'.$message.'","'.$type.'")
';
        self::PrepareJavascriptContent($content, 'js_notify_'.$key,'add','','documentReady');
    }

    public static function JSCloseModal($modalID) : void
    {
        $key = U::randomChars(8,true);
        $content = '
                var _modal = bootstrap.Modal.getInstance(document.getElementById("'.$modalID.'"));
                if(_modal !== null) {
                    _modal.hide();
                }
';
        self::PrepareJavascriptContent($content, 'js_closemodal_'.$key,'add','','documentReady');
    }

    public static function SendWsPackage($package) : void
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

    public static function JSReloadFromDomID($modalID) : void
    {
        $key = U::randomChars(8,true);
        $content = '
                Ui.xhrCallFromDomElement("'.$modalID.'");
';
        self::PrepareJavascriptContent($content, 'js_JSRealodFromDomID_'.$key,'add','','documentReady');
    }

    public static function AjaxCall($url,$type,$data,$headers=[]) : void
    {
        $_data = is_null($data) ? '{}' : json_encode($data);
        $_headers = (count($headers) < 1) ?  '{}' : '{'.implode(",",$headers).'}';
        Ui::PrepareJavascriptContent("\nMain.jxCall('".$url."','".$type."',".$_data.",".$_headers.");\n",
            'ajax_call_'.U::randomChars(8,true),'add','','documentReady');
    }

    private static function _parseForHTTP($_output,$isAjax=false) : array
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
        $r['page_head'] = [];

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
                $r['js']['link'][] = '<script src="'.$o->Content.'" '.$o->JsType.'></script>';
                if(!$o->Embed) {
                    $r['js']['forced'][] = '<script src="'.$o->Content.'" '.$o->JsType.'></script>';
                } else {
                    $r['js']['embed'][] = $o->Content;
                }
            }

            if(is_a($o,'K5\Entity\View\HeadLine')) {
                $r['page_head'][] = $o->Content;
            }
        }

        return $r;
    }

    /**
     * setMeta#
     * assign html data to page layout location
     */
    public static function setMeta($key = "-", $data = "") : void
    {
        self::$_pageMeta[$key][] = $data;
    }

    /**
     * setOMeta#
     * assign html data to page layout location
     */
    public static function setOMeta($key = "-", $data = "") : void
    {
        self::$_pageMeta['other'][$key][] = $data;
    }

    /**
     * getMeta#
     * get page layout location data
     */
    public static function getMeta($key = false) : string
    {
        return ($key !== false and isset(self::$_pageMeta[$key])) ? implode(" " ,self::$_pageMeta[$key]) : '';
    }

    /**
     * getOMeta#
     * get page layout location data
     */
    public static function getOMeta() : string
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
     * @param $data
     * @return void
     */
    public static function setVar(string $key = "-", $data = null) : void
    {
        self::$_pageVars[$key] = $data;
    }

    /**
     * @param string $key
     * @return string
     */
    public static function getVar(string $key) : string
    {
        return ($key !== false && isset(self::$_pageVars[$key])) ? self::$_pageVars[$key] : '';
    }

    public static function getAllVars() : array
    {
        return self::$_pageVars;
    }
}
