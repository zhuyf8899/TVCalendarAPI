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

	//主页
	public function index()
	{
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
		// echo "userid:".$this->session->userdata('u_id')."\n";
		// echo "username:".$this->session->userdata('u_name')."\n";
		// echo "userphone:".$this->session->userdata('u_phone')."\n";
		// echo "usertoken:".$this->session->userdata('u_token')."\n";
	}

	//登陆页面
	public function webLogin()
	{
		$header['title'] = '用户登录';
		$this->load->view('headerLogin',$header);
		$this->load->view('login');
		$this->load->view('footer');

	}

	//ajax验证密码并写入cookies的方法
	public function ajaxCheckPw()
	{
		$this->load->model('UserModel');
		if (!empty($this->input->post('u_phone')) && !empty($this->input->post('u_passwd')))
		#if($_GET['u_phone'] && $_GET['u_passwd'])
		{
			$u_phone = $this->input->post('u_phone');
			$u_passwd = md5($this->input->post('u_passwd'));
			#$u_phone = $_GET['u_phone'];
			#$u_passwd = md5($_GET['u_passwd']);
			$rs = $this->UserModel->login($u_phone,$u_passwd);
			if (isset($rs['u_id'])) 
			{
				$u_data = array(
					'u_id' => $rs['u_id'],
					'u_name' => $rs['u_name'],
					'u_phone' => $rs['u_phone'],
					'u_token' => $rs['u_token']
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

	//注册界面
	public function webreg()
	{
		$header['title'] = '注册';
		$this->load->view('headerLogin',$header);
		$this->load->view('webreg');
		$this->load->view('footer');
	}

	//ajax注册验证
	public function ajaxReg()
	{
		$this->load->model('UserModel');
		if (!empty($this->input->post('u_phone')) && !empty($this->input->post('u_passwd')))
		{
			$u_phone = $this->input->post('u_phone');
			$u_passwd = md5($this->input->post('u_passwd'));
			$u_name = $this->input->post('u_name');
			$rs = $this->UserModel->register($u_name,$u_phone,$u_passwd);
			if (!empty($rs)) 
			{
				if ($rs == "PHONEREPEAT") 
				{
					echo "WrongPh";
				}
				else
				{
					$u_data = array(
						'u_id' => $rs['u_id'],
						'u_name' => $rs['u_name'],
						'u_phone' => $rs['u_phone'],
						'u_token' => $rs['u_token']
					);
					$this->session->set_userdata($u_data);
					echo "OK";
				}
			}
			else
			{
				echo "Error";
			}
		}
	}
	
}