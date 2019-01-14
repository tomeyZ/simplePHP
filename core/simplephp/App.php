<?php
namespace core\simplephp;

use core\simplephp\Config;
use core\simplephp\Route;
use core\simplephp\ErrorHandler;
use think\Db;

/**
 * 框架核心类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class App
{
	/**
	 * 运行框架程序
	 * @access public
	 * @return void
	 */
	public static function run()
	{
		$config         = self::init();
		$route          = new Route();
		$controller     = $route->controller;
		$action         = $route->action;
		$controllerFile = APP_PATH . 'controller' . DS . $controller . '.php';
		if ( file_exists($controllerFile) ) {
			include $controllerFile;
			$controllerClass = '\\app\\controller\\'.$controller;
			$controllerObj   = new $controllerClass($controller, $action);
			if ( !method_exists($controllerObj, $action) ) {
				if ($config['config']['app_debug']) {
					throw new \Exception($action.'方法不存在', 1000);
				}
			}
			$controllerObj->$action();
		} else {
			if ($config['config']['app_debug']) {
				throw new \Exception($controller.'控制器不存在', 1000);
			}
		}
	}

	/**
	 * 初始化应用或模块
	 * @access private
	 * @return array
	 */
	private static function init()
	{
		// 注册自定义错误类
		(new ErrorHandler())->register();
		
		// 加载配置文件
		$config = Config::load();
		Db::setConfig($config['database']);

		// 加载公共文件
		$commonFile = COMMON_PATH . 'functions.php';
		if ( file_exists($commonFile) ) {
			include $commonFile;
		}

		// 加载核心公共文件
		$coreCommonFile = CORE_PATH . 'common' . DS . 'functions.php';
		if ( file_exists($coreCommonFile) ) {
			include $coreCommonFile;
		}
	
		// 是否开启错误日志
		if ( $config['config']['app_debug'] ) {
			ini_set('display_error','On');
		} else {
			ini_set('display_error','Off');
		}

		// 设置系统时区
		date_default_timezone_set($config['config']['default_timezone']);
		return $config;
	}
}