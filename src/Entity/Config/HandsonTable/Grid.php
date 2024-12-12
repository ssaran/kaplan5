<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 14:37
 */

namespace K5\Entity\Config\HandsonTable;


class Grid
{
    public string $DomDestination = 'layout_content';
    public string $ExportPrefix = 'Export';
    public $HotObject;
    public $HotDomSelector;
    public $Fields;
    public $Routes;
    public $DomElements;
    public string $width='100%';
    public string $height='100%';
    public $Disable;
    public string $licensekey='non-commercial-and-evaluation';
    public $RequestAppend;
    public $Components;
    public $Employer;
    public array $Labels = [];
}
