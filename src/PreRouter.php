<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 4.14.2013
 * Time: 11:24
 */

namespace K5;

class PreRouter
{
    private static $config;
    private static $appConfig;
    private static $requestedDomainConfig;
    private static $requestMethod;
    private static string $domain;
    private static ?string $subDomain = null;
    private static string $sessionDomain;
    private static string $app  = "front";
    private static string $module = "index";
    private static string $controller = "index";
    private static string $action = "index";
    private static string $_module;
    private static string $_controller;
    private static string $_action;
    private static ?string $namespace = null;
    private static array $params = [];
    private static array $tmp = [];
    private static string $i18n = "tr";
    private static bool $isApi = false;
    private static ?int $versionApi = null;

    private static ?array $_server = null;

    public static function SetInstance($config,$server)
    {
        if(is_null(self::$_server)){
            self::$_server = $server;
            self::$config = $config;
            self::$requestedDomainConfig = self::$config->domain->default;

            if(!isset(self::$_server['SHELL'])) {
                self::$requestMethod = self::$_server['REQUEST_METHOD'];
                self::parseDomain();

                if(isset(self::$config->domain[self::$sessionDomain])) {
                    self::$requestedDomainConfig = self::$config->domain[self::$sessionDomain];
                }

                self::$app = self::$requestedDomainConfig->default->app;
                self::$module = self::$requestedDomainConfig->default->module;
                self::$controller = self::$requestedDomainConfig->default->controller;
                self::$action = self::$requestedDomainConfig->default->action;
                self::$namespace = self::$requestedDomainConfig->default->namespace;
                self::$i18n = self::$requestedDomainConfig->default->i18n;

                self::parseRoute();
            } else {
                self::$app = self::$requestedDomainConfig->default->app;
                self::$module = self::$requestedDomainConfig->default->module;
                self::$controller = self::$requestedDomainConfig->default->controller;
                self::$action = self::$requestedDomainConfig->default->action;
                self::$namespace = self::$requestedDomainConfig->default->namespace;
                self::$i18n = self::$requestedDomainConfig->default->i18n;
            }
        }
        return true;
    }

    public static function GetDomain()
    {
        return self::$domain;
    }

    public static function GetSubDomain()
    {
        return self::$subDomain;
    }

    public static function GetSessionDomain()
    {
        return self::$sessionDomain;
    }

    public static function GetNameSpace()
    {
        return self::$namespace;
    }

    public static function GetApp()
    {
        return self::$app;
    }

    public static function GetModule($real=false)
    {
        return (!$real) ? self::$module : self::$_module;
    }

    public static function GetController($real=false)
    {
        return (!$real) ? self::$controller : self::$_controller;
    }

    public static function GetAction($real=false)
    {
        return (!$real) ? self::$action : self::$_action;
    }

    public static function GetParams()
    {
        return self::$params;
    }

    public static function GetI18n()
    {
        return self::$i18n;
    }

    public static function GetRequestMethod()
    {
        return self::$requestMethod;
    }

    public static function GetAppConfig()
    {
        return self::$appConfig;
    }

    public static function IsApi()
    {
        return self::$isApi;
    }

    public static function CreateEmployer() : string
    {
        return str_replace(".","_",self::GetSessionDomain());
    }

    private static function parseDomain() : void
    {
        if(isset(self::$_server['HTTP_X_ORIGINAL_HOST'])) {
            self::$domain = self::$_server['HTTP_X_ORIGINAL_HOST'];
            self::$sessionDomain = self::$domain;
        } else {
            $host = explode(".",self::$_server['HTTP_HOST']);
            if(sizeof($host) < 3) {
                self::$domain = self::$_server['HTTP_HOST'];
                self::$sessionDomain = self::$domain;
            } else {
                $top = array_pop($host);
                if($top == 'tr') {
                    $top.=".".array_pop($host);
                }
                $dom = array_pop($host);
                $sub = array_pop($host);
                self::$domain = $dom.".".$top;
                self::$subDomain = $sub;
                self::$sessionDomain = self::$_server['HTTP_HOST'];
            }
        }
    }

    private static function parseRoute() : void
    {
        self::$appConfig = self::checkAppConfig(self::$app);
        if(!self::$appConfig) {
            self::logErr("Default app conf not found. Check Config : ".self::$app." - ".self::$_server['REQUEST_URI']);
            die();
        }

        self::$tmp['parsedUrl'] = parse_url(str_replace("//","/",self::$_server['REQUEST_URI']));
        self::$tmp['aParsedUrl'] = explode("/",trim(self::$tmp['parsedUrl']['path'],"/"));
        $tmp = self::$tmp['aParsedUrl'];
        if(sizeof($tmp) < 1) {
            return;
        }

        $current = array_shift($tmp);
        $cLang = self::checkLanguageConfig($current);
        if($cLang != false) {
            self::$i18n = $cLang;
            $current = array_shift($tmp);
        }

        if($current !== 'api') {
            self::routeWeb($tmp,$current);
        } else {
            self::routeApi($tmp);
        }
    }

