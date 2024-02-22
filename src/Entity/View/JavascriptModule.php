<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 09.04.2018
 * Time: 11:23
 */

namespace K5\Entity\View;

class JavascriptModule extends Element
{
    public string $Type = 'js_module';
    public string $Mode = 'js_module';
    public bool $Refresh = false;
    public bool $IsHashed = false;
    public bool $Embed = true;
}

