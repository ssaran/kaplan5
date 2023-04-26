<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\View;


class Html extends Element
{
    public string $Type = 'html';
    public string $Mode = 'content-add';
    public string $DomDestination = 'layout_content';
    public string $K5Destination = 'layout_content';
    public bool $Wrap = false;
}