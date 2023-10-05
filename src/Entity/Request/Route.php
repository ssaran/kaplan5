<?php

namespace K5\Entity\Request;

class Route
{
    public string $domain;
    public string $subDomain;
    public string $sessionDomain;
    public string $app;
    public string $module;
    public string $extension;
    public string $controller;
    public string $action;
    public string $namespace;
    public string $i18n;
    public bool $isApi;
    public array $params;
}


