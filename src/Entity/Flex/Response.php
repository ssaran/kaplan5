<?php

namespace K5\Entity\Flex;

class Response extends BaseFlex
{
    public string $state;
    public string $time;
    public array $message;
    public array $payload;
}