<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\Html\Resource;


class Css extends \K5\Entity\Html\Component
{
    public string $Type = 'css';
    public string $Mode = 'add';
    public bool $Refresh = false;
    public bool $Embed = true;
    public bool $Defer = false;
}

