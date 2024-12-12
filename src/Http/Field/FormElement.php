<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 7.01.2020
 * Time: 13:35
 */


namespace K5\Http\Field;


class FormElement
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_SELECT = 'select';
    const TYPE_CHECK = 'check';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_HIDDEN = 'hidden';
    const TYPE_FILE = 'file';
    const TYPE_DATE = 'date';
    const TYPE_NUMERIC = 'number';
    const TYPE_TELEPHONE = 'tel';
    const TYPE_EMAIL= 'email';

    public string $type;
    public string $name;
    public string $label;
    public $defaultValue;

    /** @var \K5\Http\Field\FormElementCommonAttributes */
    public \K5\Http\Field\FormElementCommonAttributes $attributes;
    public $options;
    public $filters;
    public $validators = [];
    public $messages;
    public $append;


    public function __construct($type,$name,$label,$attributes,$append,$options,$filters,$validators,$messages,$defaultValue=false,?float $step=null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->attributes = $attributes;
        if(!is_null($step)) {
            $this->attributes->step = $step;
        }
        $this->append = $append;
        $this->options = $options;
        $this->filters = $filters;
        $this->validators = $validators;
        $this->messages = $messages;
        $this->defaultValue = $defaultValue;
    }
}
