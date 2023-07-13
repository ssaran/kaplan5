<?php


namespace K5\Component;


class Route
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