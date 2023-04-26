<?php


namespace K5\Helper\Form;


class Prepare
{
    protected $raw;
    protected $apiPrefix;
    protected $formData;

    public function __construct($raw,$apiPrefix='')
    {
        $this->apiPrefix = $apiPrefix;
        $this->raw = $raw;
    }

    /**
     * @param null $entity
     * @return \Phalcon\Forms\Form
     * @throws \Exception
     */
    public function generate($entity=null)
    {
        if(!is_countable($this->formData)) {
            \K5\Log::Error("Form Data Not countable");
            throw new \Exception("Form data not prepared");
        }

        $form = new \Phalcon\Forms\Form($entity);
        foreach($this->formData as $k => $v) {
            $form->add($v);
        }
        return $form;
    }

    public function parse()
    {
        /**
         * @var  $k
         * @var \K5\Http\Field\FormElement $elm
         */

        foreach($this->raw as $k => $elm) {
            if(!isset($elm->type)) {
                continue;
            }

            switch ($elm->type) {
                case \K5\Http\Field\FormElement::TYPE_TEXT:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->textElement($elm));
                    break;

                case \K5\Http\Field\FormElement::TYPE_NUMERIC:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->numericElement($elm));
                    break;

                case \K5\Http\Field\FormElement::TYPE_DATE:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->dateElement($elm));
                    break;

                case \K5\Http\Field\FormElement::TYPE_HIDDEN:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->hiddenElement($elm));
                    break;

                case \K5\Http\Field\FormElement::TYPE_SELECT:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->selectElement($elm));
                    break;
                case \K5\Http\Field\FormElement::TYPE_PASSWORD:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->passwordElement($elm));
                    break;
                case \K5\Http\Field\FormElement::TYPE_TELEPHONE:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->telephpneElement($elm));
                    break;
                case \K5\Http\Field\FormElement::TYPE_EMAIL:
                    $this->formData[$elm->name] = $this->getFormValidators($elm,$this->emailElement($elm));
                    break;
            }
        }
        return $this->formData;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @param $r
     * @return mixed
     */
    protected function getFormValidators(\K5\Http\Field\FormElement $elm,$r)
    {

        if(is_countable($elm->validators) && sizeof($elm->validators) > 0) {
            /**
             * @var  $vk
             * @var  \K5\Http\Field\FormValidator $validator
             */
            foreach ($elm->validators as $vk => $validator) {
                $vAttr = $this->parseValidationAttributes($validator,$elm);
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
    protected function textElement(\K5\Http\Field\FormElement $elm) {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
    protected function emailElement(\K5\Http\Field\FormElement $elm) {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
    protected function telephpneElement(\K5\Http\Field\FormElement $elm) {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
     * @return \Phalcon\Forms\Element\Text
     */
    protected function passwordElement(\K5\Http\Field\FormElement $elm) {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
    protected function numericElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
    protected function dateElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
    protected function hiddenElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
        $r = new \Phalcon\Forms\Element\Hidden($elm->name,$attr);

        return $r;
    }

    /**
     * @param \K5\Http\Field\FormElement $elm
     * @return \Phalcon\Forms\Element\Select
     */
    protected function selectElement(\K5\Http\Field\FormElement $elm)
    {
        $attr = $this->parseAttributes($elm->attributes);
        $attr['id'] = $this->apiPrefix.$elm->attributes->id;
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
    protected function parseAttributes(\K5\Http\Field\FormElementCommonAttributes $attr)
    {
        $r = [];
        foreach($attr as $k => $v) {
            if($v != null && !empty($v)) {
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
    protected function parseValidationAttributes(\K5\Http\Field\FormValidator $attr,\K5\Http\Field\FormElement $elm)
    {
        $r = [];
        foreach($attr as $k => $v) {
            if($v != null && !empty($v)) {
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