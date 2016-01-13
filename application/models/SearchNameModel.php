<?php
class SearchNameModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}

	//根据n_id查找剧名的方法
	public function searchById($id){
		$rs = $this->db->query("SELECT * FROM  `name` 
			WHERE  `name`.`n_id` = {$id}") ->row_array();
		$nameResult = array(
			'n_id' => $rs['n_id'],
			'n_name' => $rs['n_name'],
			'photo_link' => $rs['n_photoLink'],
			);
		unset($rs);
		if(!empty($nameResult))
			return $nameResult;
		else
			return null;
	}

	//根据剧名查找剧名的方法
	public function searchByName($id){
		$rs = $this->db->query("SELECT * FROM  `name` 
			WHERE  `name`.`n_name` = {$id}") ->row_array();
		$nameResult = array(
			'n_id' => $rs['n_id'],
			'n_name' => $rs['n_name'],
			'photo_link' => $rs['n_photoLink'],
			);
		unset($rs);
		if(!empty($nameResult))
			return $nameResult;
		else
			return null;
	}
	
}