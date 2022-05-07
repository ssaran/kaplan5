<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 4.14.2013
 * Time: 11:24
 */

namespace K5;

use \K5\U as u;
use phpDocumentor\Reflection\Types\Self_;

class PreRouter
{
	private static $appDir;
	private static $appConfig;
	private static $moduleDir;
	private static $controllersDir;
	private static $domain;
	private static $subDomain;
	private static $sessionDomain;
	private static $app  = "front";
	private static $module = "index";
	private static $controller = "index";
	private static $action = "index";
	private static $_module;
	private static $_controller;
	private static $_action;
	private static $namespace = "Web\\Front";
	private static $params = [];
	private static $i18n = "tr";
	private static $config;
	private static $paramModule;
	private static $paramController;
	private static $paramAction;
	private static $requestedDomainConfig;
	private static $requestMethod;
	private static $specialRouter = false;
	private static $isApi = false;
	private static $versionApi;

    private static $_server;
    private static $_u;

    public static function SetInstance($config,$server,$u){

        if(is_null(self::$_server)){
            self::$_server = $server;
            self::$_u = $u;
            self::$requestMethod = self::$_server['REQUEST_METHOD'];
            self::$config = $config;
            self::$requestedDomainConfig = self::$config->domain->default;
            self::parseDomain();

            if(isset(self::$config->domain{self::$sessionDomain})) {
                self::$requestedDomainConfig = self::$config->domain{self::$sessionDomain};
            }

            self::$app = self::$requestedDomainConfig->default->app;
            self::$module = self::$requestedDomainConfig->default->module;
            self::$controller = self::$requestedDomainConfig->default->controller;
            self::$action = self::$requestedDomainConfig->default->action;
            self::$namespace = self::$requestedDomainConfig->default->namespace;
            self::$i18n = self::$requestedDomainConfig->default->i18n;

            self::parseRoute();
            self::parseControllerTranslate();
            self::parseActionForce();
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

	public static function GetParamModule()
	{
		return self::$paramModule;
	}

	public static function GetController($real=false)
	{
        return (!$real) ? self::$controller : self::$_controller;
	}

	public static function GetParamController()
	{
		return self::$paramController;
	}

	public static function GetAction($real=false)
	{
        return (!$real) ? self::$action : self::$_action;
	}

	public static function GetParamAction()
	{
		return self::$paramAction;
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

    public static function GetSpecialRouter()
    {
        return self::$specialRouter;
    }

    public static function GetAppConfig()
    {
        return self::$appConfig;
    }

    public static function IsApi()
    {
        return self::$isApi;
    }

	private static function parseDomain()
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
                $dom = array_pop($host);
                $sub = array_pop($host);
                self::$domain = $dom.".".$top;
                self::$subDomain = $sub;
                self::$sessionDomain = $sub.".".$dom.".".$top;
            }
        }
	}

