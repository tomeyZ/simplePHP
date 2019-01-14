# SimplePHP

## 简介
SimplePHP是一款免费开源、简单易懂的轻量级PHP开发框架，框架可用于任何PHP项目的开发，另外的目的是为了一些有独自编写PHP框架想法的同学提供一些代码上的参考，后期我将会连载开发自己的PHP MVC框架系列教程。

开发环境及依赖包说明：
* PHP 5.6.0+
* topthink/think-orm: ^1.2
* twig/twig: ^2.0
* monolog/monolog: ^1.24

## 目录说明

```
simplePHP           框架根目录
├─app               应用目录
│  ├─controller     控制器目录
│  ├─model          模型目录
│  ├─view           视图目录
├─common            公共方法目录
├─config            配置文件目录
├─core              框架核心目录
│  ├─common         核心公共方法目录
│  ├─lib            扩展类目录
│  ├─simplephp      核心模块目录
├─logs              日志文件目录
├─public            公共入口文件目录
├─vendor            Composer命令生成的，用来存放引入的第三方依赖扩展
```

## 使用说明

### 一、安装

**方式一** Composer方式安装（推荐）
```
composer create-project tomeyz/simplephp
```

**方式二** GitHub方式安装
```
git clone https://github.com/tomeyZ/simplePHP.git
```
> Tip：通过命令将会把simplePHP框架源代码下载到本地。

### 二、Apache或Nginx配置单一入口请求方式
> 单一入口就是指应用程序的所有HTTP请求都是通过index.php接收并转发到功能代码中。

**Apache服务器配置**
httpd.conf文件中，把LoadModule rewrite_module modules/mod_rewrite.so前面的“#”去掉。
```
<Directory />
  Options Indexes FollowSymLinks MultiViews
	AllowOverride None
	<IfModule mod_rewrite.c>
    # 开启Rewrite功能
		RewriteEngine on
		RewriteBase /
    
		# 隐藏index.php入口文件
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule  ^/?(.*)$ /index.php?%{QUERY_STRING} [L,NC]
	</IfModule>
	DirectoryIndex index.php index.html index.htm
</Directory>
```

**Nginx服务器配置**
```
location / {
	if (!-e $request_filename){
    	rewrite ^(.*)$ /index.php?s=$1 last; break;
    }
}
```
### 三、访问测试
确定服务启动后，浏览器输入 http://localhost/ 即可，内容如下：

Helloworld
Welcome to the simplephp framework！


SimplePHP遵循Apache2开源协议发布。Apache Licence是著名的非盈利开源组织Apache采用的协议。该协议和BSD类似，鼓励代码共享和尊重原作者的著作权，同样允许代码修改，再作为开源或商业软件发布。
