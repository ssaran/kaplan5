<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 8.11.2018
 * Time: 13:14
 */

namespace K5\Unity\Phalcon;

use K5\Ui;
use K5\U;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class BaseController extends  \Phalcon\Mvc\Controller
{

    public string $issuer_key = '';
    public string $SessionDomain = '';
    public ?string $SubDomain;
    public string $App;
    public string $Module;

    public function initialize()
    {

    }

    public function GetHtmlPacket($content,$domId,$mode='content-add',$domDestination='layout_content',$k5Destination='layout_content')
    {
        $html = new \K5\Entity\View\Html();
        $html->Content = $content;
        $html->DomID = $domId;
        $html->DomDestination = $domDestination;
        $html->K5Destination = $k5Destination;
        $html->Mode = $mode;
        return $html;
    }

    public function GetJavascriptPacket($content,$domId,$refresh=false,$mode='add',$k5Type='documentReady')
    {
        $js = new \K5\Entity\View\Javascript();
        $js->Content = $content;
        $js->DomID = $domId;
        $js->K5Type = $k5Type;
        $js->Refresh = ($refresh) ? $refresh : false;
        $js->Mode = ($mode) ? $mode : '';
        return $js;
    }

    public function GetJavascriptLibPacket($content,$domId,$refresh=false)
    {
        $js = new \K5\Entity\View\JavascriptLib();
        $js->Content = $content;
        $js->DomID = $domId;
        $js->Refresh = ($refresh) ? $refresh : false;

        return $js;
    }

    public function GetCssPacket($content,$domId,$refresh=false,$mode=false)
    {
        $css = new \K5\Entity\View\Css();
        $css->Content = $content;
        $css->DomID = $domId;
        $css->Refresh = ($refresh) ? $refresh : false;
        return $css;
    }

    public function GetModalPacket(string $content,string $domId,?string $title=null,?string $footer=null,
                                   string $size='medium',string $close= 'right', ?string $callback=null)
    {
        $e = new \K5\Entity\View\BsModal();
        $e->DomID = $domId;
        $e->Modal_DomID = $domId;
        $e->Modal_Body = $content;
        $e->Modal_Title = $title;
        $e->Modal_Footer = $footer;
        $e->Modal_Size = $size;
        $e->Modal_Close = $close;
        $e->Modal_Callback = $callback;

        return $e;
    }

    public function GetTabTitlePacket($title,$tabId='main') : \K5\Entity\View\Element
    {
        $html = new \K5\Entity\View\Element();
        $html->Content = $title;
        $html->DomID = $tabId;
        $html->Type = 'tab_title';
        return $html;
    }

    public function GetDataPacket($content,$domID = 'data') : \K5\Entity\View\Element
    {
        $html = new \K5\Entity\View\Element();
        $html->Content = json_encode($content);
        $html->DomID = $domID;
        $html->Type = 'data';
        return $html;
    }

    public function CurlFetch(string $url,array $fields=[],array $headers=[],string $method='post')
    {
        try {
            $raw = \K5\Http\Curl::Exec([
                'url'=> $url,
                'method'=> $method,
                'headers'=> $headers,
                'fields'=>$fields
            ]);

            if(empty($raw)) {
                throw new \Exception("Empty Service Response \n");
            }
            $resp = json_decode($raw);
            if(!isset($resp->payload) ||!isset($resp->payload->record)) {
                \K5\U::lerr("Bad Response ".print_r($resp,true));
                throw new \Exception("Bad Response \n".print_r($resp,true));
            }
            return $resp->payload->record;
        } catch (\Throwable $e) {
            \K5\U::lerr($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function encodeToken($data)
    {
        // Encode token
        $token_encoded = $this->jwt->encode($data, $this->globalConfig->authentication->secret);
        //$token_encoded = $this->crypt->encryptBase64($token_encoded);
        //$token_encoded = $this->crypt->encrypt($token_encoded);
        //return base64_encode($token_encoded);
        return $token_encoded;
    }

    /**
     * @param $token
     * @return bool|string
     */
    public function decodeToken($token)
    {
        // Decode token
        //$token = base64_decode($token);
        //$token = $this->crypt->decryptBase64($token);
        //$token = $this->crypt->decrypt($token);
        $token = $this->jwt->decode($token, $this->globalConfig->authentication->secret, array('HS256'));
        return $token;
    }

    public function GetErrorResponse(\K5\Http\Response $r)
    {
        return new \K5\Http\Response\Error($r::$Message,$r::$Title,$r::$Footer,$r::$ForwardUri,$r::$Ext,$r::$Method,$r::$Params,$r::$IDForm,$r::$Type,$r::$WsPackage);
    }

    public function GetSuccessResponse(\K5\Http\Response $r)
    {
        return new \K5\Http\Response\Success($r::$Message,$r::$Title,$r::$Footer,$r::$ForwardUri,$r::$Ext,$r::$Method,$r::$Params,$r::$IDForm,$r::$Data,$r::$IDModal,$r::$IDReload,$r::$WsPackage);
    }

    public function HandleResponse($response)
    {
        if(is_a($response, '\K5\Http\Response\Success')) {
            $this->__handleSuccess($response);
        } else if(is_a($response, '\K5\Http\Response\Error')) {
            $this->__handleError($response);
        } else if(is_a($response, '\K5\Http\Response\Nll')) {

        } else if(is_a($response, '\stdClass')) {
            Ui::AppendStd($response);
        } else {
            Ui::Append($response);
        }
    }

    private function __handleSuccess(\K5\Http\Response\Success $response)
    {
        if(!is_null($response->ForwardUri)) {
            Ui::AjaxCall($response->ForwardUri, $response->Method, $response->Params);
        }

        if(!is_null($response->IDForm)) {
            Ui::JSResetForm($response->IDForm);
        }

        if(!is_null($response->Message)) {
            Ui::JSNotify($response->Message,"success");
        }

        if(!is_null($response->WsPackage)) {
            Ui::SendWsPackage($response->WsPackage);
        }

        if(!is_null($response->IDReload)) {
            Ui::JSReloadFromDomID($response->IDReload);
        }

        if(!is_null($response->IDModal)) {
            Ui::JSCloseModal($response->IDModal);
        }

        if(!is_null($response->Ext)) {
            Ui::PrepareJavascriptContent($response->Ext,'js_exec_'.U::randomChars(8,true),'add','','documentReady');
        }
        return true;
    }

    private function __handleError(\K5\Http\Response\Error $response)
    {

        if (!is_null($response->ForwardUri)) {
            Ui::AjaxCall($response->ForwardUri, $response->Method, $response->Params);
        }

        if (!is_null($response->IDForm)) {
            Ui::JSResetForm($response->IDForm);
        }

        if (!is_null($response->Ext)) {
            Ui::PrepareJavascriptContent($response->Ext, 'js_exec_' . U::randomChars(8, true),'add','','documentReady');
        }

        if(!is_null($response->WsPackage)) {
            Ui::SendWsPackage($response->WsPackage);
        }

        switch ($response->Type) {
            case EXCEPTION_TYPE_LOGIC:
                Ui::JSAlert($response->Message,$response->Title, $response->Footer,'error');
                break;

            case EXCEPTION_TYPE_SQL:
                Ui::JSError($response->Message,'SQL Hatası', $response->Footer,'large');
                break;
            case EXCEPTION_TYPE_ERROR:
            default:
                Ui::JSError($response->Message,false, $response->Footer,'large');
                break;
        }
        return true;
    }

    /**
     * @param $frontUser
     * @param $apiName
     * @param $module
     * @param $controller
     * @param $action
     * @return bool
     */
    protected function checkPermission($frontUser,$apiName,$module,$controller,$action)
    {
        if(is_null($frontUser)) {
            $this->response->redirect('/');
            return false;
        }

        if(!isset($frontUser->rights)) { return false; }

        if(!isset($frontUser->rights->resources)) { return false; }

        if(!isset($frontUser->rights->resources[$apiName])) { return false; }

        $apiRes = $frontUser->rights->resources[$apiName];

        if(!isset($apiRes[$module])) { return false; }

        if(!isset($apiRes[$module][$controller])) { return false; }

        if(!isset($apiRes[$module][$controller][$action])) { return false; }

        $perm = $apiRes[$module][$controller][$action];
        if($perm < 10) {return false;}

        return $perm;
    }

    /**
     * @param $content
     * @param $httpCode
     */
    public function SendResponse($content,$httpCode)
    {
        /*
        $trace = debug_backtrace();
        $caller = $trace[1];

        \K5\U::linfo($this->request->getHeaders());
        \K5\U::linfo("Called by {$caller['function']}");
        if (isset($caller['class'])) {
            \K5\U::linfo(" in {$caller['class']}");
        }*/

        $httpStatus = '501';
        switch ($httpCode) {
            case "200": $httpStatus = 'OK'; break;
            case "201": $httpStatus = 'Created'; break;
            case "202": $httpStatus = 'Accepted'; break;
            case "204": $httpStatus = 'No Content'; break;
            case "400": $httpStatus = 'Bad Request'; break;
            case "401": $httpStatus = 'Unauthorized'; break;
            case "403": $httpStatus = 'Forbidden'; break;
            case "404": $httpStatus = 'Not Found'; break;
            case "405": $httpStatus = 'Method Not Allowed'; break;
            case "406": $httpStatus = 'Not Acceptable'; break;
            case "412": $httpStatus = 'Precondition Failed'; break;
            case "415": $httpStatus = 'Unsupported Media Type'; break;
            case "500": $httpStatus = 'Internal Server Error'; break;
            case "501": $httpStatus = 'Not Implemented'; break;
        }

        $intCode = (integer) $httpCode;
        if($intCode > 205) {
            \K5\U::lerr($_REQUEST);
        }

        $this->response->setStatusCode($httpCode, $httpStatus)->sendHeaders();
        $this->response->setContentType('application/json', 'UTF-8');
        //$this->response->setJsonContent($content, JSON_NUMERIC_CHECK)->send();
        $this->response->setJsonContent($content)->send();
        die();
    }

}
