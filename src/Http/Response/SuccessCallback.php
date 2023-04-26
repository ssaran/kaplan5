<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 15.01.2018
 * Time: 11:18
 */

namespace K5\Http\Response;


class SuccessCallback
{
    public $Title = '';
    public $Message = '';
    public $Footer = '';
    public $Params = [];
    public $ForwardUri = '';
    public $Method = 'GET';
    public $Ext = '';
    public $IDForm = null;
    public $Data = null;

    public function __construct(array $options=[])
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
    }
}
