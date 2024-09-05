<?php


namespace K5\Entity\Request;

class Setup
{
    public \Phalcon\Config\Config $Config;
    public ?string $BaseUrl;
    public bool $IsAjax = false;
    public bool $IsApi = false;
    public int $Page = 1;

    public ?\K5\Entity\Request\Headers $Headers;
    public ?\K5\Entity\Request\Route $Route;
    public ?string $Permission;
    public string $Locale = 'tr_TR';
    public string $i18n = 'tr';

    public ?\K5\Entity\View\Dom\Keys $Dom;
    public ?\K5\Entity\View\Dom\ClassKeys $Css;
    public ?\K5\Component\Route $Routes;
    public ?\K5\Component\RequestFields $Fields;
    public ?array $Decoded = [];
    public ?array $RequestParams = [];
    public array $Sanitized = [];
    public array $Options = [];

    public $Frontuser;
}
