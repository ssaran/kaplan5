<?php


namespace K5\Helper\Field;


use Phalcon\Db\Column;

class Generator
{
    /**
     * @param $name
     * @param $isPrimary
     * @param $isNullable
     * @return \K5\Http\Field
     */
    public static function GetUUID($name,$isPrimary=false,$isNullable=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->filter[] = \K5\Http\Field::FILTER_STRIPTAGS;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->database->is_primary = $isPrimary;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null
        );

        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->maxlength = 36;
        $field->form_element->attributes->minlength = 36;

        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = 'form-control';
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

    public static function GetIntID($name,$isPrimary=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->database->is_primary = $isPrimary;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null
        );
        $field->form_element->attributes->id = $field->database->cell_name;

        return $field;
    }

    public static function GetTinyInt($name,$isUnsigned=false)
    {
        return self::dGetTinyInt($name,false,$isUnsigned);
    }

    public static function dGetTinyInt($name,$default=0,$isUnsigned=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = $default;
        $field->filter[] = \K5\Http\Field::FILTER_INT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->database->is_primary = false;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $default
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        if($isUnsigned) {
            $field->form_element->attributes->max = 127;
            $field->form_element->attributes->min = -128;
        } else {
            $field->form_element->attributes->max = 254;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    public static function GetMediumInteger($name,$isUnsigned=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = 0;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->database->is_primary = false;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        if($isUnsigned) {
            $field->form_element->attributes->max = 8388607;
            $field->form_element->attributes->min = -8388608;
        } else {
            $field->form_element->attributes->max = 16777215;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    public static function GetInteger($name,$isUnsigned=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = 0;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->database->is_primary = false;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        if($isUnsigned) {
            $field->form_element->attributes->max = 2147483647;
            $field->form_element->attributes->min = -2147483648;
        } else {
            $field->form_element->attributes->max = 4294967295;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    public static function dGetInteger($name,$default=0,$isUnsigned=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = $default;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->database->is_primary = false;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null,
            $default
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        if($isUnsigned) {
            $field->form_element->attributes->max = 2147483647;
            $field->form_element->attributes->min = -2147483648;
        } else {
            $field->form_element->attributes->max = 4294967295;
            $field->form_element->attributes->min = 0;
        }

        return $field;
    }

    public static function GetPlainNumeric($name,$label,$placeholder,$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            ''
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    public static function GetIntDate($name,$label='',$placeholder='',$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_DATE,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    public static function GetFloat($name,$label,$placeholder,$hasPresence=False,$step="0.01",$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_FLOAT_CAST;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_DOUBLE;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            '',
            false,
            $step
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;
        if($hasPresence) {
            $field->default_value = 0;
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_PRESENCE] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_PRESENCE,\la::ng(\la::$keys->should_not_be_empty));
            $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_NUMERIC] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_NUMERIC,\la::ng(\la::$keys->must_be_numeric));
        }
        return $field;
    }

    public static function GetPlainText($name,$label,$placeholder,$class="form-control",$default=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = $default;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_TEXT,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            '',
            $default
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    public static function GetEmail($name,$label,$placeholder,$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_TEXT,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            ''
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;
        $field->form_element->attributes->pattern = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";

        return $field;
    }

    public static function GetPlainSelect($name,$label,$placeholder,$options=[],$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_SELECT,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            $options,
            '',
            [],
            ''
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    /**
     * @param $name
     * @param bool $max
     * @param bool $min
     * @return \K5\Http\Field
     */
    public static function GetHiddenString($name,$maxLength=false,$minLength=false)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_STRING;
        $field->filter[] = \K5\Http\Field::FILTER_STRIPTAGS;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->database->is_primary = false;
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_HIDDEN,
            $field->database->cell_name,
            null,
            new \K5\Http\Field\FormElementCommonAttributes(),
            null,
            null,
            null,
            null,
            null
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        if($maxLength) {
            $field->form_element->attributes->minlength = $minLength;
        }
        if($minLength) {
            $field->form_element->attributes->maxlength = $maxLength;
        }

        return $field;
    }

    public static function GetNationalId($name)
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;
        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_INTEGER;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_TEXT,
            $field->database->cell_name,
            \la::ng(\la::$keys->national_id),
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            ''
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->maxlength = 11;
        $field->form_element->attributes->minlength = 11;
        $field->form_element->attributes->class = 'form-control';
        $field->form_element->attributes->oninput = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');";
        $field->form_element->attributes->required = "required";
        $field->form_element->attributes->pattern = ".{11,}";
        $field->form_element->attributes->title = "TC Kimlik Numarası 11 haneden oluşan bir rakkamdır...";

        $field->form_element->attributes->placeholder = \la::ng(\la::$keys->national_id);

        return $field;
    }

    public static function GetPhoneNumber($name,$label,$placeholder,$options=[],$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;

        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            ''
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->maxlength = 10;
        $field->form_element->attributes->minlength = 10;
        $field->form_element->attributes->class = 'form-control';
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

        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }

    public static function GetCountryCode($name,$label,$placeholder,$options=[],$class="form-control")
    {
        $field = new \K5\Http\Field();
        $field->key = $name;
        $field->default_value = false;

        $field->filter[] = \K5\Http\Field::FILTER_ABSINT;
        $field->database = new \K5\Http\Field\Database();
        $field->database->cell_name = $name;
        $field->database->column_type = Column::TYPE_VARCHAR;
        $field->database->table_name = [];
        $field->form_element = new \K5\Http\Field\FormElement(
            \K5\Http\Field\FormElement::TYPE_NUMERIC,
            $field->database->cell_name,
            $label,
            new \K5\Http\Field\FormElementCommonAttributes(),
            '',
            '',
            '',
            [],
            ''
        );
        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->maxlength = 6;
        $field->form_element->attributes->minlength = 1;
        $field->form_element->attributes->class = 'form-control';
        $field->form_element->attributes->placeholder = \la::ng(\la::$keys->country_code);
        $field->form_element->defaultValue = "90";

        $field->form_element->validators[\K5\Http\Field\FormValidator::TYPE_DIGIT] = new \K5\Http\Field\FormValidator(\K5\Http\Field\FormValidator::TYPE_DIGIT,\la::ng(\la::$keys->must_be_numeric));

        $field->form_element->attributes->id = $field->database->cell_name;
        $field->form_element->attributes->class = $class;
        $field->form_element->attributes->placeholder = $placeholder;

        return $field;
    }
}