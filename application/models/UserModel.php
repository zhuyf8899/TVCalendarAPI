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
}
