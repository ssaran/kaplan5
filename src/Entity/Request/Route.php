<?php

namespace K5\Entity\Request;

class Route
{
    public ?string $sessionDomain = null;
    public ?string $domain =null;
    public ?string $subDomain = null;
    public string $app;
    public string $controller = 'index';
    public string $action = 'index';
    public string $routeType = 'simplex';
    public string $namespace;
    public ?string $i18n = null;
    public bool $isApi = false;
    public bool $isService = false;
    public array $params = [];
    public bool $hasCms = false;
    public ?string $cmsDomain = null;
    public array $tmp = [];
}


