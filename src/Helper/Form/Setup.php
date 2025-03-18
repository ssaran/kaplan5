<?php

namespace K5\Helper\Form;

class Setup
{
    /**
     * @param \K5\Component\RequestFields $fields
     * @param string $form_key
     * @return array
     */
    public static function Generator(\K5\Component\RequestFields $fields,string $form_key) : array
    {
        $_r = [];
        /** @var \K5\Http\Field  $field */
        foreach ($fields as $field) {
            if(!isset($field->form_element)) {
                continue;
            }
            if(is_null($field->form_element->formEnabled)) {
                continue;
            }
            if(!isset($field->form_element->formEnabled[$form_key])) {
                continue;
            }
            if(!$field->form_element->formEnabled[$form_key]) {
                continue;
            }
            $_r[$field->key] = $field->form_element;
        }
        return $_r;
    }
}