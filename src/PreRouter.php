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
    private static \Phalcon\Config\Config $config;
    private static \Phalcon\Config\Config $appConfig;
    private static \Phalcon\Config\Config $requestedDomainConfig;
    private static ?string $requestMethod = null;
    private static string $_module;
    private static string $_controller;
    private static string $_action;
    private static array $params = [];
    private static array $tmp = [];
    private static string $i18n = "tr";
    private static bool $isApi = false;
    private static bool $isService = false;
    private static ?int $versionApi = null;

    private static ?array $_server = null;
    private static \K5\Entity\Request\Route $_route;

    public static function SetInstance($config,$server) : bool
    {
        if(is_null(self::$_server)){
            self::$_route = new \K5\Entity\Request\Route();
            self::$_server = $server;
            self::$config = $config;
            self::$requestedDomainConfig = self::$config->routes;

            if(!isset(self::$_server['SHELL'])) {
                self::$requestMethod = self::$_server['REQUEST_METHOD'];
                self::parseDomain();


                self::$_route->app = self::$requestedDomainConfig->default->app;
                self::$_route->module = self::$requestedDomainConfig->default->module;
                self::$_route->deep = null;
                self::$_route->controller = self::$requestedDomainConfig->default->controller;
                self::$_route->action = self::$requestedDomainConfig->default->action;
                self::$_route->namespace = self::$requestedDomainConfig->default->namespace;
                self::$_route->i18n = self::$requestedDomainConfig->default->i18n;

                if(isset(self::$requestedDomainConfig->hasCms) && self::$requestedDomainConfig->hasCms) {
                    self::$_route->hasCms = self::$requestedDomainConfig->hasCms;
                    if(isset(self::$requestedDomainConfig->cmsForceDomain) && !empty(self::$requestedDomainConfig->cmsForceDomain)) {
                        self::$_route->cmsDomain = self::$requestedDomainConfig->cmsForceDomain;
                    } else {
                        self::$_route->cmsDomain = self::$_route->sessionDomain;
                    }
                }

                self::parseRoute();
            } else {
                self::$_route->app = self::$requestedDomainConfig->default->app;
                self::$_route->module = self::$requestedDomainConfig->default->module;
                self::$_route->deep = null;
                self::$_route->controller = self::$requestedDomainConfig->default->controller;
                self::$_route->action = self::$requestedDomainConfig->default->action;
                self::$_route->namespace = self::$requestedDomainConfig->default->namespace;
                self::$_route->i18n = self::$requestedDomainConfig->default->i18n;
            }
        }
        return true;
    }

    public static function GetDomain()
    {
        return self::$_route->domain;
    }

    public static function GetSubDomain()
    {
        return self::$_route->subDomain;
    }

    public static function GetSessionDomain()
    {
        return self::$_route->sessionDomain;
    }

    public static function GetCmsDomain() : ?string
    {
        return (self::$_route->hasCms) ? self::$_route->cmsDomain : 'nada';
    }

    public static function GetNameSpace() : string
    {
        return self::$_route->namespace;
    }

    public static function GetApp()
    {
        return self::$_route->app;
    }

    public static function GetModule($real=false)
    {
        return (!$real) ? self::$_route->module : self::$_module;
    }

    public static function GetController($real=false)
    {
        return (!$real) ? self::$_route->controller : self::$_controller;
    }

    public static function GetAction($real=false)
    {
        return (!$real) ? self::$_route->action : self::$_action;
    }

    public static function GetParams()
    {
        return self::$_route->params;
    }

    public static function GetI18n()
    {
        return self::$_route->i18n;
    }

    public static function GetRequestMethod()
    {
        return self::$requestMethod;
    }

    public static function GetAppConfig()
    {
        return self::$appConfig;
    }

    public static function IsApi() : bool
    {
        return self::$isApi;
    }

    public static function GetRouteObject() : \K5\Entity\Request\Route
    {
        return self::$_route;
    }

    public static function CreateEmployer() : string
    {
        return str_replace(".","_",self::GetSessionDomain());
    }

    public static function CreateIssuerKey(int $offset = 3, bool $trim = true) : string
    {
        $_arr = explode("\\",strtolower(\K5\PreRouter::GetNameSpace()));
        if($trim) {
            array_pop($_arr);
        }
        return implode("_",array_slice($_arr,$offset));
    }

    public static function GetRequestedDomainConfig()
    {
        return self::$requestedDomainConfig;
    }

    private static function parseDomain() : void
    {
        self::$_route->subDomain = null;
        if(isset(self::$_server['HTTP_X_ORIGINAL_HOST'])) {
            self::$_route->domain = self::$_server['HTTP_X_ORIGINAL_HOST'];
            self::$_route->sessionDomain = self::$_route->domain;
        } else {
            $host = explode(".",self::$_server['HTTP_HOST']);
            if(sizeof($host) < 3) {
                self::$_route->domain = self::$_server['HTTP_HOST'];
                self::$_route->sessionDomain = self::$_route->domain;
            } else {
                $top = array_pop($host);
                if($top === 'tr' || $top === 'de' || $top === 'az' || $top === 'fr' ) {
                    $top = array_pop($host).".".$top;
                }
                $dom = array_pop($host);
                $sub = array_pop($host);
                self::$_route->domain = $dom.".".$top;
                self::$_route->subDomain = $sub;
                self::$_route->sessionDomain = self::$_server['HTTP_HOST'];
            }
        }
    }

    private static function parseRoute() : void
    {
        /* Default app conf for config detection */
        self::$appConfig = self::checkAppConfig(self::$_route->app);
        if(!self::$appConfig) {
            self::log("Default app conf not found. Check Config : ".self::$_route->app." - ".self::$_server['REQUEST_URI'],'error');
            die();
        }

        self::$tmp['parsedUrl'] = parse_url(str_replace("//","/",self::$_server['REQUEST_URI']));
        self::$tmp['aParsedUrl'] = explode("/",trim(self::$tmp['parsedUrl']['path'],"/"));
        self::$_route->tmp = self::$tmp;
        $tmp = self::$tmp['aParsedUrl'];
        if(count($tmp) <= 0) {
            return;
        }

        $current = array_shift($tmp);
        $cLang = self::checkLanguageConfig($current);
        if(!is_null($cLang)) {
            self::$_route->i18n = $cLang;
            $current = array_shift($tmp);
        }

        $rState = ($current !== 'api') ? self::routeWeb($tmp,$current) : self::routeApi($tmp);
    }

    private static function routeWeb($tmp,$current) : bool
    {
        self::$_route->isApi = false;
        self::$_route->isService = false;

        if($current !== 'services') {
            $cConfig = self::checkAppConfig($current);
            if($cConfig) {
                self::$appConfig = $cConfig;
                $current = null;
            }
        } else {
            if(sizeof($tmp) > 0) {
                $current = array_shift($tmp);
                $cConfig = self::checkServicesConfig($current);
                if($cConfig) {
                    self::$appConfig = $cConfig;
                    $current = null;
                }
            }
        }

        if($current != '') {
            self::$_route->module = $current;
        } else {
            if(sizeof($tmp) > 0) {
                self::$_route->module = array_shift($tmp);
            }
        }

        $_fixedModule = null;
        if(isset(self::$appConfig['fixedModule']) && isset(self::$appConfig['fixedModule'][self::$_route->module])) {
            $_fixedModule = self::$appConfig['fixedModule'][self::$_route->module];
        }
        self::$_module = self::$_route->module;

        if(self::$appConfig['route'] === 'deep') {
            if(sizeof($tmp) > 0) {
                self::$_route->deep = array_shift($tmp);
            }
        }
        /** Check forced index */
        $_fController = null;
        if(isset(self::$appConfig['forceModuleController']) && isset(self::$appConfig['forceModuleController'][self::$_route->module])) {
            $_fController = self::$appConfig['forceModuleController'][self::$_route->module];
        }

        if(sizeof($tmp) > 0) {
            self::$_route->controller = array_shift($tmp);
        }

        if(sizeof($tmp) > 0) {
            self::$_route->action = array_shift($tmp);
        }
        self::$_action = self::$_route->action;

        if(sizeof($tmp) > 0) {
            foreach($tmp as $tk => $tv) {
                self::$_route->params[$tk] = $tv;
            }
        }

        self::$_route->app = self::$appConfig['directory'];

        if(self::$_route->app == 'front') {
            if(isset(self::$config->translate->public->{self::$_route->module})) {
                self::log('die public dir as module','error');
                die();
            }
        }

        self::$_route->module = str_replace("-","",ucwords(self::$_route->module, "-"));

        //---- Refit Fixed Module (route selected modules to single module)
        if(!is_null($_fixedModule)) {
            self::$_route->params['fixed_module'] = self::$_route->module;
            self::$_route->module = $_fixedModule['module'];
            self::$_module = self::$_route->module;
            if(isset($_fixedModule['staticController'])) {
                if(!is_null($_fController)) {
                    self::$_route->params['forced_controller'] = $_fController;
                    $_fController = null;
                } else {
                    self::$_route->params['forced_controller'] = self::$_route->controller;
                }
                self::$_route->controller = $_fixedModule['staticController'];
            }
            if(isset($_fixedModule['actionAsParam'])) {
                self::$_route->params['action'] = self::$_route->action;
                self::$_route->action = 'index';
                self::$_action = self::$_route->action;
            }
        }

        //--- Refit Forced controller to structure.
        if(!is_null($_fController)) {
            self::$_route->params['forced_controller'] = self::$_route->controller;
            self::$_route->controller = $_fController;
        }
        self::$_controller = self::$_route->controller;
        self::$_route->namespace = self::$appConfig['namespace'] . '\\' . ucfirst(self::$_route->module);
        if(!is_null(self::$_route->deep)) {
            self::$_route->namespace = self::$appConfig['namespace'] . '\\' . ucfirst(self::$_route->module). '\\' . ucfirst(self::$_route->deep);
        }

        return true;
    }

    private static function routeApi($tmp) : bool
    {
        self::$isApi = true;
        self::$_route->isApi = true;

        $current = array_shift($tmp);
        $cConfig = self::checkAppConfig($current);
        if($cConfig) {
            self::$appConfig = $cConfig;
            self::$_route->module = $current;
            $current = null;
        }

        if($current !== null) {
            self::log("Api module Not Found ",'error');
            self::log($tmp,'error');
            return false;
        }

        self::$_module = self::$_route->module;
        self::$versionApi = array_shift($tmp);
        if(sizeof($tmp) > 0) {
            self::$_route->controller = array_shift($tmp);
        }

        self::$_controller = self::$_route->controller;
        if(strpos(self::$_route->controller,"-")) {
            self::$_route->controller = str_replace(" ","",ucwords(str_replace("-"," ",self::$_route->controller)));
        }

        if(sizeof($tmp) > 0) {
            self::$_route->action = array_shift($tmp);
        }
        self::$_action = self::$_route->action;

        if(sizeof($tmp) > 0) {
            foreach($tmp as $tk => $tv) {
                self::$_route->params[$tk] = $tv;
            }
        }

        self::$_route->app = self::$appConfig['directory'];

        self::$_route->module = str_replace("-","",ucwords(self::$_route->module, "-"));
        self::$_route->namespace = self::$appConfig['namespace'] . '\\' . ucfirst(self::$versionApi);

        return true;
    }

    private static function checkLanguageConfig($lang)
    {
        if(isset(self::$config->language->{$lang})) {
            return $lang;
        }
        return null;
    }

    private static function checkAppConfig($app)
    {
        return (isset(self::$requestedDomainConfig->app->{$app})) ? self::$requestedDomainConfig->app->{$app} : null;
    }

    private static function checkServicesConfig($app)
    {
        return (isset(self::$requestedDomainConfig->services->{$app})) ? self::$requestedDomainConfig->services->{$app} : null;
    }

    public static function ParseDefault($routes,string $prefix=null,bool $hasLeadUnderscore=false)
    {
        $obj = new $routes();
        $vars = get_object_vars($obj);

        $_prefix = (!is_null($prefix)) ? $prefix.'/' : '/';
        if($hasLeadUnderscore) {
            $_prefix = $_prefix.'_';
        }
        foreach($vars as $key => $v) {
            $arr = ($hasLeadUnderscore) ? explode("_",substr($key, 1)) : explode("_",$key);
            $val = $_prefix;

            foreach ($arr as $path) {
                $val.= mb_strtolower(self::FromCamelCase($path,"-"))."/";
            }
            $obj->{$key} = $val;
        }
        return $obj;
    }

    protected static function log($message,$type='debug') : void
    {
        openlog('k5_preroute', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
        if($type == 'error') {
            syslog(LOG_ERR, 'PreRouter -'.$type.'- '.print_r($message,true));
        } else {
            syslog(LOG_INFO, 'PreRouter -'.$type.'- '.print_r($message,true));
        }
        closelog();
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
        self::$_route->app = $app;
        self::$_route->module = $module;
        self::$_route->namespace = $namespace;
        self::$_route->controller = $controller;
        self::$_route->action = $action;
        if(!is_null($params)) {
            self::$_route->params = $params;
        }
    }

    public static function Ldbg($is_error = false) : void
    {
        $_msg = self::GetInfo();
        (!$is_error) ? self::log($_msg) : self::log($_msg,'error');
    }

    public static function Lerr() : void
    {
        self::Ldbg(true);
    }

    public static function GetInfo()
    {
        return [
            'SESSION_DOMAIN'=>self::$_route->sessionDomain,
            'SUBDOMAIN'=>!is_null(self::$_route->subDomain) ? self::$_route->subDomain : '',
            'LANG'=>self::$_route->i18n,
            'APP'=>self::$_route->app,
            'MODULE'=>self::$_route->module,
            'CONTROLLER'=>self::$_route->controller,
            'ACTION'=>self::$_route->action,
            'PARAMS'=>self::$_route->params,
            'NAMESPACE'=>self::$_route->namespace,
            'APP-CONFIG'=>self::$appConfig,
            'TMP'=>self::$tmp
        ];
    }
}
