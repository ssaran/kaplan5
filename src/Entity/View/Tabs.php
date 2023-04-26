<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 18.02.2018
 * Time: 14:26
 */

namespace K5\Entity\View;


class Tabs extends Element
{
    public $Title = '';
    public $Type = 'tabs';
    public $Mode = 'content-add';
    public $DomID = 'layout_content';
    public $TabId = 'main';
    public $DomDestination = 'layout_content';
    public $K5Destination = 'layout_content';
}