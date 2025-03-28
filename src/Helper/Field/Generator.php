<?php

namespace K5\Helper\Field;

use Phalcon\Db\Column;

class Generator
{
    /**
     * @param string $name
     * @param bool $isPrimary
     * @param bool $isNullable
     * @param string|null $class
     * @return \K5\Http\Field
     */
    public static function GetUUID(string $name,bool $isPrimary=false,bool $isNullable=false,?string $class='form-control') :  \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->filter[] = \K5\Http\Field::FILTER_STRIPTAGS;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
        );

        $field->form_element->attributes->maxlength = 36;
        $field->form_element->attributes->minlength = 36;

        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = \la::ng(\la::$keys->company_account_id_placeholder);

        if(!$isNullable) {
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_PRESENCE] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_PRESENCE,\la::ng(\la::$keys->should_not_be_empty));
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH,null);
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->max = 36;
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->min = 36;
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->messageMaximum = \la::ng(\la::$keys->cannot_be_more_than_characters);
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->messageMinimum = \la::ng(\la::$keys->cannot_be_less_than_characters);
        }

        return $field;
    }

    /**
     * @param string $name
     * @param bool $isPrimary
     * @param bool $isNullable
     * @param string|null $class
     * @return \K5\Http\Field
     */
    public static function GetMUUID(string $name,bool $isPrimary=false,bool $isNullable=false,?string $class='form-control') :  \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->filter[] = \K5\Http\Field::FILTER_STRIPTAGS;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
        );


        $field->form_element->attributes->maxlength = 50;
        $field->form_element->attributes->minlength = 36;

        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = \la::ng(\la::$keys->company_account_id_placeholder);

        if(!$isNullable) {
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_PRESENCE] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_PRESENCE,\la::ng(\la::$keys->should_not_be_empty));
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH,null);
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->max = 50;
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->min = 36;
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->messageMaximum = \la::ng(\la::$keys->cannot_be_more_than_characters);
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->messageMinimum = \la::ng(\la::$keys->cannot_be_less_than_characters);
        }

        return $field;
    }

    /**
     * @param $name
     * @param $isPrimary
     * @return \K5\Http\Field
     */
    public static function GetIntID($name,$isPrimary=false) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
        );
        $field->form_element->attributes->id = $field->key;

        return $field;
    }

    /**
     * @param string $name
     * @param bool $isUnsigned
     * @return \K5\Http\Field
     */
    public static function GetTinyInt(string $name,int $default=0, bool $isUnsigned=false) : \K5\Http\Field
    {
        return self::dGetTinyInt($name,$default,$isUnsigned);
    }

    /**
     * @param string $name
     * @param $default
     * @param bool $isUnsigned
     * @return \K5\Http\Field
     */
    public static function dGetTinyInt(string $name,$default=0,bool $isUnsigned=false) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = $default;
        $field->filter[] = \K5\Http\Field::FILTER_INT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $default
        );
        $field->form_element->attributes->id = $field->key;
        if($isUnsigned) {
            $field->form_element->attributes->max = 127;
            $field->form_element->attributes->min = -128;
        } else {
            $field->form_element->attributes->max = 254;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    /**
     * @param string $name
     * @param bool $isUnsigned
     * @return \K5\Http\Field
     */
    public static function GetMediumInteger(string $name,bool $isUnsigned=false) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes()
        );
        $field->form_element->attributes->id = $field->key;
        if($isUnsigned) {
            $field->form_element->attributes->max = 8388607;
            $field->form_element->attributes->min = -8388608;
        } else {
            $field->form_element->attributes->max = 16777215;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    /**
     * @param string $name
     * @param bool $isUnsigned
     * @return \K5\Http\Field
     */
    public static function GetInteger(string $name,bool $isUnsigned=false) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = 0;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes()
        );
        $field->form_element->attributes->id = $field->key;
        if($isUnsigned) {
            $field->form_element->attributes->max = 2147483647;
            $field->form_element->attributes->min = -2147483648;
        } else {
            $field->form_element->attributes->max = 4294967295;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    /**
     * @param string $name
     * @param int $default
     * @param bool $isUnsigned
     * @return \K5\Http\Field
     */
    public static function dGetInteger(string $name,$default=null,bool $isUnsigned=false) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = $default;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $default
        );
        $field->form_element->attributes->id = $field->key;
        if($isUnsigned) {
            $field->form_element->attributes->max = 2147483647;
            $field->form_element->attributes->min = -2147483648;
        } else {
            $field->form_element->attributes->max = 4294967295;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    /**
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $class
     * @return \K5\Http\Field
     */
    public static function GetPlainNumeric(string $name,string $label,string $placeholder,string $class="form-control",$defaultValue=null) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $defaultValue
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    /**
     * @param string $name
     * @param string $label
     * @param string|null $placeholder
     * @param string $class
     * @return \K5\Http\Field
     */
    public static function GetIntDate(string $name,string $label='',?string $placeholder=null,string $class="form-control") : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_DATE,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes()
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    /**
     * @param string|null $name
     * @param string|null $label
     * @param string|null $placeholder
     * @param bool $hasPresence
     * @param $step
     * @param string $class
     * @param $default
     * @return \K5\Http\Field
     */
    public static function GetFloat(?string $name,?string $label,?string $placeholder,bool $hasPresence=False,$step="0.01",string $class="form-control",$default=null) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_FLOAT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $default,
            $step
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;
        if($hasPresence) {
            $field->default_value = 0;
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_PRESENCE] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_PRESENCE,\la::ng(\la::$keys->should_not_be_empty));
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_NUMERIC] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_NUMERIC,\la::ng(\la::$keys->must_be_numeric));
        }
        return $field;
    }

    /**
     * @param string $name
     * @param string|null $label
     * @param string|null $placeholder
     * @param string $class
     * @param $default
     * @return \K5\Http\Field
     */
    public static function GetPlainText(string $name,?string $label,?string $placeholder,string $class="form-control",$default=null) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = $default;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_TEXT,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $default
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    /**
     * @param string $name
     * @param string $label
     * @param string|null $placeholder
     * @param string|null $class
     * @return \K5\Http\Field
     */
    public static function GetEmail(string $name,string $label,?string $placeholder,?string $class="form-control") : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_TEXT,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes()
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;
        $field->form_element->attributes->pattern = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";

        return $field;
    }

    /**
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param array|null $options
     * @param string $class
     * @return \K5\Http\Field
     */
    public static function GetPlainSelect(string $name,string $label,string $placeholder,?array $options=null,string $class="form-control") : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_SELECT,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            $options,
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    /**
     * @param string $name
     * @param int|null $maxLength
     * @param int|null $minLength
     * @return \K5\Http\Field
     */
    public static function GetHiddenString(string $name,?int $maxLength=null,?int $minLength=null) : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->filter[] = \K5\Http\Field::FILTER_STRIPTAGS;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->key,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
        );
        $field->form_element->attributes->id = $field->key;
        if(!is_null($minLength)) {
            $field->form_element->attributes->minlength = $minLength;
        }
        if(!is_null($maxLength)) {
            $field->form_element->attributes->maxlength = $maxLength;
        }

        return $field;
    }

    /**
     * @param string $name
     * @param string $class
     * @return \K5\Http\Field
     */
    public static function GetNationalId(string $name,string $class = 'form-control') : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_TEXT,
            $field->key,
            \la::ng(\la::$keys->national_id),
            new \K5\Http\Field\FormElementCommonAttributes()
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->maxlength = 11;
        $field->form_element->attributes->minlength = 11;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->oninput = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');";
        $field->form_element->attributes->required = "required";
        $field->form_element->attributes->pattern = ".{11,}";
        $field->form_element->attributes->title = "TC Kimlik Numarası 11 haneden oluşan bir rakkamdır...";

        $field->form_element->attributes->placeholder = \la::ng(\la::$keys->national_id);

        return $field;
    }

    /**
     * @param string $name
     * @param string $label
     * @param string|null $placeholder
     * @param array|null $options
     * @param string|null $class
     * @return \K5\Http\Field
     */
    public static function GetPhoneNumber(string $name,string $label,?string $placeholder,?array $options=null,?string $class="form-control")  : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;

        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            $options,
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->maxlength = 10;
        $field->form_element->attributes->minlength = 10;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->oninput = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');";
        $field->form_element->attributes->required = "required";
        $field->form_element->attributes->pattern = ".{10,10}";
        $field->form_element->attributes->title = "Telefon numaraları 10 haneden oluşur";

        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_DIGIT] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_DIGIT,\la::ng(\la::$keys->must_be_numeric));
        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH,null);
        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->max = 10;
        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->min = 10;
        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->messageMaximum = "10 ".\la::ng(\la::$keys->cannot_be_more_than_characters);
        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_STRING_LENGTH]->messageMinimum = "10 ".\la::ng(\la::$keys->cannot_be_less_than_characters);

        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    /**
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param array|null $options
     * @param string $class
     * @param string|null $defaultValue
     * @return \K5\Http\Field
     */
    public static function GetCountryCode(string $name,string $label,string $placeholder,?array $options=null,string $class="form-control",?string $defaultValue="90") : \K5\Http\Field
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = null;

        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->key,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            $options
        );
        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->maxlength = 6;
        $field->form_element->attributes->minlength = 1;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;
        $field->form_element->defaultValue = $defaultValue;

        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_DIGIT] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_DIGIT,\la::ng(\la::$keys->must_be_numeric));

        $field->form_element->attributes->id = $field->key;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }
}
