<?php
class SearchIdModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}

		
}
