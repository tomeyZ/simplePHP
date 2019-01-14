<?php
namespace core\simplephp;

/**
 * 框架配置文件类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class Config
{
	/**
	 * @var string 配置参数项
	 */
	private static $config = [];

	/**
     * @var string 参数作用域
     */
	private static $range  = '_config_';

	/**
	 * 获取指定配置参数值
	 * @access public
	 * @param  string $name 配置项名称
	 * @param  string $file 配置文件名，默认config
	 * @return mixed
	 */
	public static function get($name = '', $file = 'config')
	{
		if ( empty($name) && isset(self::$config[$file]) ) {
			return self::$config[$file];
		}

		if ( !isset(self::$config[$file]) ) {
			self::load($file);	
		}
		
		return isset(self::$config[$file][$name]) ? self::$config[$file][$name] : null;

	}

	/**
	 * 加载配置文件
	 * @access public
	 * @param  string $file 配置文件名，为空则返回所有配置项
	 * @return mixed
	 */
	public static function load($file = '')
	{
		$range = empty($file) ? self::$range : $file;
		if ( !isset(self::$config[$range]) ) {
			self::$config[$range] = [];
		}

		// 如果查询配置项范围为空，则遍历配置文件目录下所有文件内容返回
		if ( '_config_' == $range ) {
			$files = scandir(CONFIG_PATH);
			foreach ($files as $file) {
				if ( '.' != $file && '..' != $file ) {
					$fileName = substr($file, 0, strripos($file, '.'));
					self::$config[$range][$fileName] = include CONFIG_PATH . strtolower($file);
				}
			}
		} else {
			$file = CONFIG_PATH . strtolower($file) . '.php';
			if ( is_file($file) ) {
				self::$config[$range] = include $file;
			}
		}
		return self::$config[$range];
	}
}