<?php
namespace core\simplephp;

use core\simplephp\ExceptionHandler;
use core\simplephp\Log;

/**
 * 框架自定义错误类
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class ErrorHandler
{
	/**
	 * 注册自定义错误处理方法
	 * @access public
	 * @return void
	 */
	public function register()
	{
		set_exception_handler(array($this, 'handleException'));
		set_error_handler(array($this, 'handleError'));
		register_shutdown_function(array($this, 'handleFatalError'));
	}

	/**
	 * 取消自定义错误回调方法
	 * @access public
	 * @return void
	 */
	public function unregister()
	{
		restore_error_handler();
		restore_exception_handler();
	}

	/**
	 * 处理截获的未捕获的异常
	 * @access public
	 * @param Exception $exception
	 * @return void
	 */
	public function handleException($exception)
	{
		$this->unregister();
		try
		{
			$this->logException($exception);
			exit(1);
		} catch(Exception $e) {
			exit(1);
		}
	}

	/**
	* 处理捕获的错误信息
	* @access public
	* @param  int    $errno   错误级别
	* @param  string $errstr  错误信息
	* @param  string $errfile 错误文件
	* @param  int    $errline 错误行数
	* @return void
	*/
	public function handleError($errno, $errstr, $errfile = null, $errline = null)
	{
		if(!(error_reporting() & $errno)) {
			return false;
		}
		$exception = new ExceptionHandler($errstr, $errno, $errno, $errfile, $errline);
		$trace     = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		array_shift($trace);
		foreach($trace as $frame) {
			if($frame['function'] == '__toString') {
				$this->handleException($exception);
				exit(1);
			}
		}
		throw $exception;
	}

	/**
	 * 处理捕获致命性错误
	 * @access public
	 * @return void
	 */
	public function handleFatalError()
	{
		$error = error_get_last();
		if(ExceptionHandler::isFatalError($error)) {
			$exception = new ExceptionHandler($error['message'], $error['type'], $error['type'], $error['file'], $error['line']);
			$this->logException($exception);
			exit(1);
		}
	}

	/**
	 * 记录并打印异常信息
	 * @access private
	 * @param  ExceptionHandler $e 错误异常
	 * @return void
	 */
	private function logException($e)
	{
		$error = []; 
		if (1000 == $e->getCode()) {
			$trace         = $e->getTrace();
			$error['file'] = $trace[0]['file'];
			$error['line'] = $trace[0]['line'];
		} else {
			$error['file'] = $e->getFile();
			$error['line'] = $e->getLine();
		}

		$errorName = ExceptionHandler::getName($e->getCode());
		$message   = $errorName.' ('.$e->getCode().'): '.$e->getMessage().' in '.$error['file'].' on line '.$error['line'].PHP_EOL.((IS_CLI) ? $e->getTraceAsString() : '');
    	Log::write($message, $e->getCode());
    	if (Config::get('app_debug')) {
    		echo($message);
    	}
    	unset($message);
    	unset($error);
    	exit(1);
	}
}