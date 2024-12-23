<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.11.2019
 * Time: 11:57
 */

namespace K5\Unity\Phalcon\Task;

use K5\U as u;

class Base extends \Phalcon\Cli\Task
{
    const KEY_CONN = "conn_";
    const KEY_TIMER = "timer_";
    const WS_PING_DELAY = 5000;

    /** @var \K5\Entity\Request\Setup */
    protected \K5\Entity\Request\Setup $setup;
    protected ?string $domain = null;
    protected ?string $subDomain = null;
    protected ?array $params = null;

    public function initialize()
    {

    }

    public function SetDomain(string $domain) : void
    {
        $this->domain = $domain;
    }

    public function SetSubDomain(string $subDomain) : void
    {
        $this->subDomain = $subDomain;
    }

    public function GetDomain() : ?string
    {
        return $this->domain;
    }

    public function GetSubDomain() : ?string
    {
        return $this->subDomain;
    }

    public function AddParams(string $param) : void
    {
        $this->params[] = $param;
    }
}
