<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 16.10.2019
 * Time: 10:34
 */

namespace K5\Entity\Config;

class Html
{
    public $DomPrefix;
    public $DomDestination;
    public $Employer = "self";
    public $DomElements = [];
    public $IsModal = false;
    public $CallerClass = null;
    public $Fields = [];
    public $Routes = [];
    public $Labels = [];
    public $Lookup = [];
    public $Record;

    public function __construct()
    {

    }
}
