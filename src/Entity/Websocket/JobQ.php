<?php

namespace K5\Entity\Websocket;

class JobQ
{
    public string $ws;
    public int $dfd;
    public \K5\Entity\Websocket\Event $event;
}
