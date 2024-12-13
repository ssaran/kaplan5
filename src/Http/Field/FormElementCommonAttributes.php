<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 7.01.2020
 * Time: 13:35
 */


namespace K5\Http\Field;


class FormElementCommonAttributes
{
    public ?string $id = null;
    public ?string $placeholder = null;
    public ?string $class = null;
    public ?string $title = null;
    public ?string $alt = null;
    public bool $autocomplete = true;
    public ?string $autofocus = null;
    public ?string $checked = null;
    public ?string $disabled = null;
    public ?string $required = null;
    public ?int $max = null;
    public ?int $maxlength = null;
    public ?int $min = null;
    public ?int $minlength = null;
    public ?string $pattern = null;
    public ?string $readonly = null;
    public ?int $size = null;
    public ?int $tabindex = null;
    public ?string $step = null;

    public ?string $oninput = null;
    public ?string $onclick = null;
    public ?string $onfocus = null;
    public ?string $onblur = null;
}
