<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 8.11.2018
 * Time: 13:12
 */

namespace K5\Entity\Config;


class Module
{
    public $DomPrefix;
    public $RouteBase;
    public $DomDestination;
    public $Employer = "self";
    public $CallerClass = null;
    public $IsModal = false;
    public $DomElements = [];
    public $Fields = [];
    public $Routes = [];
    public $Labels = [];
    public $Lookup = [];
    public $Record;

    public function __construct($domPrefix,$routeBase,$employer=false)
    {
        $this->DomPrefix = $domPrefix;
        $this->Employer = (!$employer) ? $domPrefix : $employer;
        $this->RouteBase = $routeBase;
    }
}
