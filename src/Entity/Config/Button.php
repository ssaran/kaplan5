<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 14:07
 */

namespace K5\Entity\Config;


class Button
{
    public $Class = 'xhr-button';
    public $Uri = '';
    public $IsNoHistory = true;
    public $Title = '';
    public $Icon = '';
    public $Label = '';
    public $OnClick = '';
    public $Callback = false;
    public $Data = [];
    public $Append = [];
    public $Key;
    public $IdKey = 'dbid';

}