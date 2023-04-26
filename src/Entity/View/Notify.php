<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\View;


class Notify extends Element
{
    public $Type = 'notify';
    public $Mode = 'content-append';
    public $DomDestination = false;
    public $Wrap = false;
    public $Icon = '';
    public $Title = '';
    public $Message = '';
    public $Url = '';
    public $Target = '_blank';

}

