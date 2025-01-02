<?php

namespace K5\Entity\Websocket;

class EventBodyContent
{
    public int $sfd;
    public string $type;
    public int $channel;
    public $bind;
    public string $cbcd;
    public $content;
}
