<?php

/**
 * 实例化模型类
 * @param string $name Model类名称
 * @return object
 */
function M($name = '')
{
	static $_model = null;
	if (!empty($name)) 
	{
		$modelFile = APP_PATH . 'model' . DS . $name . '.php';
		if (file_exists($modelFile)) {
			$class  = '\\app\\model\\'.$name;
			$_model = new $class();
		} else {
			throw new \Exception($modelFile.'实例化模型类不存在', 1000);
		}
	}
	return $_model;
}

/**
 * 获取服务器IP
 * @return string
 */
function getServerIp() 
{
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$ip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	$long = sprintf("%u", ip2long($ip));
	return $long ? $ip : '0.0.0.0';
}