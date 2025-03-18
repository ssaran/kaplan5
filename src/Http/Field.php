<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 7.01.2020
 * Time: 11:08
 */

namespace K5\Http;


class Field
{
    const FILTER_ABSINT     = "absint";
    const FILTER_ALNUM      = "alnum";
    const FILTER_ALPHA      = "alpha";
    const FILTER_BOOL       = "bool";
    const FILTER_EMAIL      = "email";
    const FILTER_FLOAT      = "float";
    const FILTER_INT        = "int";
    const FILTER_INT_CAST   = "int!";
    const FILTER_LOWER      = "lower";
    const FILTER_STRING     = "stringlegacy";
    const FILTER_STRIPTAGS  = "striptags";
    const FILTER_TRIM       = "trim";
    const FILTER_UPPER      = "upper";

    public string $key;
    public $default_value;
    public ?array $filter = null;
    public bool $on_database = true;
    public bool $on_request = true;

    public \K5\Http\Field\FormElement $form_element;

}
