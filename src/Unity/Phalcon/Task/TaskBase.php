<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.11.2019
 * Time: 11:57
 */

namespace K5\Unity\Phalcon\Task;


use K5\U as u;

class TaskBase extends \Phalcon\Cli\Task
{
    const KEY_CONN = "conn_";
    const KEY_TIMER = "timer_";
    const WS_PING_DELAY = 5000;

    /** @var \K5\Entity\Request\Setup */
    protected \K5\Entity\Request\Setup $setup;

    public function initialize()
    {

    }
}