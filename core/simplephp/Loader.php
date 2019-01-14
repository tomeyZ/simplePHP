<?php
namespace core\simplephp;

/**
 * 框架自动加载类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class Loader
{
	/**
	 * 自动加载
	 * @access public
	 * @param string $class 类名称
	 * @return void
	 */
	public static function autoload($class)
	{
		$class = str_replace('\\', '/', trim($class, '\\'));
		$file  = ROOT_PATH . $class . '.php';
		if ( file_exists($file) ) {
			include $file;
		}
	}

	/**
	 * 注册自动加载
	 * @access public
	 * @return void
	 */
	public static function register()
	{
		spl_autoload_register(__NAMESPACE__ . '\\Loader::autoload');
	}
}