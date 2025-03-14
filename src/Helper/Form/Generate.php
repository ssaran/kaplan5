<?php

namespace K5\Helper\Form;

class Generate
{
    /**
     * @param array $formData
     * @param $entity
     * @return \Phalcon\Forms\Form
     * @throws \Exception
     */
    public static function Exec(array $formData,$entity=null) : \Phalcon\Forms\Form
    {
        if(!is_array($formData)) {
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