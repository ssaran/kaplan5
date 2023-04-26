<?php


namespace K5\Http\Field;


class Database
{
    public $cell_name;
    public $column_type;
    public $table_name;
    public $is_primary = false;
    public $emptiable = false;
    public $nullable = false;
    public $default = false;
    public $on_create = false;
    public $on_update = false;
}