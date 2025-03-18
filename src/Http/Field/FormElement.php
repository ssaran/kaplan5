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
    public ?string $label;
    public $defaultValue = null;

    public ?\K5\Http\Field\FormElementCommonAttributes $attributes;
    public ?array $options = null;
    public ?array $filters = null;
    public ?array $validators = null;
    public ?array $messages = null;
    public ?array $append = null;
    public ?array $formEnabled = null;
    public ?array $formDisabled = null;


    public function __construct(string $type,string $name,?string $label,?\K5\Http\Field\FormElementCommonAttributes $attributes,
                                ?array $append=null,?array $options=null,?array $filters=null,?array $validators=null,
                                ?array $messages=null,$defaultValue=null,?string $step=null)
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
