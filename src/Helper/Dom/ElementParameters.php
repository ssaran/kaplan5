<?php
/**
 * User: Sancar Saran
 * Date: 8.11.2019
 * Time: 9:43
 *
 * For automating html dom element paramers
 */

namespace K5\Helper\Dom;

class ElementParameters
{
    public static function Prepare(array $params) : string
    {
        $_tmp = [];
        foreach ($params as $k => $v) {
            if ($k == 'class') {
                $_tmp[] = 'class="'.implode(" ",$v).'"';
            } elseif ($k == 'data') {
                foreach($v as $dk => $dv) {

                    if($dv != null) {
                        if($dk != "append") {
                            $_tmp[] = 'data-'.$dk.'="'.$dv.'"';
                        } else {
                            $_tmp[] = "data-".$dk."='".$dv."'";
                        }
                    }
                }
            } elseif ($k == 'aria') {
                foreach($v as $dk => $dv) {
                    $_tmp[] = 'aria-'.$dk.'="'.$dv.'"';
                }
            } else {
                $_tmp[] = strtolower($k).'="'.$v.'"';
            }
        }
        return implode(" ",$_tmp);
    }
}