<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.11.2019
 * Time: 11:57
 */

namespace K5\Job;

use K5\U as u;

class JobBase extends \Phalcon\Mvc\User\Plugin
{
    public $JobName;
    public $JobResource;
    public $response;
    public $state;
    public $companyAccountId;
    public $responseValues='';

    protected $frontDomain;
    protected $isTest = false;
    protected $companyConfig;


    protected $setup;
    protected $frontUser = false;

    protected $config;

    public function __construct()
    {
    }

    public function SetConfig($config)
    {
        $this->config = $config;
    }



}