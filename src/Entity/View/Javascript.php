<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\View;


class Javascript extends Element
{
    public string $Type = 'js';
    public string $Mode = 'add';
    public bool $Refresh = false;
    public bool $IsHashed = false;
    public bool $Embed = true;
    public bool $Defer = false;
}

