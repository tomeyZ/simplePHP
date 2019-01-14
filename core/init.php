<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH',   dirname(realpath(__DIR__)) . DS);
define('APP_PATH',    ROOT_PATH . 'app' . DS);
define('CORE_PATH',   ROOT_PATH . 'core' . DS);
define('LIB_PATH',    CORE_PATH . 'lib' . DS);
define('COMMON_PATH', ROOT_PATH . 'common' . DS);
define('CONFIG_PATH', ROOT_PATH . 'config' . DS);
define('LOG_PATH',    ROOT_PATH . 'logs' . DS);
define('PUBLIC_PATH', ROOT_PATH . 'public' . DS);
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);

// 加载自动加载类
require CORE_PATH . 'simplephp'. DS . 'Loader.php';

// 注册自动加载
core\simplephp\Loader::register();

// 框架运行
core\simplephp\App::run();