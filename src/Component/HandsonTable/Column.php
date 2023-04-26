<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 14:38
 */

namespace K5\Component\HandsonTable;


class Column
{
    //public $Type;
    public $Label;
    public $Data;
    public $Renderer;
    public $Buttons;
    public $IsVisible = true;
    public $IsSelectable = true;
    /** @var \K5\Entity\Config\HandsonTable\Column */
    public $Config;

    public function __construct($label,$dbField,$config=false,$type='text',$renderer="TextDbField",$readOnly=false)
    {
        //$this->Type = $type;
        $this->Label = $label;
        $this->Data = 'config';
        $this->Renderer = $renderer;
        $this->Config = new \K5\Entity\Config\HandsonTable\Column();
        $this->Config->renderer = $renderer;
        $this->Config->readOnly = $readOnly;
        $this->Config->data = $dbField;
        $this->Config->type = $type;
        $this->Config->head = new \K5\Entity\Config\HandsonTable\ColumnHead();
        $this->Config->head->type = 'text';
        $this->Config->head->label = $label;
        if(is_array($config) && !in_array($this->Config->data,$config)) {
            $this->IsVisible = false;
        }
    }
}

