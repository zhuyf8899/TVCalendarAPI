<?php
class UserModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}

	public function register($u_name,$u_phone,$u_passwd)
	{
		$checker = $this->db->query("SELECT u_id FROM user WHERE u_phone = '{$u_phone}' LIMIT 1")->row_array();
		if (!empty($checker)) {
			return "PHONEREPEAT";
		}
		else
		{
			$u_token = md5($u_name.$u_phone.$u_passwd);
			$this->db->query("INSERT into user (u_name,u_phone,u_passwd,u_token,u_status) 
				values('{$u_name}','{$u_phone}','{$u_passwd}','{$u_token}',1)");
			if ($this->db->affected_rows())
			{
				$rs = $this->db->query("SELECT u_id,u_name,u_phone,u_token FROM user WHERE u_phone = '{$u_phone}' LIMIT 1")->row_array();
				return $rs;
			}
		}
		return null;
	}

	public function login($u_phone,$u_passwd)
	{
		$checker = $this->db->query("SELECT * FROM user WHERE u_phone = '{$u_phone}' AND u_passwd = '{$u_passwd}' LIMIT 1")->row_array();
		if (isset($checker['u_id'])) 
		{
			return $checker;
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

	public function updateNameOnly($u_id,$u_passwd,$u_name)
	{
		$rs = $this->db->query("UPDATE `user` SET  `u_name` =  '{$u_name}' 
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

	public function updateUserInfo($u_id,$u_passwd,$pwdN,$u_name)
	{
		$u_token = md5($u_id.$u_name.$u_passwd);
		$rs = $this->db->query("UPDATE `user` SET  `u_name` =  '{$u_name}',`u_passwd` = MD5('$u_passwd'), `u_token` = '{$u_token}'  
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
}
