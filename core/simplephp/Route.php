<?php
namespace core\simplephp;

use core\simplephp\Config;

/**
 * 框架核心路由类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class Route
{
	/**
	 * @var string 控制器
	 */
	public $controller;

	/**
	 * @var string 方法
	 */
	public $action;

	public function __construct()
	{
		$defaultController = ucwords(Config::get('default_controller'));
		$defaultAction     = Config::get('default_action');
		if ( IS_CLI ) {
			$pathInfoStr = !empty($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null;
		} else {
			if ( isset($_SERVER['REQUEST_URI']) ) {
				$pathInfoStr = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
			}
		}

		if (empty($pathInfoStr)) {
			throw new \Exception('请求异常', 1000);
		}

		if (Config::get('pathinfo_model')) {
			$queryArr 		  = explode('?', $pathInfoStr); 
            $queryArr 		  = explode('/', trim($queryArr[0], '/'));
			$this->controller = !empty($queryArr[0]) ? $queryArr[0] : $defaultController;
        	$this->action     = !empty($queryArr[1]) ? $queryArr[1] : $defaultAction;
        	unset($queryArr[0]);
        	unset($queryArr[1]);
			$i = 2;
			foreach ($queryArr as $key => $value) {
				if (!empty($queryArr[$i+1])) {
					$_GET[$queryArr[$i]] = $queryArr[$i+1];
				}
				$i = $i + 2;
			}
		} else {
			$pathInfoStr      = !empty($pathInfoStr) ? $pathInfoStr : $_SERVER['QUERY_STRING'];
			$queryArr         = self::parseUrlQuery(trim($pathInfoStr, '?'));
			$this->controller = !empty($queryArr['c']) ? $queryArr['c'] : $defaultController;
        	$this->action     = !empty($queryArr['a']) ? $queryArr['a'] : $defaultAction;
        	unset($queryArr['c']);
        	unset($queryArr['a']);
        	$_GET = $queryArr;
		}
		$_GET = $this->stripslashesDeep($_GET);
	}

	/**
	 * 解析url中query参数
	 * @access private
	 * @param string $query url中query参数部分
	 * @return array
	 */
	private static function parseUrlQuery($query)
	{
		if (empty($query)) return ;
		$params    = [];
		$queryPart = explode('&', $query);
		foreach ($queryPart as $param) {
		    $item = explode('=', $param);
		    $params[$item[0]] = $item[1];
		}
		return $params;
	}

	/**
	 * 过滤敏感字符
	 * @access private
	 * @param  array $value 参数
	 * @return array
	 */
	private function stripslashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripslashesDeep'), $value) : stripslashes($value);
        return $value;
    }

}