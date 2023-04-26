<?php


namespace K5\Helper;


use Phalcon\Validation;

class Validate extends \K5\Helper\Form\Prepare
{
    protected $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    public function SetFormData($formData)
    {
        $this->formData = $formData;
    }

    /**
     * @param $post
     * @return bool
     * @throws \Exception
     */
    public function Process($post)
    {
        try {
            $validate = new \Phalcon\Filter\Validation();
            /**
             * @var  $k
             * @var \Phalcon\Forms\Element $elm
             */
            $debug = false;
            foreach($this->formData as $k => $elm) {
                $name = $elm->getName();
                $validators = $elm->getValidators();
                $debug = false;
                if(is_countable($validators) && sizeof($validators) > 0) {
                    foreach ($validators as $validator) {
                        $validate->add($name,$validator);
                    }
                }
            }

            if($debug) {
                \K5\Log::Info($validators);
            }

            $messages = $validate->validate($post);
            if(count($messages)) {
                $msg = [];
                foreach ($messages as $message) {
                    $msg[] = $message;
                }
                $eMsg = implode("<br>\n",$msg);
                throw new \Exception($eMsg);
            }

            return true;
        } catch (\Exception $e) {
            \K5\Log::Error($e->getMessage());
            throw $e;
        }

    }
}