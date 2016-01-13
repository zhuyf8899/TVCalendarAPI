<?php
class SearchNameModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}

	//根据n_id查找剧名的方法
	public function searchById($id = ''){
		$rs = $this->db->query("SELECT * FROM  `name` 
			WHERE  `name`.`n_id` = {$id} LIMIT 1") ->row_array();
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

	//根据剧名查找剧名的方法
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

	public function searchByEpiId($id = '')
	{
		$rs = $this->db->query("SELECT * FROM  `episode` 
			LEFT JOIN  `name` ON  `episode`.`n_id` =  `name`.`n_id` 
			WHERE  `episode`.`e_id` = {$id} LIMIT 1") ->row_array();
		$nameResult = array(
			'n_id' => $rs['n_id'],
			'e_id' => $rs['e_id'],
			'n_name' => $rs['n_name'],
			'e_name' => $rs['e_name'],
			'season' => $rs['e_season'],
			'episode' => $rs['e_episode'],
			'on_air' => $rs['e_onAir'],//一天就是那一天，不需要提供日期，这里有冗余
			'photo_link' => $rs['n_photoLink'],
			'e_description' => $rs['e_description']
		);
		unset($rs);
		if(!is_null($nameResult['n_id']))
			return $nameResult;
		else
			return null;
	}
	
}