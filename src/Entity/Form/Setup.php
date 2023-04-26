<?php
/**
 * Date: 7.11.2019
 * Time: 15:41
 */

namespace K5\Entity\Form;

class Setup
{

    public $_paramsForm;
    public $_paramsSubmit;

    /**
     * Setup constructor.
     * @param array $paramsForm
     * @param array $paramsSubmit
     * @throws \Exception
     */
    public function __construct(array $paramsForm,array $paramsSubmit)
    {
        try {
            if(!isset($paramsForm['id'])) {
                throw new \Exception("No form dom id ");
            }

            if(!isset($paramsForm['action'])) {
                throw new \Exception("No form action ");
            }

            if(!isset($paramsForm['method'])) {
                $paramsForm['method'] = 'Post';
            }

            $this->_paramsForm = $paramsForm;
            $this->_paramsSubmit = $paramsSubmit;
        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * @param array $append
     * @return array
     */
    public function FormGetParams(array $append=array())
    {
        $params = $this->_paramsForm;

        if(!isset($params['name'])) {
            $params['name'] = $params['id'];
        }

        if(isset($params['IsNaked'])) {
            unset($params['IsNaked']);
        }

        if(isset($params['Novalidate'])) {
            unset($params['Novalidate']);
        }
        foreach ($append as $k => $v) {
            $params[$k] = $v;
        }

        return $params;
    }

    public function FormIsNaked()
    {
        if(!isset($this->_paramsForm['IsNaked'])) {
            return false;
        }
        return $this->_paramsSubmit['IsNaked'];
    }

    public function SubmitGetParams()
    {
        $params = $this->_paramsSubmit;

        if(!isset($params['title'])) {
            $params['title'] = $params['Label'];
        }
        unset($params['Label']);

        if(isset($params['Icon'])) {
            unset($params['Icon']);
        }

        if(isset($params['IsHidden'])) {
            unset($params['IsHidden']);
        }

        if(isset($params['IsDisabled'])) {
            unset($params['IsDisabled']);
        }

        return $params;
    }

    public function SubmitGetIcon()
    {
        if(!isset($this->_paramsSubmit['Icon'])) {
            return '<i class="fa fa-pencil"></i>';
        }
        return $this->_paramsSubmit['Icon'];
    }

    public function SubmitGetLabel()
    {
        if(!isset($this->_paramsSubmit['Label'])) {
            return 'Kaydet';
        }
        return $this->_paramsSubmit['Label'];
    }

    public function SubmitIsHidden()
    {
        if(!isset($this->_paramsSubmit['IsHidden'])) {
            return false;
        }
        return $this->_paramsSubmit['IsHidden'];
    }

    public function SubmitIsDisabled()
    {
        if(!isset($this->_paramsSubmit['IsDisabled'])) {
            return false;
        }
        return $this->_paramsSubmit['IsDisabled'];
    }
}