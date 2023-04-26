<?php

namespace K5;

use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Adapter\Syslog;

class Log
{

    /** @var Logger */
    private static Logger $_dbg;
    /** @var Logger */
    private static Logger $_err;
    /** @var Logger */
    private static Logger $_sys;
    /** @var Logger */
    private static Logger $_auth;
    /** @var string  */
    private static string $_path = '';

    /**
     * @return bool
     */
    public static function SetInstance($sessionDomain)
    {
        if(self::$_path === ''){
            try {
                self::$_path = str_replace(".","_",\K5\PreRouter::GetSessionDomain());

                self::$_dbg = new Logger('messages',[
                    'main'=>new Stream(LOG_DIR.'dbg-'.self::$_path.'.log')
                ]);

                self::$_auth = new Logger('auth',[
                    'main'=>new Stream(LOG_DIR.'auth-'.self::$_path.'.log')
                ]);

                self::$_err = new Logger('messages',[
                    'messages'=>new Stream(LOG_DIR.'error-'.self::$_path.'.log')
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
        return true;
    }

    /**
     * @param $message
     * @return void
     */
    public static function Dbg($message) : void
    {
        self::$_dbg->debug(print_r($message,true));
    }

    /**
     * @param $message
     * @return void
     */
    public static function Error($message) : void
    {
        self::$_err->error(self::$_path." : ".print_r($message,true));
    }

    /**
     * @param $message
     * @return void
     */
    public static function Auth($message) : void
    {
        self::$_auth->debug(self::$_path." : ".print_r($message,true));
    }

    /**
     * @param $message
     * @return void
     */
    public static function Info($message) : void
    {
        syslog(LOG_NOTICE, self::$_path." - ".print_r($message,true));
    }
}