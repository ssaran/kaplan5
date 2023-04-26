<?php


namespace K5\Component\Route;


class Base
{
    public function __construct(array $routes=[])
    {
        foreach ($routes as $k => $v) {
            if(isset($this->{$k})) {
                $this->{$k} = $v;
            }
        }
    }
}