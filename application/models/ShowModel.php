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
				's_name_cn' => $rs['s_name_cn'],
				's_sibox_image' => $rs['s_sibox_image'],
				's_vertical_image' => str_replace('sibox', 'vertical', $rs['s_sibox_image']),
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
				's_name_cn' => $rs['s_name_cn'],
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

	//根据s_id查找剧信息的方法
	public function searchByShowId($id='')
	{
		$rs = $this->db->query("SELECT * FROM `shows` 
			WHERE `s_id` = {$id} LIMIT 1")->row_array();
		if(!is_null($rs))
		{
			if(!empty($rs['r_id']) && $rs['r_id'] != 0)
			{
				$db_resource = $this->load->database('download',TRUE);
				$description = $db_resource->query("SELECT `resource_content`
					FROM `zmz_resource` 
					WHERE `zmz_resource`.`zmz_resourceid` = '{$rs['r_id']}' 
					LIMIT 1")->row_array();
				$rs['s_description'] = $description['resource_content'];
 			}
			$rs['s_sibig_image'] = str_replace('sibox', 'sibig', $rs['s_sibox_image']);
			return $rs;
		}
		else
			return null;
	}

	//获取下载链接的方法
	public function getDownloadLink($r_id,$se_id,$e_num)
	{
		$db_download = $this->load->database('download',TRUE);
		$rs = $db_download->query("SELECT `item_file_name`,`item_size`,`item_format`,`item_ed2k_link`,`item_magnet_link`
			FROM `zmz_resource_item` 
			LEFT JOIN zmz_resource ON `zmz_resource_item`.`zmz_resourceid` = `zmz_resource`.`zmz_resourceid` 
			WHERE `zmz_resource`.`zmz_resourceid` = {$r_id}
			AND `zmz_resource_item`.`item_season` = {$se_id} 
			AND item_episode = {$e_num}")->result_array();
		if(!is_null($rs))
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

	//获取有多少部剧的方法
	public function getNumberOfShows()
	{
		$rs = $this->db->query("SELECT COUNT(s_id) AS num FROM `shows` 
			WHERE 1")->row_array();
		if(!is_null($rs))
			return $rs;
		else
			return null;
	}

	public function getShows($start = 0,$limit = 20)
	{
		$rs = $this->db->query("SELECT s_id,s_name,s_name_cn,status,area,channel,s_sibox_image FROM `shows` 
			WHERE 1 limit {$start},{$limit}")->result_array();
		if(!is_null($rs))
		{
			foreach ($rs as &$one) 
			{
				$one['s_vertical_image'] = str_replace('sibox', 'vertical', $one['s_sibox_image']);
			}
			return $rs;
		}
		else
		{
			return null;
		}
	}

	//获取一部剧是否被用户订阅的方法
	public function checkSubscribe($u_id,$s_id)
	{
		$rs = $this->db->query("SELECT * FROM subscribe 
			WHERE u_id = {$u_id} AND s_id = {$s_id}")->row_array();
		if(!is_null($rs))
			return true;
		else
			return false;
	}

	//向subscribe插入记录的方法
	public function insertSubscribe($u_id,$s_id,$date)
	{
		if($this->checkSubscribe($u_id,$s_id))
		{
			return "Repeat";
		}
		$this->db->query("INSERT INTO subscribe (u_id, s_id,sub_time) 
			VALUES ({$u_id}, {$s_id},'{$date}')");
		if ($this->db->affected_rows()) 
		{
			$rs = $this->db->query("SELECT s_name,s_name_cn FROM shows 
				WHERE s_id = {$s_id} LIMIT 1")->row_array();
			return 'OK:'.$rs['s_name'].'-'.$rs['s_name_cn'];
		}
		else
		{
			return "Repeat";
		}
		return null;
	}

	//从subscribe删除记录的方法
	public function deleteSubscribe($u_id,$s_id)
	{
		$this->db->query("DELETE FROM subscribe WHERE 
			u_id = {$u_id} AND s_id = {$s_id} LIMIT 1");
		if ($this->db->affected_rows()) 
		{
			$rs = $this->db->query("SELECT s_name,s_name_cn FROM shows 
				WHERE s_id = {$s_id} LIMIT 1")->row_array();
			return 'OK:'.$rs['s_name'].'-'.$rs['s_name_cn'];
		}
		else
		{
			return "None";
		}
		return null;
	}

	//检查是否已同步的方法
	public function checkSyn($uid,$eid)
	{
		$rs = $this->db->query("SELECT * FROM synchron 
			WHERE u_id = {$uid} AND e_id = {$eid}")->row_array();
		if(!is_null($rs))
			return true;
		else
			return false;
	}

	//新增一个同步记录
	public function insertSynchron($u_id,$e_id,$date)
	{
		if ($this->checkSyn($u_id,$e_id)) 
		{
			return "Repeat";
		}
		$this->db->query("INSERT INTO synchron (u_id, e_id,syn_time) 
			VALUES ({$u_id}, {$e_id},'{$date}')");
		if ($this->db->affected_rows()) 
		{
			$rs = $this->db->query("SELECT se_id,e_num FROM episode 
				WHERE e_id = {$e_id} LIMIT 1")->row_array();
			#return "OK:S".$rs['se_id'].",E".$rs['e_num'];
			return "OK:S".$rs['se_id'].",E".$rs['e_num'];
		}
		else
		{
			return "Repeat";
		}
		return null;
	}

	//从synchrone删除记录的方法
	public function deleteSynchron($u_id,$e_id)
	{
		$this->db->query("DELETE FROM synchron WHERE 
			u_id = {$u_id} AND e_id = {$e_id} LIMIT 1");
		if ($this->db->affected_rows()) 
		{
			$rs = $this->db->query("SELECT se_id,e_num FROM episode 
				WHERE e_id = {$e_id} LIMIT 1")->row_array();
			return "OK:S".$rs['se_id'].",E".$rs['e_num'];
		}
		else
		{
			return "None";
		}
		return null;
	}

	//查找某天之前beforeDay开始after天之前所有关注的集的更新信息，其中一个是时区
	//时区格式必须为3位，形式如+08,-11这样
	public function searchRecentByUid($u_id,$beforeDay,$afterDay,$date_input,$timezone='+00')
	{
		$date = $date_input;
		if (substr($timezone, 0,1) == '+') 
		{
			$hour = intval(substr($timezone,1));
			$date = date('Y-m-d 08:00:00',strtotime("$date + $hour hours"));
		}
		else
		{
			$hour = intval(substr($timezone,1));
			$date = date('Y-m-d 08:00:00',strtotime("$date - $hour hours"));
		}
		$future = $date;
		$date = date('Y-m-d 08:00:00',strtotime("$date - $beforeDay day"));
		$future = date('Y-m-d 08:00:00',strtotime("$future + $afterDay day"));

		$rs = $this->db->query("SELECT `shows`.`s_id`,e_id,se_id,s_name,s_name_cn,s_sibox_image,e_num,e_time,e_status,r_id
			FROM episode 
			LEFT JOIN shows ON `episode`.`s_id` = `shows`.`s_id` 
			LEFT JOIN subscribe ON `shows`.`s_id` = `subscribe`.`s_id` 
			WHERE `subscribe`.`u_id` = {$u_id} AND `episode`.`e_time` >= '{$date}' AND `episode`.`e_time` <='{$future}'
			ORDER BY `episode`.`e_time` DESC;")->result_array();
		if(!is_null($rs))
		{
			foreach ($rs as &$one) 
			{
				$one['s_vertical_image'] = str_replace('sibox', 'vertical', $one['s_sibox_image']);
			}
			return $rs;
		}
		else
			return null;
	}

	public function searchByUidOrderByDate($u_id)
	{
		$rs = $this->db->query("SELECT `shows`.`s_id`,s_name,s_name_cn,s_sibox_image,status,channel,update_time,area
			FROM shows 
			LEFT JOIN subscribe ON `shows`.`s_id` = `subscribe`.`s_id` 
			WHERE `subscribe`.`u_id` = {$u_id} 
			ORDER BY  `subscribe`.`sub_time` DESC;")->result_array();
		if(!is_null($rs))
			return $rs;
		else
			return null;
	}

	//根据剧名查找剧名的方法
	public function searchByName($name,$start,$end){
		$rs = $this->db->query("SELECT s_id,s_name,s_name_cn,s_sibox_image,area,status FROM  `shows` 
			WHERE  `shows`.`s_name` LIKE '%{$name}%'
			OR `shows`.`s_name_cn` LIKE '%{$name}%'
			LIMIT {$start},{$end}") ->result_array();
		if(!is_null($rs))
		{
			foreach ($rs as &$one) 
			{
				$one['s_vertical_image'] = str_replace('sibox', 'vertical', $one['s_sibox_image']);
			}
			return $rs;
		}
		else
			return null;
	}

	public function getLikeRecommend($uid,$limit = 5)
	{
		$rs = array();
		for ($i=0; $i < $limit; $i++) 
		{ 
			$rs[$i] = $this->db->query("SELECT `t_name`,`shows`.`s_id`,`s_name`,`s_name_cn`,`area`,`status`,`s_sibox_image`,`t_name`,`t_name_cn`
				FROM `user_to_tag`
				left join `show_to_tag` on `user_to_tag`.`t_id` =  `show_to_tag`.`t_id` 
				left join `tag` on `user_to_tag`.`t_id` = `tag`.`t_id`
				left join `shows` on `show_to_tag`.`s_id` = `shows`.`s_id`
				WHERE `user_to_tag`.`u_id` = {$uid}
				AND `shows`.`s_id` >= (SELECT floor(RAND() * (SELECT MAX(`s_id`) FROM `shows`))) 
				LIMIT 1")->row_array();
		}

		$s_ids = $this->db->query("SELECT s_id
			FROM `subscribe`
			WHERE u_id = {$uid}
			ORDER BY RAND( ) 
			LIMIT {$limit}")->result_array();

		$counterJ = count($rs);
		for ($j=$counterJ; $j < $counterJ+count($s_ids); $j++) 
		{ 
			$rs[$j] = $this->db->query("SELECT `t_name`,`shows`.`s_id`,`s_name`,`s_name_cn`,`area`,`status`,`s_sibox_image`,`t_name`,`t_name_cn`
				FROM`show_to_tag`  
				left join `shows` on `show_to_tag`.`s_id` = `shows`.`s_id`
				left join `tag` on `show_to_tag`.`t_id` = `tag`.`t_id` 
				WHERE `shows`.`s_id` = {$s_ids[$j-$counterJ]['s_id']}
				LIMIT 1")->row_array();
		}

		foreach ($rs as &$one) 
		{
			$one['s_vertical_image'] = str_replace('sibox', 'vertical',$one['s_sibox_image'] ) ;
		}
		return $rs;
	}

	public function getHotRecommend($area,$limit = 10)
	{
		$rs = $this->db->query("SELECT count(`u_id`) as `numbers`,`s_name`,`shows`.`s_id`,`status`,`area`,`s_sibox_image`,`s_name_cn`
			FROM `subscribe` 
			LEFT JOIN `shows` ON `subscribe`.`s_id` = `shows`.`s_id` 
			{$area} 
			group by `shows`.`s_id` 
			order by `numbers` DESC
			limit {$limit}")->result_array();
		foreach ($rs as &$one) 
		{
			$one['s_vertical_image'] = str_replace('sibox', 'vertical',$one['s_sibox_image'] );
		}
		return $rs;
	}

	public function getAllTagWithStatus($uid)
	{
		$rs = $this->db->query("SELECT `tag`.`t_id`,`t_name`,`t_name_cn`
			FROM `tag` 
			WHERE 1")->result_array();
		foreach ($rs as &$oneRes) 
		{
			$checker = $this->db->query("SELECT * FROM user_to_tag
				WHERE u_id = {$uid} AND t_id = {$oneRes['t_id']} LIMIT 1")->row_array();
			if (empty($checker)) 
			{
				$oneRes['lik'] = 1;
			}
			else
			{
				$oneRes['lik'] = 0;
			}
		}
		if(!is_null($rs))
			return $rs;
		else
			return null;
	}

	public function checkLike($u_id,$t_id)
	{
		$checker = $this->db->query("SELECT * FROM user_to_tag
				WHERE u_id = {$u_id} AND t_id = {$t_id} LIMIT 1")->row_array();
		if (!is_null($checker)) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertLike($u_id,$t_id)
	{
		if ($this->checkLike($u_id,$t_id)) 
		{
			return "Repeat";
		}
		$this->db->query("INSERT INTO user_to_tag (u_id, t_id) 
			VALUES ({$u_id}, {$t_id})");
		if ($this->db->affected_rows()) 
		{
			$rs = $this->db->query("SELECT t_name,t_name_cn FROM tag 
				WHERE t_id = {$t_id} LIMIT 1")->row_array();
			return 'OK:'.$rs['t_name'].'-'.$rs['t_name_cn'];
		}
		else
		{
			return "Repeat";
		}
		return null;
	}

	public function deleteLike($u_id,$t_id)
	{
		$this->db->query("DELETE FROM user_to_tag WHERE 
			u_id = {$u_id} AND t_id = {$t_id} LIMIT 1");
		if ($this->db->affected_rows()) 
		{
			$rs = $this->db->query("SELECT t_name,t_name_cn FROM tag 
				WHERE t_id = {$t_id} LIMIT 1")->row_array();
			return 'OK:'.$rs['t_name'].'-'.$rs['t_name_cn'];
		}
		else
		{
			return "None";
		}
		return null;
	}

	//统计下载量的方法，随便统计，保证正常使用优先
	public function plusOneDownload($e_id)
	{
		$checker = $this->db->query("SELECT * FROM download_count
			WHERE e_id = {$e_id}  LIMIT 1")->row_array();
		if (!empty($checker)) {
			$this->db->query("UPDATE `download_count` SET `count` = `count` + 1 WHERE `e_id` = {$e_id}" );
			return "OK";
		}
		else
		{
			$this->db->query("INSERT INTO `download_count`(e_id,count) VALUES ({$e_id},1)" );
			return "OK";
		}
	}

	//搜索下载排行榜的方法
	public function getDownloadCount($limit)
	{
		$checker = $this->db->query("SELECT `shows`.`s_id`,`shows`.`s_name`,`shows`.`s_name_cn`,`shows`.`s_sibox_image`,`episode`.`se_id`,`episode`.`e_num`,`download_count`.`count` 
			FROM `download_count` 
			LEFT JOIN `episode` ON `download_count`.`e_id` = `episode`.`e_id`
			LEFT JOIN `shows` ON `episode`.`s_id` = `shows`.`s_id`
			ORDER BY `download_count`.`count` DESC
			LIMIT {$limit}")->result_array();
		if (!empty($checker)) 
		{
			foreach ($checker as &$one) 
			{
				$one['s_vertical_image'] = str_replace('sibox', 'vertical',$one['s_sibox_image'] );
			}
			return $checker;
		}
		return null;
		
	}

	public function getSynPercent($u_id,$s_id)
	{
		$numerator = $this->db->query("SELECT COUNT(*) AS `numerator`
			FROM `episode` 
			LEFT JOIN `synchron` ON `episode`.`e_id` = `synchron`.`e_id` 
			WHERE u_id = {$u_id} AND s_id = {$s_id}")->row_array();
		$denominator = $this->db->query("SELECT COUNT(*) AS `denominator`
			FROM `episode` 
			WHERE s_id = {$s_id}")->row_array();
		// $result = array(
		// 	'numerator' => $numerator['numerator'],
		// 	'denominator' => $denominator['denominator']
		// );
		if ($denominator['denominator'] == 0)
			return 0.0;
		return $numerator['numerator']/$denominator['denominator'];
	}
}