<?php
namespace core\simplephp;

use core\simplephp\Config;

/**
 * 框架视图类，基于Twig，Git地址：https://github.com/twigphp/Twig
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class View
{
	/**
     * @var array 参数数组
     */
	protected $variables = [];
	/**
     * @var string 控制器
     */
	protected $_controller;
	/**
     * @var string 方法
     */
	protected $_action;

	public function __construct($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action     = $action;
	}

	/**
	 * 参数赋值
	 * @access public
	 * @param  string $name  参数名
	 * @param  string $value 参数值
	 * @return void
	 */
	public function assign($name, $value)
	{
		$this->variables[$name] = $value;
	}

	/**
	 * 模板内容输出，基于Symfony项目中的Twig 2.x模板引擎
	 * Twig使用文档地址：https://twig.symfony.com/doc/2.x/
	 * @access public 
	 * @param string $file 模板文件
	 * @return void
	 */
	public function display($file)
	{
		$templateDir = APP_PATH . 'view' . DS;
		$file        = trim($file, DS);
		if ( !empty($file) ) 
		{
			if ( preg_match('/\//', $file) ) {
				$fileArr = explode('/', $file);
				$file    = array_pop($fileArr);
				foreach ($fileArr as $value) {
					$templateDir .= $value . DS;
				}
				$templateDir  = rtrim($templateDir, DS);
			} else {
				$templateDir .= $this->_controller;
			}	
		} else {
			$templateDir .= $this->_controller;
			$file         = $this->_action . '.html';
		}

		if (file_exists($templateDir . DS . $file)) {
			$loader     = new \Twig_Loader_Filesystem($templateDir);
			$tplConfig  = Config::get('template');	
			$twigConfig = [];
			if (!empty($tplConfig['tpl_cache'])) {
				$twigConfig['charset']     = Config::get('default_charset');
				$twigConfig['auto_reload'] = $tplConfig['tpl_auto_update'];
				$twigConfig['cache']       = LOG_PATH . 'compilation_cache';
			}
			$twig = new \Twig_Environment($loader, $twigConfig);
			$twig->display($file, $this->variables);
		} else {
			if (Config::get('app_debug')) {
				throw new \Exception($templateDir.DS.$file.'模板文件不存在', 1000);
			}
		}
	}
}