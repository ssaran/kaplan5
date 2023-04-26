<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 14.02.2018
 * Time: 09:36
 */

namespace  K5\Helper\Form;

use K5\U as u;

class Select
{
    public static $Class = 'form-control';
    public static $DomID = false;

    public static $ElementName = '';
    public static $Label = false;
    public static $Required = false;
    public static $Selected = '';
    public static $Data = [];
    public static $Key;
    public static $TargetDomID;

    public function SetDomID($DomId)
    {
        self::$DomID = $DomId;
        return $this;
    }

    public function SetTargetDomID($targetDomID)
    {
        self::$TargetDomID = $targetDomID;
        return $this;
    }

    public function SetName($elementName)
    {
        self::$ElementName = $elementName;
        return $this;
    }

    public function SetLabel($label)
    {
        self::$Label = $label;
        return $this;
    }

    public function SetClass($class,$clean=false)
    {
        if($clean) {
            self::$Class = $class;
        } else {
            self::$Class.= $class;
        }
        return $this;
    }


    public function SetData(array $data)
    {
        self::$Data = $data;
        return $this;
    }

    public function SetSelected($selected)
    {
        self::$Selected = $selected;
        return $this;
    }

    public function Render()
    {

        self::$DomID = (!self::$DomID) ? self::$ElementName : self::$DomID;
        $required = (!self::$Required) ? '' : 'required';
        $r = '
                    <select class="'.self::$Class.'" '.$required.' id="'.self::$DomID.'" name="'.self::$ElementName.'" data-target="'.self::$TargetDomID.'">
';
        if(self::$Label) {
            $r.= '
            <option value="" disabled> '.self::$Label.'</option>
';
        }
        $r.= '
                        '.u::optionGenerator(self::$Data,self::$Selected).'
                    </select>        
        ';

        return $r;
    }
}