	private static function parseRoute()
	{
		self::$appConfig = self::checkAppConfig(self::$app);
		if(!self::$appConfig) {
            self::$_u::lerr("Default app conf not found. Check Config");
            die();
		}

		$parsedUrl = parse_url(self::$_server['REQUEST_URI']);

		$tmp = explode("/",trim($parsedUrl['path'],"/"));

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

    private static function routeApi($tmp)
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
            self::$_u::lerr("Api module Not Found ");
            self::$_u::lerr($tmp);
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

        $nameSpaceSpecial = self::$namespace."\\".ucfirst(\Phalcon\Text::camelize(self::$controller));

        if(isset(self::$appConfig['route_special']) && isset(self::$appConfig['route_special'][$nameSpaceSpecial])) {
            self::$specialRouter = self::$appConfig['route_special'][$nameSpaceSpecial]['router'];
        } else {
            self::$specialRouter = false;
        }
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

        if(sizeof($tmp) > 0) {
            self::$controller = array_shift($tmp);
        }

        self::$_controller = self::$controller;

        if(sizeof($tmp) > 0) {
            self::$action = array_shift($tmp);
        }
        self::$_action = self::$action;

        self::$params = $tmp;

        self::$app = self::$appConfig['directory'];

        if(self::$app == 'front') {
            if(isset(self::$config->translate->public{self::$module})) {
                self::$_u::lerr('die public dir as module');
                die();
            }
        }

        self::$module = str_replace("-","",ucwords(self::$module, "-"));

        if(self::$appConfig['route'] == 'complex') {
            self::$namespace = self::$appConfig['namespace'] . '\\' . ucfirst(self::$module);
        } else {
            self::$action = self::$controller;
            self::$controller = self::$module;
            self::$moduleDir = self::$appDir;
            self::$controllersDir = self::$moduleDir;
            self::$namespace = self::$appConfig['namespace'];
        }

        $nameSpaceSpecial = self::$namespace."\\".ucfirst(\Phalcon\Text::camelize(self::$controller));
        if(isset(self::$appConfig['route_special']) && isset(self::$appConfig['route_special'][$nameSpaceSpecial])) {
            self::$specialRouter = self::$appConfig['route_special'][$nameSpaceSpecial]['router'];
        } else {
            self::$specialRouter = false;
        }
    }

	private static function parseControllerTranslate()
	{
		if(!isset(self::$config->translate->{self::$app})) {
			return;
		}
		$tData = self::$config->translate->{self::$app};

		if(!isset($tData->{self::$controller})) {
			return;
		}
		self::$paramController = self::$controller;
		self::$controller = $tData->{self::$controller};
	}

	private static function parseActionForce()
	{
		if(!isset(self::$config->force->{self::$controller})) {
			return;
		}

		$tData = self::$config->force->{self::$controller};

		self::$paramAction = self::$action;
		self::$action = $tData->{self::$action};
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
	    \K5\U::ldbg("Requested domain config"." : -".$app."-");
        \K5\U::ldbg(self::$requestedDomainConfig);
		if(isset(self::$requestedDomainConfig->app->{$app})) {
			return self::$requestedDomainConfig->app->{$app};
		}
		return false;
	}

	private static function printTest()
	{
		echo "---------------<br>";
		echo "LANG :".self::$i18n."<br>";
		echo "APP :".self::$app."<br>";
		echo "MODULE :".self::$module."<br>";
		echo "CONTROLLER :".self::$controller." PARAM-CONTROLLER :".self::$paramController."<br>";
		echo "ACTION :".self::$action."<br>";
		echo "NAMESPACE :".self::$namespace."<br>";
		echo "---------------<br><br>";
	}

	public static function Ldbg()
	{
        self::$_u::linfo(self::$requestedDomainConfig);
		self::$_u::linfo("-LDBG----------");
		self::$_u::linfo("SESSION DOMAIN :".self::$sessionDomain."");
		self::$_u::linfo("SUBDOMAIN :".self::$subDomain."");
		self::$_u::linfo("LANG :".self::$i18n."");
		self::$_u::linfo("APP :".self::$app."");
		self::$_u::linfo("MODULE :".self::$module."");
		self::$_u::linfo("CONTROLLER :".self::$controller." PARAM-CONTROLLER :".self::$paramController."");
		self::$_u::linfo("ACTION :".self::$action."");
		self::$_u::linfo("NAMESPACE :".self::$namespace."");
		self::$_u::linfo("/LDBG----------");
	}

    public static function Lerr()
    {
        self::Ldbg();
    }

    public static function GetInfo()
    {
        $r['DOMAIN-CONFIG'] = self::$requestedDomainConfig;
        $r['LANG'] = self::$i18n;
        $r['APP'] = self::$app;
        $r['MODULE'] = self::$module;
        $r['CONTROLLER'] = self::$controller;
        $r['ACTION'] = "ACTION :".self::$action;
        $r['PARAM-CONTROLLER'] = self::$paramController;
        $r['NAMESPACE'] = self::$namespace;
        return $r;
    }

}
