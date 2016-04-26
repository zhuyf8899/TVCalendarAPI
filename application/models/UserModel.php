<?php
class UserModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}

	//注册方法，密码$u_passwd为MD5散列值
	public function register($u_name,$u_phone,$u_passwd)
	{
		$checker = $this->db->query("SELECT u_id FROM user WHERE u_phone = '{$u_phone}' LIMIT 1")->row_array();
		if (!empty($checker)) {
			return "PHONEREPEAT";
		}
		else
		{
			$u_token = md5($u_name.$u_phone.$u_passwd.rand(100,999));
			$pwh = password_hash($u_passwd, PASSWORD_DEFAULT);
			$this->db->query("INSERT into user (u_name,u_phone,u_passwd,u_token,u_status) 
				values('{$u_name}','{$u_phone}','{$pwh}','{$u_token}',2)");
			if ($this->db->affected_rows())
			{
				$rs = $this->db->query("SELECT u_id,u_name,u_phone,u_token,u_status FROM user WHERE u_phone = '{$u_phone}' LIMIT 1")->row_array();
				return $rs;
			}
		}
		return null;
	}

	//出于兼容考虑保留此方法但此方法已弃用
	public function login_old($u_phone,$u_passwd)
	{
		$checker = $this->db->query("SELECT u_id,u_name,u_phone,u_status,u_token FROM user WHERE u_phone = '{$u_phone}' AND u_passwd = '{$u_passwd}' LIMIT 1")->row_array();
		if (isset($checker['u_id'])) 
		{
			return $checker;
		}
		else
		{
			return null;
		}
	}

	//新的验证函数，u_passwd是一个已经被MD5后的哈希值
	public function login($u_phone,$u_passwd)
	{
		$checker = $this->db->query("SELECT u_id,u_name,u_phone,u_status,u_token,u_passwd FROM user WHERE u_phone = '{$u_phone}' AND u_status = 2 LIMIT 1")->row_array();
		if (!empty($checker)) 
		{
			if (password_verify( $u_passwd, $checker['u_passwd'] )) 
			{
				unset($checker['u_passwd']);
				return $checker;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public function getUserData($uid)
	{
		$rs = $this->db->query("SELECT u_id,u_name,u_phone,u_status FROM user WHERE u_id = {$uid} LIMIT 1")->row_array();
		if (isset($rs)) 
		{
			return $rs;
		}
		else
		{
			return null;
		}
	}

	public function getBudget()
	{
		$rs = $this->db->query("SELECT * FROM budget WHERE 1 ORDER BY b_time DESC")->result_array();
		if (isset($rs)) 
		{
			return $rs;
		}
		else
		{
			return null;
		}
	}

	public function updateNameOnly_old($u_id,$u_passwd,$u_name)
	{
		$this->db->query("UPDATE `user` SET `u_name` = '{$u_name}' 
			WHERE `u_id` = {$u_id} AND `u_passwd` = MD5('{$u_passwd}')");
		if ($this->db->affected_rows())
		{
			return "OK";
		}
		else
		{
			return "WrongPw";
		}
	}

	//在用户密码正确的情况下仅更新用户名
	//$u_passwd为MD5后的哈希值
	public function updateNameOnly($u_id,$u_passwd,$u_name)
	{
		$checker = $this->db->query("SELECT u_passwd FROM user WHERE u_id = '{$u_id}' AND u_status = 2 LIMIT 1")->row_array();
		if (!empty($checker)) 
		{
			if (password_verify( $u_passwd, $checker['u_passwd'] )) 
			{
				$this->db->query("UPDATE `user` SET `u_name` = '{$u_name}' 
					WHERE `u_id` = {$u_id}");
				if ($this->db->affected_rows())
				{
					return "OK";
				}
				else
				{
					return "UpdateError";
				}
			}
			else
			{
				return "WrongPw";
			}
		}
		else
		{
			return "NoResult";
		}
	}

	public function updateUserInfo_old($u_id,$u_passwd,$pwdN,$u_name)
	{
		$u_token = md5($u_id.$u_name.$pwdN);
		$this->db->query("UPDATE `user` SET  `u_name` =  '{$u_name}',`u_passwd` = MD5('$pwdN'), `u_token` = '{$u_token}'  
			WHERE  `u_id` = {$u_id} AND `u_passwd` = MD5('{$u_passwd}')");
		if ($this->db->affected_rows())
		{
			return "OK";
		}
		else
		{
			return "WrongPw";
		}
	}

	//在密码正确的情况下更新用户昵称密码的方法
	//密码$u_passwd,$pwdN应当为MD5值
	public function updateUserInfo($u_id,$u_passwd,$pwdN,$u_name)
	{
		$checker = $this->db->query("SELECT u_passwd FROM user WHERE u_id = '{$u_id}' AND u_status = 2 LIMIT 1")->row_array();
		if (!empty($checker)) 
		{
			if (password_verify( $u_passwd, $checker['u_passwd'] )) 
			{
				$u_token = md5($u_id.$u_name.$pwdN.rand(100,999));
				$pwh = password_hash($pwdN, PASSWORD_DEFAULT);
				$this->db->query("UPDATE `user` SET  `u_name` =  '{$u_name}',`u_passwd` = '$pwh', `u_token` = '{$u_token}' 
					WHERE `u_id` = {$u_id}");
				if ($this->db->affected_rows())
				{
					return "OK";
				}
				else
				{
					return "UpdateError";
				}
			}
			else
			{
				return "WrongPw";
			}
		}
		else
		{
			return "NoResult";
		}
	}

	public function loginByToken($uid,$token)
	{
		$checker = $this->db->query("SELECT u_id,u_name,u_token,u_status,u_phone FROM user WHERE u_id = '{$uid}' AND u_token = '{$token}' LIMIT 1")->row_array();
		if (isset($checker['u_id'])) 
		{
			return $checker;
		}
		else
		{
			return "WrongPw";
		}
	}

}
