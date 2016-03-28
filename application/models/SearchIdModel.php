<?php
class SearchIdModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}

	//根据s_id查找剧名的方法
	public function searchByEpId($id = ''){
		$rs = $this->db->query("SELECT * FROM  `episode` 
			WHERE  `episode`.`e_id` = {$id} LIMIT 1") ->row_array();
		// $nameResult = array(
		// 	'n_id' => $rs['n_id'],
		// 	'n_name' => $rs['n_name'],
		// 	'photo_link' => $rs['n_photoLink'],
		// 	);
		// unset($rs);
		if(!is_null($rs['e_id']))
			return $rs;
		else
			return null;
	}

	//根据e_id查找剧信息的方法
	public function searchByShowId($id='')
	{
		$rs = $this->db->query("SELECT * FROM `shows` 
			WHERE `s_id` = {$id} LIMIT 1")->row_array();
		if(!is_null($rs['s_id']))
			return $rs;
		else
			return null;
	}

	//根据剧的id查找所有属于其的集的方法,返回的是简略信息:
	//返回e_id,se_id,e_num,e_name,e_status,e_time
	public function searchEpsBySid($id='')
	{
		$rs = $this->db->query("SELECT e_id,se_id,e_num,e_name,e_status,e_time 
			from `episode` WHERE s_id = {$id} ORDER BY se_id DESC , e_num DESC ")->result_array();
		if(!is_null($rs[0]))
			return $rs;
		else
			return null;
	}

	//根据剧名查找剧名的方法
	//暂不能使用
	public function searchByName($id = ''){
		$rs = $this->db->query("SELECT * FROM  `name` 
			WHERE  `name`.`n_name` = \"{$id}\"") ->row_array();
		$nameResult = array(
			'n_id' => $rs['n_id'],
			'n_name' => $rs['n_name'],
			'photo_link' => $rs['n_photoLink'],
			);
		unset($rs);
		if(!is_null($nameResult['n_id']))
			return $nameResult;
		else
			return null;
	}	
}