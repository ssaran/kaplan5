<?php

namespace K5\Entity\Websocket;

class EventBody
{
    public string $from;
    public string $to;
    public string $toProto = "https";
    public string $toParams;
    public int $dfd;
    public string $token;
    public string $type;
    public int $bounce;
    public int $is_test = 1;
    public int $tab_close = 0;
    public \K5\Entity\Websocket\EventBodyContent $content;
}
