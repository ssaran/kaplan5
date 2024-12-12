<?php

namespace K5\Component\HandsonTable;

final class DataPacket
{
    public int $current_page = 0;
    public $data;
    public int $from = 0;
    public int $last_page = 0;
    public string|null $first_page_url = null;
    public string|null $last_page_url = null;
    public string|null $next_page_url = null;
    public string|null $prev_page_url = null;
    public string $path = '';
    public int $per_page = 10;
    public int $to = 0;
    public int $total = 0;
}
