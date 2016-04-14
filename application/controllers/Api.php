<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('config',true);
		#$this->load->model('ShowModel');
		#$this->load->model('UserModel');
		$this->baseUrl = $this->config->item('base_url');
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		$this->pwFormat = '/^\w{32}$/';
		$this->CalUrl = 'http://www.pogdesign.co.uk';
		date_default_timezone_set('Asia/Shanghai');
		header("Content-type: text/html; charset=utf-8");
		$this->errorList = array(
			0 => null,
			1 => null,
			2 => 'Wrong Request:',
			3 => 'Empty Response:',
			4 => 'Incorrect Parameter:'
		);		
	}

	/*
	普遍约定：
	errno：
	1 - 无错误
	2 - 错误的请求
	3 - 空的输出
	4 - 传参错误
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

	//通过参数name查找剧名的详细信息,效率差不安全，不推荐使用
	//输入格式必须是数据源网站提供的带-的英文名，查找不方便，下一个版本引入中文名 -marked by yifan.
	//暂不能使用
	public function searchByName($name = '')
	{
		$this->load->model('ShowModel');
		$data['result'] = array();
		$data['errorFlag'] = -1;
		/*
		错误代码errorFlag：
		-1.默认值
		0.无错误
		1.缺少name参数
		3.数据库返回空
		*/
		if (empty($name)) 
		{
			$data['errorFlag'] = 1;
		}
		else
		{
			$data['result'] = $this->ShowModel->searchByName($name);
			$data['errorFlag'] = 0;
			if (empty($data['result'])) 
			{
				$data['errorFlag'] = 3;
			}
		}
		$this->load->view('idTemplate',$data);
	}

	//暂不能使用
	public function mobileRegister()
	{
		$this->load->model('UserModel');
		$data['errorFlag'] = -1;
		/*
		错误代码errorFlag：
		-1.默认值
		0.无错误
		1.穿入参数错误
		2.手机号重复
		3.数据库错误
		*/
		if ($this->input->post('u_name') && $this->input->post('u_phone') && preg_match($this->pwFormat,$this->input->post('u_passwd'))) 
		{
			$data['result'] = $this->UserModel->register($this->input->post('u_name') , $this->input->post('u_phone'),$this->input->post('u_passwd'));
			$data['errorFlag'] = 0;
			if (empty($data['result'])) 
			{
				$data['errorFlag'] = 3;
			}
			if ($data['result'] == "PHONEREPEAT") {
				$data['errorFlag'] = 2;
			}
		}
		else
		{
			$data['errorFlag'] = 1;
		}
		$this->load->view('mobileReg',$data);
	}
}