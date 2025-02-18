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
    private static ?\Phalcon\Config\Config $services;
    private static ?\Phalcon\Config\Config $appConfig;
    private static \Phalcon\Config\Config $routeConfig;
    private static ?string $requestMethod = null;
    private static array $tmp = [];
    private static ?array $_server = null;
    private static \K5\Entity\Request\Route $_route;

    public static function GetDomain() : string
    {
        return self::$_route->domain;
    }

    public static function GetSubDomain() : string
    {
        return self::$_route->subDomain;
    }

    public static function GetSessionDomain() : string
    {
        return self::$_route->sessionDomain;
    }

    public static function GetCmsDomain() : ?string
    {
        return (self::$_route->hasCms) ? self::$_route->cmsDomain : null;
    }

    public static function GetNameSpace() : string
    {
        return self::$_route->namespace;
    }

    public static function GetApp() : string
    {
        return self::$_route->app;
    }

    public static function GetController($real=false) : string
    {
        return self::$_route->controller;
    }

    public static function GetAction() : string
    {
        return self::$_route->action;
    }

    public static function GetParams() : array
    {
        return self::$_route->params;
    }

    public static function GetI18n() : string
    {
        return self::$_route->i18n;
    }

    public static function GetRequestMethod() : ? string
    {
        return self::$requestMethod;
    }

    public static function GetAppConfig() : ?\Phalcon\Config\Config
    {
        return self::$appConfig;
    }

    public static function IsApi() : bool
    {
        return self::$_route->isApi;
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

    public static function GetrouteConfig() : ?\Phalcon\Config\Config
    {
        return self::$routeConfig;
    }

    public static function GetTmp() : array
    {
        return self::$tmp;
    }

    public static function FromCamelCase($camelCaseString,string $seperator=" ") : string
    {
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, $camelCaseString);
        return join($seperator, $a );
    }

    public static function ToCamelCase(string $str,string $seperator="-") : string
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

    public static function GetInfo() : array
    {
        return [
            'SESSION_DOMAIN'=>self::$_route->sessionDomain,
            'SUBDOMAIN'=>!is_null(self::$_route->subDomain) ? self::$_route->subDomain : '',
            'LANG'=>self::$_route->i18n,
            'APP'=>self::$_route->app,
            'CONTROLLER'=>self::$_route->controller,
            'ACTION'=>self::$_route->action,
            'PARAMS'=>self::$_route->params,
            'NAMESPACE'=>self::$_route->namespace,
            'APP-CONFIG'=>self::$appConfig,
            'TMP'=>self::$tmp
        ];
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

    public static function ParseDefault($routes,string $prefix=null) : iterable
    {
        $obj = new $routes();
        $vars = get_object_vars($obj);

        $_prefix = (!is_null($prefix)) ? $prefix.'/' : '/';

        foreach($vars as $key => $v) {
            if($key[0] === '_') {
                $arr = explode("_", ltrim($key, '_'));
                $val = $_prefix.'_';
            } else {
                $arr = explode("_",$key);
                $val = $_prefix;
            }

            foreach ($arr as $path) {
                $val.= mb_strtolower(self::FromCamelCase($path,"-"))."/";
            }
            $obj->{$key} = $val;
        }
        return $obj;
    }

    public static function SetInstance(array $server,\Phalcon\Config\Config $config, ?\Phalcon\Config\Config $services) : bool
    {
        self::$config = $config;
        self::$services = $services;
        if(is_null(self::$_server)){
            self::$_route = new \K5\Entity\Request\Route();
            self::$_server = $server;
            self::$routeConfig = self::$config->routes;
            self::$_route->app = self::$routeConfig->default->app;
            /* Default app conf for config detection */
            self::$appConfig = self::checkAppConfig(self::$_route->app);
            if(is_null(self::$appConfig)) {
                self::log("Default app conf not found. Check Config : ".self::$_route->app." - ".self::$_server['REQUEST_URI'],'error');
                die();
            }

            if(!isset(self::$_server['SHELL'])) {
                self::$requestMethod = self::$_server['REQUEST_METHOD'];
                self::parseDomain();

                if(isset(self::$routeConfig->hasCms) && self::$routeConfig->hasCms) {
                    self::$_route->hasCms = self::$routeConfig->hasCms;
                    if(isset(self::$routeConfig->cmsForceDomain) && !empty(self::$routeConfig->cmsForceDomain)) {
                        self::$_route->cmsDomain = self::$routeConfig->cmsForceDomain;
                    } else {
                        self::$_route->cmsDomain = self::$_route->sessionDomain;
                    }
                }

                self::parseRoute();
            }
        }
        return true;
    }

    private static function parseDomain() : void
    {
        self::$_route->subDomain = null;
        if(isset(self::$_server['HTTP_X_ORIGINAL_HOST'])) {
            self::$_route->domain = self::$_server['HTTP_X_ORIGINAL_HOST'];
            self::$_route->sessionDomain = self::$_route->domain;
        } else {
            $host = explode(".",self::$_server['HTTP_HOST']);
            if(count($host) < 3) {
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
        self::$tmp['parsedUrl'] = parse_url(str_replace("//","/",self::$_server['REQUEST_URI']));
        self::$tmp['aParsedUrl'] = explode("/",trim(self::$tmp['parsedUrl']['path'],"/"));
        self::$_route->tmp = self::$tmp;
        if(count(self::$tmp['aParsedUrl']) <= 0) {
            return;
        }
        $tmp = self::$tmp['aParsedUrl'];
        $current = $tmp[0] ?? null;
        $cLang = self::checkLanguageConfig($current);
        if(!is_null($cLang)) {
            self::$_route->i18n = $cLang;
            array_shift($tmp);
        }
        $current = array_shift($tmp);
        if(is_null($current)) {
            return;
        }

        if($current === '_services') {
            self::$_route->isService = true;
            $current = array_shift($tmp);
            self::$appConfig = self::checkServicesConfig($current);
        } else {
            self::$appConfig = self::checkAppConfig($current); // Current is App Name
        }
        // Second app config check
        if(is_null(self::$appConfig)) {
            self::log("Default app conf not found. Check Config : -".self::$_route->isService."- ".$current." - ".self::$_server['REQUEST_URI'],'error');
            die();
        }
        self::routeWeb($tmp);
    }

    private static function routeWeb(array $tmp) : bool
    {
        $nameSpace = [];  // Default empty namespace
        $controller = 'index'; // Default controller
        switch (self::$appConfig->routeType) {
            case 'simplex':
                $controller = array_shift($tmp) ?? 'index';
                $controller = str_replace("-","",ucwords($controller, "-"));
                break;
            case 'complex':
                // Complex: First element = namespace, second = controller
                $tNs = array_shift($tmp) ?? 'index';
                $nameSpace[] = str_replace("-","",ucwords($tNs, "-"));
                $controller = array_shift($tmp) ?? 'index';
                $controller = str_replace("-","",ucwords($controller, "-"));
                break;
            case 'deep':
                // Complex: First element = namespace, second = controller
                $tNs = array_shift($tmp) ?? 'index';
                $nameSpace[] = str_replace("-","",ucwords($tNs, "-"));
                $tNs = array_shift($tmp) ?? 'index';
                $nameSpace[] = str_replace("-","",ucwords($tNs, "-"));
                $controller = array_shift($tmp) ?? 'index';
                $controller = str_replace("-","",ucwords($controller, "-"));
                break;
            case 'extended':
                // Complex: First element = namespace, second = controller
                $tNs = array_shift($tmp) ?? 'index';
                $nameSpace[] = str_replace("-","",ucwords($tNs, "-"));
                $tNs = array_shift($tmp) ?? 'index';
                $nameSpace[] = str_replace("-","",ucwords($tNs, "-"));
                $tNs = array_shift($tmp) ?? 'index';
                $nameSpace[] = str_replace("-","",ucwords($tNs, "-"));
                $controller = array_shift($tmp) ?? 'index';
                $controller = str_replace("-","",ucwords($controller, "-"));
                break;
        }

        if(count($tmp) > 0) {
            foreach($tmp as $tk => $tv) {
                self::$_route->params[$tk] = $tv;
            }
        }

        self::$_route->controller = $controller;
        self::$_route->namespace = self::$appConfig['namespace'] . '\\' . implode("\\",$nameSpace);
        
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
        return (isset(self::$routeConfig->app->{$app})) ? self::$routeConfig->app->{$app} : null;
    }

    private static function checkServicesConfig($app)
    {
        return (isset(self::$services->{$app})) ? self::$services->{$app} : null;
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

}
