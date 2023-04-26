<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 15.02.2018
 * Time: 09:09
 */

namespace   K5\Helper\Form;

use K5\U as u;
use K5\V as v;

class BaseSelect extends \K5\Helper\Form\Select
{
    public static $Class = 'form-control';
    public static $TargetDomID = false;

    protected static $instance = null;

    protected function __construct () { }

    public static function GetInstance ()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function SetTarget($targetDomId)
    {
        self::$TargetDomID = $targetDomId;
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

    public function Render()
    {
        if(empty(self::$ElementName)) {
            return v::GetCallout("Form element adı yok !","HATA");
        }

        if(empty(self::$Data) || sizeof(self::$Data) < 1) {
            return v::GetCallout("Data yok !","HATA");
        }

        self::$DomID = (!self::$DomID) ? self::$ElementName : self::$DomID;
        $required = (!self::$Required) ? '' : 'required';

        $r = '
                    <select class="'.self::$Class.'" '.$required.' id="'.self::$DomID.'" name="'.self::$ElementName.'">
';
        if(self::$Label && !empty(self::$Label)) {
            if(self::$Selected && !empty(self::$Selected)) {
                $r.= '
            <option value=""> '.self::$Label.'</option>
';

            } else {
                $r.= '
            <option value="" disabled selected> '.self::$Label.'</option>
';

            }
        }
        $r.= '
                        '.u::optionGeneratorNoLabel(self::$Data,self::$Selected).'
                    </select>        
        ';

        return $r;
    }
}