<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.11.2019
 * Time: 11:57
 */

namespace K5\Unity\Phalcon\Task;


use K5\U as u;

class TaskBase extends \Phalcon\Mvc\Application
{
    const KEY_CONN = "conn_";
    const KEY_TIMER = "timer_";
    const WS_PING_DELAY = 5000;

    public $redisCache;

    protected $config;
    protected $di;
    /** @var \K5\Entity\Request\Setup */
    protected \K5\Entity\Request\Setup $setup;
    protected $token;
    protected $domain;
    protected $companyAccountId;

    protected $companyConfig;
    /** @var \Xrp\Common\Entity\Auth\FrontUser */
    protected $frontUser;

    public function __construct()
    {
        parent::__construct();
        $this->setup();
    }

    public function GetConfig()
    {
        return $this->config;
    }

    protected function setup()
    {
        $this->config = $this->getDI()->get('config');
        $this->di = $this->getDI();

        $cfg = new \Common\Config\Api();
        $this->config->xrp = $cfg->config;
    }
}