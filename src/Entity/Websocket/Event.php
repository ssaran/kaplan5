<?php

namespace K5\Entity\Websocket;

class Event
{
    public string $type;
    public \K5\Entity\Websocket\EventBody $content;
    public int $X;

    public function __construct()
    {
        $this->X = time();

    }
}
