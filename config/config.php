<?php

// 配置文件
return [
	// 是否启用调试模式
	'app_debug'          => true,
	// 默认时区
    'default_timezone'   => 'PRC',
    // 默认字符集
    'default_charset'    => 'UTF-8',
    // 默认控制器
    'default_controller' => 'Index',
    // 默认方法名
    'default_action'     => 'index',
    // 是否启用PATHINFO访问模式，默认启用
    // 启用：http://域名/项目名/入口文件/模块名/方法名/参数1/值1/参数2/值2...
    // 关闭：http://域名/项目名/入口文件?c=控制器名&a=方法名&参数1=值1&参数2=值2...
    'pathinfo_model'     => true, 
    
    // 模板配置
    'template'           => [
        // 是否启用模板缓存
        'tpl_cache'       => false,
        // 是否启用模板编译自动更新
        'tpl_auto_update' => true,
    ]
];