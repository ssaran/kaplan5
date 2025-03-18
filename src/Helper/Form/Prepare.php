<?php

namespace K5\Helper\Form;

class Prepare
{
    protected static \K5\Entity\Request\Setup $setup;
    protected static array $formFields;


    /**
     * @return mixed
     */
    public static function Exec(\K5\Entity\Request\Setup $setup,array $formFields) : array
    {
        self::$setup = $setup;
        $_formData = [];
        /**
         * @var string $k
         * @var \K5\Http\Field $field
         */
        foreach($formFields as $k => $field) {
            switch ($field->form_element->type) {
                case \K5\Http\Field\FormElement::TYPE_TEXT:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::textElement($field->form_element));
                    break;

                case \K5\Http\Field\FormElement::TYPE_NUMERIC:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::numericElement($field->form_element));
                    break;

                case \K5\Http\Field\FormElement::TYPE_DATE:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::dateElement($field->form_element));
                    break;

                case \K5\Http\Field\FormElement::TYPE_HIDDEN:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::hiddenElement($field->form_element));
                    break;

                case \K5\Http\Field\FormElement::TYPE_SELECT:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::selectElement($field->form_element));
                    break;
                case \K5\Http\Field\FormElement::TYPE_PASSWORD:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::passwordElement($field->form_element));
                    break;
                case \K5\Http\Field\FormElement::TYPE_TELEPHONE:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::telephpneElement($field->form_element));
                    break;
                case \K5\Http\Field\FormElement::TYPE_EMAIL:
                    $_formData[$field->key] = self::getFormValidators($field->form_element,self::emailElement($field->form_element));
                    break;
            }
        }
        return $_formData;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @param $r
     * @return mixed
     */
    protected static function getFormValidators(\K5\Http\Field\FormElement $elm,$r)
    {

        if(is_countable($elm->validators) && sizeof($elm->validators) > 0) {
            foreach ($elm->validators as $vk => $validator) {
                $vAttr = self::parseValidationAttributes($validator,$elm);
                switch ($validator->type) {
                    case \K5\Http\Field\FormValidator::TYPE_PRESENCE:
                        $r->addValidator(new \Phalcon\Filter\Validation\Validator\PresenceOf($vAttr));
                        break;
                    case \K5\Http\Field\FormValidator::TYPE_DIGIT:
                        $r->addValidator(new \Phalcon\Filter\Validation\Validator\Digit($vAttr));
                        break;
                    case \K5\Http\Field\FormValidator::TYPE_STRING_LENGTH:
                        $r->addValidator(new \Phalcon\Filter\Validation\Validator\StringLength($vAttr));
                        break;
                }
            }
        }
        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Text
     */
    protected static function textElement(\K5\Http\Field\FormElement $elm) : \Phalcon\Forms\Element\Text
    {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Text($elm->name,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        if($elm->defaultValue) {
            $r->setDefault($elm->defaultValue);
        }

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Email
     */
    protected static function emailElement(\K5\Http\Field\FormElement $elm) {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Email($elm->name,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        if($elm->defaultValue) {
            $r->setDefault($elm->defaultValue);
        }

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Text
     */
    protected static function telephpneElement(\K5\Http\Field\FormElement $elm) {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Text($elm->name,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        if($elm->defaultValue) {
            $r->setDefault($elm->defaultValue);
        }
        $elm->type = "tel";

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Password
     */
    protected static function passwordElement(\K5\Http\Field\FormElement $elm) : \Phalcon\Forms\Element\Password
    {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Password($elm->name,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        if($elm->defaultValue) {
            $r->setDefault($elm->defaultValue);
        }
        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Numeric
     */
    protected static function numericElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Numeric($elm->name,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        if($elm->defaultValue) {
            $r->setDefault($elm->defaultValue);
        }

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Date
     */
    protected static function dateElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Date($elm->name,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        if($elm->defaultValue) {
            $r->setDefault($elm->defaultValue);
        }

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Hidden
     */
    protected static function hiddenElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Hidden($elm->name,$attr);

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Select
     */
    protected static function selectElement(\K5\Http\Field\FormElement $elm) : \Phalcon\Forms\Element\Select
    {
        $attr = self::parseAttributes($elm->attributes);
        $attr['id'] = self::$setup->Headers->ApiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Select($elm->name,$elm->options,$attr);
        if($elm->label != null) {
            $r->setLabel($elm->label);
        }
        return $r;
    }


    /**
     * @param \K5\Http\Field\FormElementCommonAttributes $attr
     * @return array
     */
    protected static function parseAttributes(\K5\Http\Field\FormElementCommonAttributes $attr) : array
    {
        $r = [];
        $properties = get_object_vars($attr);
        foreach($properties as $k => $v) {
            if(!empty($v)) {
                $r[$k] = $v;
            }
        }
        return $r;
    }

    /**
     * @param \K5\Http\Field\FormValidator $attr
     * @param \K5\Http\Field\FormElement $elm
     * @return array
     */
    protected static function parseValidationAttributes(\K5\Http\Field\FormValidator $attr,\K5\Http\Field\FormElement $elm) : array
    {
        $r = [];
        $properties = get_object_vars($attr);
        foreach($properties as $k => $v) {
            if(!empty($v)) {
                $r[$k] = $v;
            }
        }
        if($attr->message != null) {
            $r['message'] = $elm->name." ".$attr->message;
        }
        if($attr->messageMaximum != null) {
            $r['messageMaximum'] = $elm->name." ".$attr->messageMaximum;
        }

        if($attr->messageMinimum != null) {
            $r['messageMinimum'] = $elm->name." ".$attr->messageMinimum;
        }
        unset($r['type']);
        return $r;
    }
}
