<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.12.2018
 * Time: 14:38
 */

namespace K5\Entity\Config\HandsonTable;


class ColumnHead
{
    public $type;
    public $label;
    public $data;

    public function __construct()
    {
        $this->data = new \stdClass();
        $this->data->source = 'config';
    }
}

