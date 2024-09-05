<?php

namespace K5\Entity\Request;

class Route
{
    public string $sessionDomain;
    public string $domain;
    public ?string $subDomain = null;
    public string $app;
    public string $module;
    public ?string $deep;
    public ?string $extension = null;
    public string $controller;
    public string $action;
    public string $namespace;
    public ?string $i18n = null;
    public bool $isApi = false;
    public bool $isService = false;
    public array $params = [];
    public bool $hasCms = false;
    public ?string $cmsDomain = null;
    public array $tmp = [];
}


