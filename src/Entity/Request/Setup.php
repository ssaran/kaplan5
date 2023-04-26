<?php


namespace K5\Entity\Request;

use K5\U as u;

class Setup
{
    public string $SessionDomain;
    public $Config = false;
    public $ApiPrefix = false;
    public $IsApi = false;
    public $Employer = false;
    public $TemplatesDir = false;
    public $DomDestination = false;
    public $IsModal = false;
    public $IsTab = false;
    public $IsAjax = false;
    public $IsMobile = false;
    public $IsIframe = false;
    public bool $IsData = false;
    public $Controller = '';
    public $Action = '';
    public $Permission = 0;
    public $Fields;
    public $Sanitized = [];
    public $Locale = 'tr_TR';
    public $i18n = 'tr';

    public $Dom = '';
    public $Css = '';
    public $Routes = '';
    public $Page = 1;
    public $BaseUrl = '';
    public $DateStart = '';
    public $DateEnd = '';
    public $TimeStart = '';
    public $TimeEnd = '';
    public $Post = [];
    public $Get = [];
    public $Decoded = [];

    /** @var \Common\Entity\Auth\FrontUser */
    public $Frontuser;

    public function __construct(array $options=[])
    {
        foreach ($options as $k =>$v) {
            if(isset($this->{$k})) {
                $this->{$k} = $v;
            } else {
                \K5\Log::Error("Setup Parameter Not Found ".$k);
            }
        }
    }
}