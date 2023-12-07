<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 15.01.2018
 * Time: 11:18
 */

namespace K5\Http\Response;


class Success
{
    public $Title = '';
    public $Message = '';
    public $Footer = '';
    public $Params = [];
    public $ForwardUri = '';
    public $Method = 'GET';
    public $Ext = '';
    public $IDForm = null;
    public $IDModal = null;
    public $IDReload = null;
    public $Data = null;
    public $WsPackage = null;
    public $Headers = [];

    public function __construct($Message='',$Title='',$Footer='',$ForwardUri='',$Ext='',$Method='GET',$Params=[],$IDForm=null,$Data=null,$IDModal=null,$IDReload=null,$WsPackage=null,$headers=[])
    {
        $this->Title = $Title;
        $this->Message = $Message;
        $this->Footer = $Footer;
        $this->Params = $Params;
        $this->ForwardUri = $ForwardUri;
        $this->Method = $Method;
        $this->Ext = $Ext;
        $this->IDForm = $IDForm;
        $this->Data = $Data;
        $this->IDModal = $IDModal;
        $this->IDReload = $IDReload;
        $this->WsPackage = $WsPackage;
        $this->Headers = $headers;
    }
}
