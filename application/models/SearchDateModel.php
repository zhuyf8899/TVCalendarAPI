<?php
class SearchDateModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->db->query('set names utf8');
	}
	public function searchOneDate($date){
		$episodeOfOneDay = array();
		$sql = $this->db->query("SELECT * FROM  `episode` 
			LEFT JOIN  `name` ON  `episode`.`n_id` =  `name`.`n_id` 
			WHERE  `episode`.`e_onAir` = \"{$date}\"") ->result_array();
		foreach ($sql as $rs) {
			$episodeOfOneDay[] = array(
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
		}
		unset($sql);
		if(!empty($episodeOfOneDay))
			return $episodeOfOneDay;
		else
			return null;
	}

	public function searchDates($dateStart,$dateEnd){
		//本方法是将指定日期之间所有剧集取出，之后按照日期进行分组返回的方法。日期格式与上面的方法一致
		$episodes = array();	//这个是整理好的原始数组
		$sql = $this->db->query("SELECT * FROM  `episode` 
			LEFT JOIN  `name` ON  `episode`.`n_id` =  `name`.`n_id` 
			WHERE  `episode`.`e_onAir` >=  \"{$dateStart}\" and `episode`.`e_onAir` <=  \"{$dateEnd}\"
			ORDER BY `episode`.`e_onAir`") ->result_array();
		foreach ($sql as $rs) {
			$episodes[] = array(
				'n_id' => $rs['n_id'],
				'e_id' => $rs['e_id'],
				'n_name' => $rs['n_name'],
				'e_name' => $rs['e_name'],
				'season' => $rs['e_season'],
				'episode' => $rs['e_episode'],
				'on_air' => $rs['e_onAir'],
				'photo_link' => $rs['n_photoLink'],
				'e_description' => $rs['e_description']
				);
		}
		unset($sql);

		//以下将结果按照日期包装好形成数组使用
		$episodeMarkedByDate = array();
		while(count($episodes) > 0){
			$counter = 0;	//counter是计数器，用来统计某一日的所有剧集数量
			for ($counter=0; $counter < count($episodes) - 1; $counter++) { 
				if ($episodes[$counter]['on_air'] != $episodes[$counter+1]['on_air']) {
					break;
				}
			}
			$episodeMarkedByDate["{$episodes[$counter]['on_air']}"] = array_slice($episodes,0,$counter+1);
			array_splice($episodes, 0,$counter+1);
		}
		return $episodeMarkedByDate;
	}
}