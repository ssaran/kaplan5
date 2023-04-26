<?php


namespace K5\Http;


class Field
{
    const FILTER_ABSINT     = "absint";
    const FILTER_ALPHANUM   = "alphanum";
    const FILTER_EMAIL      = "email";
    const FILTER_FLOAT      = "float";
    const FILTER_FLOAT_CAST = "float!";
    const FILTER_INT        = "int";
    const FILTER_INT_CAST   = "int!";
    const FILTER_LOWER      = "lower";
    const FILTER_STRING     = "stringlegacy";
    const FILTER_STRIPTAGS  = "striptags";
    const FILTER_TRIM       = "trim";
    const FILTER_UPPER      = "upper";

    public $key;
    public $filter;
    /** @var \K5\Http\Field\Database */
    public $database;
    public $validation;
    /** @var \K5\Http\Field\FormElement */
    public $form_element;
    public $default_value;



}