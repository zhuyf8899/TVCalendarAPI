<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SearchByDate extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->config('config',true);
		$this->load->model('SearchNameModel');
		$this->baseUrl = $this->config->item('base_url');
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		date_default_timezone_set('Asia/Shanghai');
		header("Content-type: text/html; charset=utf-8");			
	}

	//通过参数id查找剧情详细信息
	public function searchById($id){
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
		}else if(is_int($id)){
			$data['result']$this->SearchNameModel->searchById($id);
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}else{
			$data['errorFlag'] = 2;
		}

	}

	//通过参数name查找剧名的详细信息,效率差不安全，不推荐使用
	public function searchByName($name){
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
			$data['result']$this->SearchNameModel->searchByName($name);
			if (empty($data['result'])) {
				$data['errorFlag'] = 3;
			}
		}
	}
}