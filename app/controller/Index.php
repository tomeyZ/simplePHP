<?php
namespace app\controller;

use core\simplephp\Controller;

class Index extends Controller
{
	/**
	 * 测试用例一：
	 * 简单页面赋值
	 */
	public function index()
	{
		$title   = "Helloworld";
		$content = "Welcome to the simplephp framework！";
		$this->assign("title", $title);
		$this->assign("content", $content);
		$this->display();
	}

	/**
	 * 测试用例二：
	 * 从User模型类中获取数据，User模型对应user表
	 */
	public function getUserData()
	{
		$userModel = M("User");
		$users     = $userModel->getUsers();
		$this->assign("users", $users);
		$this->display("User/index.html");
	}
}