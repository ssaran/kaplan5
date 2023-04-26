<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.12.2018
 * Time: 09:32
 */

namespace K5\Entity\Config\HandsonTable;


class Column
{
    public $data;
    public $type;
    public $strict = false;
    public $allowInvalid;
    public $width = 50;
    public $source;
    public $filter = true;
    public $renderer;
    public $readOnly = false;
    public $Editor = false;
    public $buttons = [];
    /** @var \K5\Entity\Config\HandsonTable\ColumnHead */
    public $head;
}

