<?php
namespace core\simplephp;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\JsonFormatter;

/**
 * 框架日志类，基于Monolog，具体Git地址：https://github.com/Seldaek/monolog
 * @author tomeyZ<zl_tomey@yeah.net>
 */
class Log
{
	/**
	 * 日志信息写入
	 * @access public
	 * @param string $message   错误信息
	 * @param string $errno     错误级别
	 * @param string $formatter 存储格式
	 * @return string
	 */
	public static function write($message = '', $errno = 'ERROR', $formatter = 'line')
	{
		$logFile = LOG_PATH . 'run_log' . DS . date("Y_m_d") . '.log';
		$logDir  = dirname($logFile);
		if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
		$log = new Logger('_LOG_');
		$streamHandler = new StreamHandler($logFile, Logger::DEBUG); 
		switch (strtolower($formatter)) {
			case 'line':
				$streamHandler->setFormatter(new LineFormatter());
				break;
			case 'json':
				$streamHandler->setFormatter(new JsonFormatter());
				break;
			default:
				break;
		}
		$uid = new UidProcessor();
		$log->pushHandler($streamHandler);
		switch ($errno) {
			case E_NOTICE:
            case E_USER_NOTICE:
			case "NOTICE":
				$log->notice($message);
				break;
			case E_WARNING:
            case E_USER_WARNING:
            case E_COMPILE_WARNING:
            case E_RECOVERABLE_ERROR:
			case "WARNING":
				$log->warning($message);
				break;
			case E_PARSE:
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
			case "ERROR":
				$log->error($message);
				break;
			case E_DEPRECATED:
            case E_USER_DEPRECATED:
            case E_STRICT:
            case "DEPRECATED":
            case "INFO":
            	$log->info($message);
				break;
			default:
				$log->error($message);
				break;
		}
		return $uid->getUid();
	}
}