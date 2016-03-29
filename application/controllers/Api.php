<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->config('config',true);
		$this->load->model('ShowModel');
		$this->baseUrl = $this->config->item('base_url');
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		date_default_timezone_set('Asia/Shanghai');
		header("Content-type: text/html; charset=utf-8");			
	}

	public function index()
	{
		$this->load->view('error');
	}

	public function selectOneDateEp($date = ''){	//参数格式务必保证是yyyy-mm-dd.
		if(empty($date)){
			$date = date('Y-m-d');
		}
		$data['result'] =  array();
		$data['errorFlag'] = -1;
		/*
		错误代码：errorFlag：
		-1:初始值
		0.无错误
		1.日期格式错误
		2.数据库查询结果为空
		*/
		if(preg_match($this->dateFormat,$date)){	//判断是否符合日期格式
			$data['result'] = $this->ShowModel->searchOneDateBrief($date);
			$data['errorFlag'] = 0;
			if ($data['result'] == null) {
				$data['errorFlag'] = 2;
			}
		}else{
			$data['errorFlag'] = 1;
		}
		$this->load->view('selectOneDateEp',$data);
	}

	public function selectDates($dateStart = '',$dateEnd = ''){
		$data['result'] = array();
		$data['errorFlag'] = -1;
		/*
		错误代码：errorFlag：
		-1:初始值
		0.无错误
		1.日期参数缺少
		2.日期格式错误
		3.数据库查询结果为空
		*/
		if (empty($dateStart) || empty($dateEnd)) {
			$data['errorFlag'] = 1;
		}
		if(preg_match($this->dateFormat,$dateStart) && preg_match($this->dateFormat,$dateEnd)){	//判断是否符合日期格式
			$data['result'] = $this->ShowModel->searchDates($dateStart,$dateEnd);
			$data['errorFlag'] = 0;
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}else{
			$data['errorFlag'] = 2;
		}

		$this->load->view('selectServeralDates',$data);
	}

	//通过参数id查找集的详细信息
	public function searchByEpId($id = ''){
		$data['result'] = array();
		$data['errorFlag'] = -1;
		/*
		错误代码errorFlag：
		-1.默认值
		0.无错误
		1.缺少id参数 
		2.参数格式错误
		3.数据库返回空
		*/
		if (empty($id)) {
			$data['errorFlag'] = 1;
		}else if(intval($id)){
			$data['result'] = $this->ShowModel->searchByEpId(intval($id));
			$data['errorFlag'] = 0;
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}else{
			$data['errorFlag'] = 2;
		}

		$this->load->view('idTemplate',$data);
	}

	//通过id查找剧的详细信息
	public function searchByShowId($id='')
	{
		$data['result'] = array();
		$data['errorFlag'] = -1;
		/*
		错误代码errorFlag：
		-1.默认值
		0.无错误
		1.缺少id参数 
		2.参数格式错误
		3.数据库返回空
		*/
		if (empty($id)) {
			$data['errorFlag'] = 1;
		}else if(intval($id)){
			$data['result'] = $this->ShowModel->searchByShowId(intval($id));
			$data['eps'] = $this->ShowModel->searchEpsBySid(intval($id));
			$data['errorFlag'] = 0;
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}else{
			$data['errorFlag'] = 2;
		}

		$this->load->view('viewShowSummary',$data);
	}

	//通过参数name查找剧名的详细信息,效率差不安全，不推荐使用
	//输入格式必须是数据源网站提供的带-的英文名，查找不方便，下一个版本引入中文名 -marked by yifan.
	//暂不能使用
	public function searchByName($name = ''){
		$data['result'] = array();
		$data['errorFlag'] = -1;
		/*
		错误代码errorFlag：
		-1.默认值
		0.无错误
		1.缺少name参数
		3.数据库返回空
		*/
		if (empty($name)) {
			$data['errorFlag'] = 1;
		}else{
			$data['result'] = $this->ShowModel->searchByName($name);
			$data['errorFlag'] = 0;
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}
		$this->load->view('idTemplate',$data);
	}
}