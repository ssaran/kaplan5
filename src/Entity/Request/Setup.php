<?php


namespace K5\Entity\Request;

class Setup
{
    public \Phalcon\Config\Config $Config;
    public ?string $BaseUrl = null;
    public ?string $SessionDomain = null;
    public int $Page = 1;

    public ?\K5\Entity\Request\Headers $Headers;
    public ?\K5\Entity\Request\Route $Route;
    public ?string $Permission;
    public string $Locale = 'tr_TR';
    public string $i18n = 'tr';

    public ?\K5\Entity\Dom\IdKeys $Dom;
    public ?\K5\Entity\Dom\ClassKeys $Css;
    public ?\K5\Component\Route $Routes;
    public ?\K5\Component\RequestFields $Fields;
    public ?array $Decoded = [];
    public ?array $RequestParams = [];
    public array $Sanitized = [];
    public array $Options = [];

    public $Frontuser;
}
