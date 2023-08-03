<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\View;


class JavascriptLib extends Element
{
    public string $Type = 'js_lib';
    public string $Mode = 'add';
    public string $K5Type = 'js_lib';
    public ?string $JsType = null;
    public bool $Refresh = false;
    public bool $IsHashed = false;
    public bool $Embed = true;
}

