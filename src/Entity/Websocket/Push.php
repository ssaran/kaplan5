<?php

namespace K5\Entity\Websocket;

class Push
{
    public int $fd;
    public \K5\Entity\Websocket\Event $event;
}
