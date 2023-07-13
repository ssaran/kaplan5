<?php


namespace K5\Entity\Request;

class Setup
{

    public $Config = false;
    public ?string $ApiPrefix;
    public bool $IsApi = false;
    public ?string $Employer;
    public ?string $DomDestination;
    public ?string $IsModal;
    public ?string $IsTab;
    public bool $IsAjax = false;
    public bool $IsIframe = false;
    public ?string $IsData;
    public ?string $IsCommon;
    public ?string $Controller;
    public ?string $Action;
    public ?string $Permission;
    public $Fields;
    public $Sanitized = [];
    public $Locale = 'tr_TR';
    public $i18n = 'tr';

    public string $SessionDomain;
    public \K5\Entity\View\Dom\Keys $Dom;
    public \K5\Entity\View\Dom\ClassKeys $Css;
    public \K5\Component\Route $Routes;
    public int $Page = 1;
    public string $BaseUrl;
    public array $Post = [];
    public array $Get = [];
    public array $Decoded = [];
    public array $RequestParams = [];


    public $Frontuser;

    public function __construct(array $options=[])
    {
        foreach ($options as $k =>$v) {
            if(isset($this->{$k})) {
                $this->{$k} = $v;
            } else {
                \K5\U::lerr("Setup Parameter Not Found ".$k);
            }
        }
    }
}