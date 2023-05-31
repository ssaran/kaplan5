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
use \Phalcon\Support\Helper\Str;

class PreRouter
{
	private static string $appDir;
	private static $appConfig;
	private static string $moduleDir;
	private static string $controllersDir;
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
	private static string $namespace = "Web\\Front";
	private static array $params = [];
	private static string $i18n = "tr";
	private static $config;
	private static $paramModule;
	private static $paramController;
	private static $paramAction;
	private static $requestedDomainConfig;
	private static $requestMethod;
	private static $specialRouter = null;
	private static $isApi = false;
	private static $versionApi;

    private static $_server;
    private static $_u;
    private static $_log;

    public static function SetInstance($config,$server,$u)
    {
        if(is_null(self::$_server)){
            self::$_server = $server;
            self::$_u = $u;
            self::$requestMethod = self::$_server['REQUEST_METHOD'];
            self::$config = $config;
            self::$requestedDomainConfig = self::$config->domain->default;
            self::parseDomain();

            if(isset(self::$config->domain[self::$sessionDomain])) {
                self::$requestedDomainConfig = self::$config->domain[self::$sessionDomain];
            }
            $_path = str_replace(".","_",self::$sessionDomain);


            /*self::$_log->debug(print_r(self::$config,true));
            self::$_log->debug(self::$sessionDomain);*/

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
            self::$_u::lerr("Default app conf not found. Check Config : ".self::$app." - ".self::$_server['REQUEST_URI']);
            die();
		}

		$parsedUrl = parse_url(str_replace("//","/",self::$_server['REQUEST_URI']));

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

        $cm = new \Phalcon\Support\Helper\Str\PascalCase();
        $nameSpaceSpecial = self::$namespace."\\".ucfirst($cm(self::$controller));

        if(isset(self::$appConfig['route_special']) && isset(self::$appConfig['route_special'][$nameSpaceSpecial])) {
            self::$specialRouter = self::$appConfig['route_special'][$nameSpaceSpecial]['router'];
        } else {
            self::$specialRouter = null;
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
            if(isset(self::$config->translate->public->{self::$module})) {
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

        $cm = new \Phalcon\Support\Helper\Str\PascalCase();
        $nameSpaceSpecial = self::$namespace."\\".ucfirst($cm(self::$controller));
        if(isset(self::$appConfig['route_special']) && isset(self::$appConfig['route_special'][$nameSpaceSpecial])) {
            self::$specialRouter = self::$appConfig['route_special'][$nameSpaceSpecial]['router'];
        } else {
            self::$specialRouter = null;
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

	public static function Ldbg($is_error = false)
	{
        $_config = '';
        if(IS_DEVEL) {
            //$_config = self::$requestedDomainConfig;
        }
        $_msg = [
            'CONFIG'=>$_config,
            'SESSION_DOMAIN'=>self::$sessionDomain,
            'SUBDOMAIN'=>self::$subDomain,
            'LANG'=>self::$i18n,
            'APP'=>self::$app,
            'MODULE'=>self::$module,
            'CONTROLLER'=>self::$controller,
            'PARAM-CONTROLLER'=>self::$paramController,
            'ACTION'=>self::$action,
            'NAMESPACE'=>self::$namespace
        ];

        if(!$is_error) {
            \K5\U::ldbg($_msg);
        } else {
            \K5\U::lerr($_msg);
        }
	}

    public static function Lerr()
    {
        self::Ldbg(true);
    }

    public static function GetInfo()
    {
        if(IS_DEVEL) {
            //$r['DOMAIN-CONFIg'] = self::$requestedDomainConfig;
        }

        $r['LANG'] = self::$i18n;
        $r['APP'] = self::$app;
        $r['MODULE'] = self::$module;
        $r['CONTROLLER'] = self::$controller;
        $r['ACTION'] = "ACTION :".self::$action;
        $r['PARAM-CONTROLLER'] = self::$paramController;
        $r['NAMESPACE'] = self::$namespace;
        return $r;
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
                $val.= mb_strtolower(u::FromCamelCase($path,"-"))."/";
            }
            $obj->{$key} = $val;
        }
        return $obj;
    }
}
