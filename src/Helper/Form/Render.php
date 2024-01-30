<?php
/**
 * User: Sancar Saran
 * Date: 18.9.2015
 * Time: 9:54
 *
 * User: Sancar Saran
 * Extended
 * Date: 30.10.2019
 * Time: 14:43
 */

namespace K5\Helper\Form;

use \K5\U as u;

class Render
{

    public $Out = [];
    public $DomPrefix;
    public $elements = [];
    private $_form;
    /** @var \K5\Entity\Form\Setup  */
    private $_setup;

    private $_hidden = [];
    private $_content = [];

    public function __construct(\Phalcon\Forms\Form $form, \K5\Entity\Form\Setup $setup,$domPrefix)
    {
        $this->DomPrefix = $domPrefix;
        $this->_form = $form;
        $this->_setup = $setup;
        $this->Out['html'] = '';
        $this->Out['js'] = '';
    }

    public function Render($append='',$prepend='',$params=[])
    {
        $this->parseContent();
        $this->Out['html'] =
                $this->GetFormStart($params).'
                '.$prepend.'
                '.implode("\n",$this->_content).'
                '.$append.'
                '.$this->GetSubmit().'					
                '.implode("\n",$this->_hidden).'
                '.$this->GetFormEnd().'
';
        $this->Out['js'] = '';

    }

    public function GetFormStart($params = [])
    {
        return '<form '.\K5\Helper\Dom\ElementParameters::Prepare($this->_setup->FormGetParams($params)).'>';
    }

    public function GetFormEnd()
    {
        return '</form>';
    }

    public function GetElementKeys()
    {
        return array_keys($this->_content);
    }

    public function GetElementById($id)
    {
        if(isset($this->_content[$id])) {
            return $this->_content[$id];
        }
        return '-';
    }

    public function GetHidden()
    {
        return  implode("\n",$this->_hidden);
    }

    public function parseContent()
    {
        $this->_content = [];
        foreach ($this->_form as $f) {

            $className = get_class($f);
            $nameElement = $f->getName();
            $labelElement = $f->getLabel();
            $attr = $f->getAttributes();
            $vals = $f->getValidators();
            $html = $f->render();
            $id = $f->getAttribute('id');

            $this->elements[$id] = $nameElement;

            if ($className == "Phalcon\Forms\Element\Hidden") {
                $this->_hidden[] = $html . "\n";
                continue;
            }

            if (isset($attr['no-label']) || ($this->_setup->FormIsNaked())) {
                $label = '';
                $col = 'col-sm-12';
            } else {
                $label = '<label for="' . $nameElement . '" id="'.$id.'_form_label">' . $labelElement . '</label>';
                $col = 'col-sm-9';
            }
            if (isset($attr['html-msg'])) {
                $html = $html . "&nbsp; " . $attr['html-msg'];
            }
            if (isset($attr['replace'])) {
                $findRepl = explode("-", $attr['replace']);
                if (sizeof($findRepl) == 2) {
                    $html = str_replace($findRepl[0], $findRepl[1], $html);
                } else {
                    \K5\U::ldbg($findRepl);
                }
            }
            $this->_content[$id] = "<div class=\"form-group\" id=\"".$id."_form_group_cover\">" . $label . "" . $html . "</div>";

        }
        return true;
    }

    public function GetSubmit($naked=false)
    {
        if($this->_setup->SubmitIsDisabled()) {
            return '';
        }

        $submitParams = $this->_setup->SubmitGetParams();
        if($this->_setup->SubmitIsHidden()) {
            $submitParams['class'][] = 'd-hide';
        }

        $_params = \K5\Helper\Dom\ElementParameters::Prepare($submitParams);

        $btn = '
                    <button '.$_params.'">'.$this->_setup->SubmitGetIcon(). ' ' .$this->_setup->SubmitGetLabel().'</button>
        ';
        if(!$naked) {
            return '
            <div class="form-group hidden-sm hidden-xs">&nbsp;</div>
            <div class="form-group">
                <div class="col-sm-12 form-element-cover">
                    '.$btn.'
                </div>
            </div>
';
        }

        return $btn;
    }

}