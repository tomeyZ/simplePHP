<?php
namespace core\simplephp;

/**
 * 框架自定义错误异常类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class ExceptionHandler extends \ErrorException
{
	public static $customName = array(
		E_COMPILE_ERROR     => 'PHP Compile Error',
		E_COMPILE_WARNING   => 'PHP Compile Warning',
		E_CORE_ERROR        => 'PHP Core Error',
		E_CORE_WARNING      => 'PHP Core Warning',
		E_DEPRECATED        => 'PHP Deprecated',
		E_ERROR             => 'PHP Fatal Error',
		E_NOTICE            => 'PHP Notice',
		E_PARSE             => 'PHP Parse Error',
		E_RECOVERABLE_ERROR => 'PHP Recoverable Error',
		E_STRICT            => 'PHP Strict Warning',
		E_USER_DEPRECATED   => 'PHP User Deprecated Warning',
		E_USER_ERROR        => 'PHP User Error',
		E_USER_NOTICE       => 'PHP User Notice',
		E_USER_WARNING      => 'PHP User Warning',
		E_WARNING           => 'PHP Warning',
		1000                => 'Framework Error',
		1001                => 'Error',
	);

	/**
	 * 构造函数
	 * @access public
	 * @param string    $message   异常信息(可选)
	 * @param int       $code      异常代码(可选)
	 * @param int       $severity  异常级别
	 * @param string    $filename  异常文件(可选)
	 * @param int       $line      异常的行数(可选)
	 * @param Exception $previous  上一个异常(可选)
	 *
	 * @return exception
	 */
	public function __construct($message = '', $code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, Exception $previous = null)
	{
		parent::__construct($message, $code, $severity, $filename, $line, $previous);
	}

	/**
	 * 判断是否是致命性错误
	 * @access public
	 * @param  array $error 错误信息
	 * @return boolean
	 */
	public static function isFatalError($error)
	{
		$fatalErrors = array(
			E_ERROR,
			E_PARSE,
			E_CORE_ERROR,
			E_CORE_WARNING,
			E_COMPILE_ERROR,
			E_COMPILE_WARNING
		);
		return isset($error['type']) && in_array($error['type'], $fatalErrors);
	}

	/**
	 * 获取自定义错误信息
	 * @access public
	 * @param  int $code 错误代码
	 * @return string
	 */
	public static function getName($code)
	{
		return isset(self::$customName[$code]) ? self::$customName[$code] : self::$customName[1001];
	}
}