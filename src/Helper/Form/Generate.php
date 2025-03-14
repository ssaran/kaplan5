<?php

namespace K5\Helper\Form;

class Generate
{
    public static function Exec($formData,$entity=null)
    {
        if(!is_countable($formData)) {
            \K5\U::lerr("Form Data Not countable");
            throw new \Exception("Form data not prepared");
        }

        $form = new \Phalcon\Forms\Form($entity);
        foreach($formData as $k => $v) {
            $form->add($v);
        }
        return $form;
    }
}