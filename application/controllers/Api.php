<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('config',true);
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		$this->pwFormat = '/^\w{32}$/';
		$this->CalUrl = 'http://www.pogdesign.co.uk';
		header("Content-type: text/html; charset=utf-8");
		$this->errorList = array(
			0 => null,
			1 => null,
			2 => 'Wrong Request:',
			3 => 'Empty Response:',
			4 => 'Incorrect Parameter:',
			5 => 'Wrong Result'
		);		
	}

	/*
	普遍约定：
	errno：
	1 - 无错误
	2 - 错误的请求
	3 - 空的输出
	4 - 传参错误
	5 - 返回结果错误
	*/

	public function index()
	{
		$data['ouput'] = array(
			'errno' => 2,
			'err' => $this->errorList[2].'request URL is not exist.' ,
			'rsm' => null
			); 
		$this->load->view('apiTemplate');
	}

	//获取一些默认配置信息的方法
	public function getConfig()
	{
		$data['output'] = array(
			'errno' => 1,
			'err' => '',
			'rsm' => array('CalUrl' => $this->CalUrl)
			); 
		$this->load->view('apiTemplate',$data);	
	}

	//参数格式务必保证是yyyy-mm-dd.
	//查找某一天所有集的方法
	public function selectOneDateEp()
	{
		$date = $this->input->get('date',true);
		$this->load->model('ShowModel');
		if(empty($date))
		{
			$date = date('Y-m-d');
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if(preg_match($this->dateFormat,$date))
		{	//判断是否符合日期格式
			$rsm = $this->ShowModel->searchOneDateBrief($date);
			#$data['errorFlag'] = 0;
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Date format is incorrect';
		}
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	public function selectDates()
	{
		$dateStart = $this->input->get('dateStart',true);
		$dateEnd = $this->input->get('dateEnd',true);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (empty($dateStart) || empty($dateEnd)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else if(preg_match($this->dateFormat,$dateStart) && preg_match($this->dateFormat,$dateEnd))
		{	//判断是否符合日期格式
			$rsm = $this->ShowModel->searchDates($dateStart,$dateEnd);
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Date format is incorrect';
		}
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//通过参数id查找集的详细信息
	public function searchByEpId($id = '')
	{
		$id = $this->input->get('id',true);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (empty($id)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else if(intval($id))
		{
			$rsm = $this->ShowModel->searchByEpId(intval($id));
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Id format is incorrect';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//通过id查找剧的详细信息
	public function searchByShowId($id='')
	{
		$id = $this->input->get('id',true);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (empty($id)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else if(intval($id))
		{
			$rsm['show'] = $this->ShowModel->searchByShowId(intval($id));
			$rsm['episodes'] = $this->ShowModel->searchEpsBySid($rsm['show']['s_id']);
			if (empty($rsm['show'])) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Id format is incorrect';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//注册的方法，密码传密文进来
	public function mobileRegister()
	{
		$this->load->model('UserModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($this->input->post('u_phone')) && !empty($this->input->post('u_passwd',true)))
		{
			$u_phone = $this->input->post('u_phone',true);
			$u_passwd = md5($this->input->post('u_passwd',true));
			$u_name = $this->input->post('u_name',true);
			$rs = $this->UserModel->register($u_name,$u_phone,$u_passwd);
			if (!empty($rs)) 
			{
				if ($rs == "PHONEREPEAT") 
				{
					$errno = 5;
					$err = $this->errorList[$errno].'The phone number is repeat.';
				}
				else
				{
					$rsm = array(
						'u_id' => $rs['u_id'],
						'u_name' => $rs['u_name'],
						'u_phone' => $rs['u_phone'],
						'u_token' => $rs['u_token']
					);
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
		
	}

	//使用token登陆的方法
	public function loginByToken()
	{
		$u_token =  $this->input->get('u_token',true);
		$u_id =  $this->input->get('u_id',true);
		$this->load->model('UserModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($u_token)) 
		{
			$rs = $this->UserModel->loginByToken($u_id,$u_token);
			if (isset($rs['u_id'])) 
			{
				$rsm = $rs;
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Incorrect userid or user token';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//账号密码登陆方法（密码是密文）
	public function loginByPassword()
	{
		$u_phone = $this->input->post('u_phone',true);
		$u_passWordHash =  $this->input->post('u_passwd',true);
		$this->load->model('UserModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_phone) && !empty($u_passWordHash)) 
		{
			$rs = $this->UserModel->login($u_phone,$u_passWordHash);
			if (isset($rs['u_id'])) 
			{
				$rsm = $rs;
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Incorrect user phone or user password';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//输入中英文名查找剧的方法
	public function searchByName()
	{
		$words = $this->input->get('words',true);
		$fullResult = $this->input->get('fullResult',true);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		
		if (!empty($words)) 
		{
			$words = urldecode($words);
			$words = str_replace('\'', "\\'", $words);
			#$words = str_replace('%20', ' ', $words);
			#$words = str_replace('%2F', '/', $words);

			$st = 0;
			$lg = 30;
			if ($fullResult == "fullresult") {
				$st = 0;
				$lg = 300;
			}
			$rsm = $this->ShowModel->searchByName($words,$st,$lg);
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'No search result.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}


}