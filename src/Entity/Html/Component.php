<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:10
 */

namespace K5\Entity\Html;


class Component
{
    public string $DomID;
    public string $DomDestination;
    public string $Type;
    public string $K5Type = 'lib';
    public ?string $Content;
    public bool $Refresh = false;
    public ?string $ApiPrefix = null;
    public ?string $Employer = null;
}
