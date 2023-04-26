<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 13:48
 */

namespace K5\Component\HandsonTable;


class SetupNavbar
{
    public $Label = 'Hot Navbar';
    public $SearchForm = null;
    public $DefaultButtons = null;
    public $Buttons = null;



    /** Creates auto config for handson table include button config and route config */
    public function __construct()
    {
        $this->DefaultButtons = [];
        $this->DefaultButtons['dropdown'] = true;
        $this->DefaultButtons['print'] = true;
        $this->DefaultButtons['excel'] = true;
        $this->SearchForm = true;

    }

    public function AddButton(\K5\Component\HandsonTable\Button $button)
    {
        $this->Buttons[$button->Uri] = $button;
    }


}