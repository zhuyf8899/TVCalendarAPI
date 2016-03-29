<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UI extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->config('config',true);
		#$this->load->model('ShowModel');
		$this->load->library('session');
		$this->baseUrl = $this->config->item('base_url');
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		date_default_timezone_set('Asia/Shanghai');
		header("Content-type: text/html; charset=utf-8");			
	}

	public function index()
	{
		echo "userid:".$this->session->userdata('u_id')."\n";
		echo "username:".$this->session->userdata('u_name')."\n";
		echo "userphone:".$this->session->userdata('u_phone')."\n";
		echo "usertoken:".$this->session->userdata('u_token')."\n";
	}

	public function webLogin()
	{
		$header['title'] = '用户登录';
		$this->load->view('header',$header);
		$this->load->view('login');
		$this->load->view('footer');

	}

	public function ajaxCheckPw()
	{
		$this->load->model('UserModel');
		if (!empty($this->input->post('u_phone')) && !empty($this->input->post('u_passwd')))
		{
			$u_phone = $this->input->post('u_phone');
			$u_passwd = md5($this->input->post('u_passwd'));
			$rs = $this->UserModel->login($u_phone,$u_passwd);
			if (isset($rs['u_id'])) 
			{
				$u_data = array(
					'u_id' => $rs['u_id'],
					'u_name' => $rs['u_name'],
					'u_phone' => $rs['u_phone']
				);
				$this->session->set_userdata($u_data);
				echo "OK";
			}
			else
			{
				echo "WrongPW";
			}
		}
		else
		{
			echo "Error";
		}
	}
	
}