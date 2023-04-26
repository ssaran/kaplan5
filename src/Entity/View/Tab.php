<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 18.02.2018
 * Time: 14:26
 */

namespace K5\Entity\View;


class Tab extends Element
{
    public $Type = 'tabs';
    public $Mode = 'content-add';
    public $DomDestination = 'layout_content';
    public $K5Destination = 'layout_content';
    public $Wrap = false;
}