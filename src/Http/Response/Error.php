<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 15.01.2018
 * Time: 11:18
 */

namespace K5\Http\Response;


class Error
{
    public $Type = 10;
    public $Title = '';
    public $Message = '';
    public $Footer = '';
    public $Params = [];
    public $ForwardUri = '';
    public $Method = 'GET';
    public $Ext = '';
    public $IDForm = null;
    public $WsPackage;
    public $Headers = [];

    public function __construct($Message='',$Title='',$Footer='',$ForwardUri='',$Ext='',$Method='GET',$Params=[],$IDForm=null,$Type=10,$WsPackage=null,$Headers=[])
    {
        $this->Type = $Type;
        $this->Title = $Title;
        $this->Message = $Message;
        $this->Footer = $Footer;
        $this->Params = $Params;
        $this->ForwardUri = $ForwardUri;
        $this->Method = $Method;
        $this->Ext = $Ext;
        $this->IDForm = $IDForm;
        $this->WsPackage = $WsPackage;
        $this->Headers = $Headers;
    }
}
