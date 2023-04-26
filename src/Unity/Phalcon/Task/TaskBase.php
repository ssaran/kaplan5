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

    /**
     * Encode token.
     */
    public function encodeToken($data)
    {

        // Encode token
        $token_encoded = $this->jwt->encode($data, $this->globalConfig->authentication->secret);
        //$token_encoded = $this->crypt->encryptBase64($token_encoded);
        //$token_encoded = $this->crypt->encrypt($token_encoded);
        //return base64_encode($token_encoded);
        return $token_encoded;
    }

    /**
     * @param $token
     * @return bool|string
     */
    public function decodeToken($token)
    {
        // Decode token
        //$token = base64_decode($token);
        //$token = $this->crypt->decryptBase64($token);
        //$token = $this->crypt->decrypt($token);
        $token = $this->jwt->decode($token, $this->globalConfig->authentication->secret, array('HS256'));
        return $token;
    }

    protected function setup()
    {
        try {

            $this->config = $this->getDI()->getShared('config');
            $this->di = $this->getDI();

            $cfg = new \Common\Config\Api();
            $this->config->xrp = $cfg->config;
        } catch (\Exception $e) {
            echo $e->getMessage()."\n";
            echo $e->getLine()."\n";
            throw $e;
        }
    }

    /**
     * @param bool $domain
     * @throws \Exception
     */
    protected function setupXrpClient($domain=false)
    {
        try {
            $this->domain = (!$domain) ? $this->config->bapi->domain : $domain;

            $this->xrpClient = new \Xrp\Common\Helper\Http\Request($this->config->xrp,$this->domain);
            $this->token = $this->xrpClient->GetToken();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function getCompanyConfig($companyAccountId=false)
    {
        try {
            if(!$companyAccountId) {
                $this->companyAccountId = $this->config->bapi->companyId;
            } else {
                $this->companyAccountId = $companyAccountId;
            }

            $this->companyConfig = $this->xrpClient->FetchCompanyConfig($this->companyAccountId);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function frontLogin($isBapi=false,$user=false,$pass=false)
    {
        try {
            if(!$user) {
                $user = $this->config->bapi->user;
            }
            if(!$pass) {
                $pass = $this->config->bapi->pass;
            }

            $loginUrl = ($isBapi) ? $this->config->xrp->api->behalf->urls->loginBapi->action : $this->config->xrp->api->behalf->urls->login->action;



            $_m = new \Xrp\Common\Front\Login($this->setup,$this->domain);
            $l = $_m->Process($user,$pass,$this->token,$this->config->xrp->api->behalf->host.$loginUrl,$isBapi);

            $this->setup->Frontuser = $l;
        } catch (\Exception $e) {
            throw $e;
        }

    }


    protected function requestSetup()
    {
        $predefinedStartDate = PX_CTIME - (15*86400);
        $DateStart = date('d.m.Y',$predefinedStartDate);
        $DateEnd = date('d.m.Y',PX_CTIME-60);
        $TimeStart = u::toTimeStartUnix($DateStart);
        $TimeEnd = u::toTimeStartUnix($DateEnd);

        $this->setup = new \K5\Entity\Request\Setup([
            'Config'=> $this->config,
            'TemplatesDir'=> TEMPLATES_DIR,
            'BaseUrl'=> '/',
            'Employer'=> false,
            'IsAjax'=> false,
            'Page'=> 1,
            'DomDestination'=> false,
            'IsMobile'=> false,
            'IsModal'=> false,
            'DateStart'=> $DateStart,
            'DateEnd'=> $DateStart,
            'TimeStart'=> $TimeStart,
            'TimeEnd'=> $TimeEnd,
            'Post'=> [],
            'Get'=> []
        ]);
    }

}