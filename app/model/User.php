<?php
namespace app\model;

use core\simplephp\Model;

class User extends Model
{
	protected $table = 'user';

	public function getUsers()
	{
		return $this->select()->toArray();
	}
}