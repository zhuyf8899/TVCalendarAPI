<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SearchByDate extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->config('config',true);
		$this->load->model('SearchDateModel');
		$this->baseUrl = $this->config->item('base_url');
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		date_default_timezone_set('Asia/Shanghai');
		header("Content-type: text/html; charset=utf-8");			
	}

	public function index()
	{
		$this->load->view('error');
	}

	public function selectOneDate($date = ''){	//参数格式务必保证是yyyy-mm-dd.
		if(empty($date)){
			$date = date('20y-m-d');
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
			$data['result'] = $this->SearchDateModel->searchOneDate($date);
			$data['errorFlag'] = 0;
			if ($data['result'] == null) {
				$data['errorFlag'] = 2;
			}
		}else{
			$data['errorFlag'] = 1;
		}
		$this->load->view('selectOneDate',$data);
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
			$data['result'] = $this->SearchDateModel->searchDates($dateStart,$dateEnd);
			$data['errorFlag'] = 0;
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}else{
			$data['errorFlag'] = 2;
		}

		$this->load->view('selectServeralDates',$data);
	}
}