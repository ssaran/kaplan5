<?php


namespace K5\Http\Field;


class Database
{
    public string $cell_name;
    public string $column_type;
    public ?string $table_name = null;
    public bool $is_primary = false;
    public bool $emptiable = false;
    public bool $nullable = false;
    public ?string $default = null;
    public ?string $on_create = null;
    public ?string $on_update = null;
}
