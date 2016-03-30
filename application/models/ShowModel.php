<?php
class ShowModel extends CI_Model{
	function __construct(){
		parent::__construct();
		#$this->db->query('set names utf8');
	}
	public function searchOneDateBrief($date){
		$episodeOfOneDay = array();
		$dateTimeStart = $date.' 00:00:00';
		$dateTimeEnd = $date.' 23:59:59';
		$sql = $this->db->query("SELECT * FROM  `episode` 
			LEFT JOIN  `shows` ON  `episode`.`s_id` =  `shows`.`s_id` 
			WHERE  `episode`.`e_time` >= '{$dateTimeStart}' AND `episode`.`e_time` <= '{$dateTimeEnd}' ") ->result_array();
		foreach ($sql as $rs) {
			$episodeOfOneDay[] = array(
				'e_id' => $rs['e_id'],
				's_id' => $rs['s_id'],
				'se_id' => $rs['se_id'],
				'e_name' => $rs['e_name'],
				'e_num' => $rs['e_num'],
				'e_status' => $rs['e_status'],
				'e_time' => $rs['e_time'],
				's_name' => $rs['s_name'],
				's_sibox_image' => $rs['s_sibox_image'],
				'area' => $rs['area'],
				'channel' => $rs['channel']
				);
		}
		unset($sql);
		if(!empty($episodeOfOneDay))
			return $episodeOfOneDay;
		else
			return null;
	}



	public function searchDates($dateStart,$dateEnd){
		$dateTimeStart = $dateStart.' 00:00:00';
		$dateTimeEnd = $dateEnd.' 23:59:59';
		//本方法是将指定日期之间所有剧集取出，之后按照日期进行分组返回的方法。日期格式与上面的方法一致
		$episodes = array();	//这个是整理好的原始数组
		$sql = $this->db->query("SELECT * FROM  `episode` 
			LEFT JOIN  `shows` ON  `episode`.`s_id` =  `shows`.`s_id` 
			WHERE  `episode`.`e_time` >= '{$dateTimeStart}' AND `episode`.`e_time` <= '{$dateTimeEnd}' 
			ORDER BY `episode`.`e_time`") ->result_array();
		foreach ($sql as $rs) {
			$episodes[] = array(
				'e_id' => $rs['e_id'],
				's_id' => $rs['s_id'],
				'se_id' => $rs['se_id'],
				'e_name' => $rs['e_name'],
				'e_num' => $rs['e_num'],
				'e_status' => $rs['e_status'],
				'e_time' => $rs['e_time'],
				'e_date' => substr($rs['e_time'], 0,10),
				's_name' => $rs['s_name'],
				's_sibox_image' => $rs['s_sibox_image'],
				'area' => $rs['area'],
				'channel' => $rs['channel']
				);
		}
		unset($sql);

		//以下将结果按照日期包装好形成数组使用
		$episodeMarkedByDate = array();
		while(count($episodes) > 0){
			$counter = 0;	//counter是计数器，用来统计某一日的所有剧集数量
			for ($counter=0; $counter < count($episodes) - 1; $counter++) { 
				if ($episodes[$counter]['e_date'] != $episodes[$counter+1]['e_date']) {
					break;
				}
			}
			$episodeMarkedByDate["{$episodes[$counter]['e_date']}"] = array_slice($episodes,0,$counter+1);
			array_splice($episodes, 0,$counter+1);
		}
		return $episodeMarkedByDate;
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

	public function getNumberOfShows()
	{
		$rs = $this->db->query("SELECT COUNT(s_id) AS num FROM `shows` 
			WHERE 1")->row_array();
		if(!is_null($rs))
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