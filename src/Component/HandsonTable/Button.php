<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 14:07
 */

namespace K5\Component\HandsonTable;


class Button extends \K5\Entity\Config\Button
{
    CONST CLASS_EDIT = 'btn btn-raised btn-info btn-sm btn-square xjhref ';
    CONST CLASS_DELETE = 'btn btn-danger btn-sm btn-square xjhref';
    CONST CLASS_ADD = 'btn btn-success btn-sm btn-square xjhref';
    CONST ICON_EDIT = 'fa fa-pencil';
    CONST ICON_DELETE = 'fa fa-trash';
    CONST ICON_ADD = 'fas fa-plus-square';

    public function __construct($route,$label,$title,$icon,$class,$key,$append=[],$data=[],$onClick=null,$callback=false,$idKey='dbid')
    {
        $this->Uri = $route;
        $this->Label = $label;
        $this->Title = $title;
        $this->Icon = $icon;
        $this->Class = $class;
        $this->Key = $key;
        $this->Append = $append;
        $this->Data = $data;
        $this->OnClick = $onClick;
        $this->Callback = $callback;
        $this->IdKey = $idKey;


    }

    public function SetRoute($route)
    {
        $this->Uri = $route;
        return $this;
    }

    public function SetTitle($title)
    {
        $this->Title = $title;
        return $this;
    }

    public function SetIcon($icon)
    {
        $this->Icon = $icon;
        return $this;
    }

    public function SetClass($class,$clean=false)
    {
        if($clean) {
            $this->Class = $class;
        } else {
            $this->Class.= $class;
        }
        return $this;
    }

    public function SetOnclick($onclick)
    {
        $this->OnClick = $onclick;
        return $this;
    }

    public function SetData(array $data)
    {
        $this->Data = $data;
        return $this;
    }

    public function SetKey($key)
    {
        $this->Key = $key;
        return $this;
    }

    public function SetIdKey($key)
    {
        $this->IdKey = $key;
        return $this;
    }

    public function AddAppend($key,$data)
    {
        $this->Append[$key] = $data;
        return $this;
    }
}