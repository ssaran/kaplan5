<?php


namespace K5\Entity\Request;

class Setup
{
    public $Frontuser;
    public \Phalcon\Config\Config $Config;

    public bool $IsApi = false;
    public bool $IsAjax = false;
    public ?string $ApiPrefix;
    public ?string $Employer;
    public ?string $DomDestination;
    public ?string $ActiveTabId = null;
    public ?string $IsModal;
    public ?string $IsIframe;
    public ?string $IsData;
    public ?string $IsCommon;
    public ?string $IsComponent;
    public ?string $Controller;
    public ?string $Action;
    public ?string $Permission;

    public array $Sanitized = [];
    public string $Locale = 'tr_TR';
    public string $i18n = 'tr';

    public string $SessionDomain;
    public ?\K5\Entity\View\Dom\Keys $Dom;
    public ?\K5\Entity\View\Dom\ClassKeys $Css;
    public ?\K5\Component\Route $Routes;
    public ?\K5\Component\RequestFields $Fields;
    public int $Page = 1;
    public ?string $BaseUrl;
    public ?array $Decoded = [];
    public ?array $RequestParams = [];
}