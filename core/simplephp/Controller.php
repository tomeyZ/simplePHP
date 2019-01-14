<?php
namespace core\simplephp;

use core\simplephp\View;

/**
 * 框架控制器类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class Controller
{
	/**
     * @var string 控制器
     */
	protected $_controller;
	/**
     * @var string 方法名
     */
	protected $_action;
	/**
     * @var string 视图对象
     */
	protected $_view;

	public function __construct($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action     = $action;
		$this->_view       = new View($controller, $action);
	}

	/**
	 * 视图层赋值
	 * @access public
	 * @param  string $name  参数名
	 * @param  string $value 参数值
	 * @return void
	 */
	public function assign($name, $value)
	{
		$this->_view->assign($name, $value);
	}

	/**
	 * 视图层输出
	 * @access public
	 * @param  string $file 模板文件名
	 * @return void
	 */
	public function display($file = '')
	{
		$this->_view->display($file);
	}

}