    private static function routeApi($tmp) : bool
    {
        self::$isApi = true;

        $current = array_shift($tmp);
        $cConfig = self::checkAppConfig($current);
        if($cConfig) {
            self::$appConfig = $cConfig;
            self::$module = $current;
            $current = null;
        }

        if($current !== null) {
            self::logErr("Api module Not Found ");
            self::logErr($tmp);
            return false;
        }

        self::$_module = self::$module;
        self::$versionApi = array_shift($tmp);
        if(sizeof($tmp) > 0) {
            self::$controller = array_shift($tmp);
        }

        self::$_controller = self::$controller;
        if(strpos(self::$controller,"-")) {
            self::$controller = str_replace(" ","",ucwords(str_replace("-"," ",self::$controller)));
        }

        if(sizeof($tmp) > 0) {
            self::$action = array_shift($tmp);
        }
        self::$_action = self::$action;

        self::$params = $tmp;

        self::$app = self::$appConfig['directory'];

        self::$module = str_replace("-","",ucwords(self::$module, "-"));
        self::$namespace = self::$appConfig['namespace'] . '\\' . ucfirst(self::$versionApi);

        return true;
    }

    private static function routeWeb($tmp,$current)
    {
        $cConfig = self::checkAppConfig($current);
        if($cConfig) {
            self::$appConfig = $cConfig;
            $current = null;
        }

        if($current != '') {
            self::$module = $current;
        } else {
            if(sizeof($tmp) > 0) {
                self::$module = array_shift($tmp);
            }
        }
        self::$_module = self::$module;

        /** Check forced index */
        $_fController = null;
        if(isset(self::$appConfig['forceModuleController']) && isset(self::$appConfig['forceModuleController'][self::$module])) {
            $_fController = self::$appConfig['forceModuleController'][self::$module];
        }


        if(sizeof($tmp) > 0) {
            self::$controller = array_shift($tmp);
        }

        if(sizeof($tmp) > 0) {
            self::$action = array_shift($tmp);
        }
        self::$_action = self::$action;

        self::$params = $tmp;

        self::$app = self::$appConfig['directory'];

        if(self::$app == 'front') {
            if(isset(self::$config->translate->public->{self::$module})) {
                self::logErr('die public dir as module');
                die();
            }
        }

        self::$module = str_replace("-","",ucwords(self::$module, "-"));

        //--- Refit Forced controller to structure.
        if(!is_null($_fController)) {
            self::$params['forced_controller'] = self::$controller;
            self::$controller = $_fController;
        }
        self::$_controller = self::$controller;
        self::$namespace = self::$appConfig['namespace'] . '\\' . ucfirst(self::$module);
    }

    private static function checkLanguageConfig($lang)
    {
        if(isset(self::$config->language->{$lang})) {
            return $lang;
        }
        return false;
    }

    private static function checkAppConfig($app)
    {

        if(isset(self::$requestedDomainConfig->app->{$app})) {
            return self::$requestedDomainConfig->app->{$app};
        }
        return false;
    }

    public static function Ldbg($is_error = false) : void
    {
        $_msg = self::GetInfo();

        if(!$is_error) {
            self::logDbg($_msg);
        } else {
            self::logErr($_msg);
        }
    }

    public static function Lerr()
    {
        self::Ldbg(true);
    }

    public static function GetInfo()
    {
        return [
            'SESSION_DOMAIN'=>self::$sessionDomain,
            'SUBDOMAIN'=>!is_null(self::$subDomain) ? self::$subDomain : '',
            'LANG'=>self::$i18n,
            'APP'=>self::$app,
            'MODULE'=>self::$module,
            'CONTROLLER'=>self::$controller,
            'ACTION'=>self::$action,
            'PARAMS'=>self::$params,
            'NAMESPACE'=>self::$namespace,
            'APP-CONFIG'=>self::$appConfig,
            'TMP'=>self::$tmp
        ];
    }

    public static function ParseDefault($routes,$prefix=false)
    {
        $obj = new $routes();
        $vars = get_object_vars($obj);

        $_prefix = ($prefix !== false ) ? $prefix.'/' : '/';

        foreach($vars as $key => $v) {
            $arr = explode("_",$key);
            $val = $_prefix;
            foreach ($arr as $path) {
                $val.= mb_strtolower(self::FromCamelCase($path,"-"))."/";
            }
            $obj->{$key} = $val;
        }
        return $obj;
    }

    protected static function log($message,$type='debug')
    {
        openlog('php', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        if($type == 'error') {
            syslog(LOG_ERR, 'PreRouter -'.$type.'- '.print_r($message,true));
        } else {
            syslog(LOG_INFO, 'PreRouter -'.$type.'- '.print_r($message,true));
        }
        closelog();
    }

    protected static function logErr($message)
    {
        self::log($message,'error');
    }

    protected static function logDbg($message)
    {
        self::log($message,'debug');
    }

    public static function FromCamelCase($camelCaseString,string $seperator=" ")
    {
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, $camelCaseString);
        return join($seperator, $a );
    }

    public static function ToCamelCase(string $str,string $seperator="-")
    {
        return str_replace($seperator, '', ucwords($str, $seperator));
    }

    /**
     * @param string $namespace
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return void
     */
    public static function ForceRoute(string $app, string $module, string $namespace,string $controller,string $action = 'index',?array $params = []):void
    {
        self::$app = $app;
        self::$module = $module;
        self::$namespace = $namespace;
        self::$controller = $controller;
        self::$action = $action;
        if(!is_null($params)) {
            self::$params = $params;
        }
    }
}
