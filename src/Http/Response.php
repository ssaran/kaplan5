<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 15.01.2018
 * Time: 11:18
 */

namespace K5\Http;

class Response
{
    public static $Title;
    public static $Message;
    public static $Footer;
    public static $ForwardUri;
    public static $Method = 'POST';
    public static $Params;
    public static $Ext;
    public static $IDForm;
    public static $IDModal;
    public static $IDReload;
    public static $Type;
    public static $Data;
    public static $WsPackage;


    private static $_instance = null;

    private function __construct () { }

    public static function GetInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function GetErrorMessage(\Exception $e,$isDevel,$extra='')
    {
        self::$Message = $extra." ".preg_replace('/\v+|\\\r\\\n/Ui','<br/>',$e->getMessage());; ;
        self::$Footer = ($isDevel) ?  $e->getFile()."<br>".$e->getLine() : '';
        self::$Type = $e->getCode();
        return $this;
    }

    public function SetErrorMessage(string $msg)
    {
        self::$Message =  $msg;
        self::$Footer = '';
        self::$Type = '';
        return $this;
    }

    public function SetMessage($message)
    {
        self::$Message = $message;
        return $this;
    }

    public function SetWsPackage($package)
    {
        self::$WsPackage = $package;
        return $this;
    }

    public function SetForwardUri($uri)
    {
        self::$ForwardUri = $uri;
        return $this;
    }

    public function SetMethod($method)
    {
        self::$Method = $method;
        return $this;
    }

    public function SetParams($params)
    {
        self::$Params = $params;
        return $this;
    }

    public function SetJSExec($js)
    {
        self::$Ext = $js;
        return $this;
    }

    public function SetFormIDForReset($idForm)
    {
        self::$IDForm = $idForm;
        return $this;
    }

    public function ResetForm($idForm)
    {
        self::$IDForm = $idForm;
        return $this;
    }

    public function CloseModal($idModal)
    {
        self::$IDModal = $idModal;
        return $this;
    }

    public function ReloadUI($idReloadUI)
    {
        self::$IDReload = $idReloadUI;
        return $this;
    }

    public function SetData($data)
    {
        self::$Data = $data;
        return $this;
    }
}
