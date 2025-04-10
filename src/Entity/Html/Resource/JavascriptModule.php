<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 09.04.2018
 * Time: 11:23
 */

namespace K5\Entity\Html\Resource;

class JavascriptModule extends \K5\Entity\Html\Component
{
    public string $Type = 'js_module';
    public string $Mode = 'add';
    public string $K5Type = 'js_module';
    public ?string $JsType = null;
    public bool $Refresh = false;
    public bool $IsHashed = false;
    public bool $Embed = true;
    public bool $Defer = false;

    public bool $Async = false;
}

