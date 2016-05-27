<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('config',true);
		$this->dateFormat = '/^\d{4}-[0-1][1-9]-[0-3]\d$/';
		$this->pwFormat = '/^\w{32}$/';
		$this->CalUrl = 'http://www.pogdesign.co.uk';
		header("Content-type: text/html; charset=utf-8");
		$this->errorList = array(
			0 => null,
			1 => null,
			2 => 'Wrong Request:',
			3 => 'Empty Response:',
			4 => 'Incorrect Parameter:',
			5 => 'Wrong Result',
			6 => 'Login need'
		);		
	}

	/*
	普遍约定：
	errno：
	1 - 无错误
	2 - 错误的请求
	3 - 空的输出
	4 - 传参错误
	5 - 返回结果错误
	6 - 未授权
	*/

	public function index()
	{
		$data['ouput'] = array(
			'errno' => 2,
			'err' => $this->errorList[2].'request URL is not exist.' ,
			'rsm' => null
			); 
		$this->load->view('apiTemplate');
	}

	//获取一些默认配置信息的方法
	public function getConfig()
	{
		$data['output'] = array(
			'errno' => 1,
			'err' => '',
			'rsm' => array('CalUrl' => $this->CalUrl)
			); 
		$this->load->view('apiTemplate',$data);	
	}

	//参数格式务必保证是yyyy-mm-dd.
	//查找某一天所有集的方法
	public function selectOneDateEp()
	{
		$date = $this->db->escape($this->input->get('date',true));
		$this->load->model('ShowModel');
		#if(empty($date))
		if ($date == 'NULL') 
		{
			$date = date('Y-m-d');
		}
		else
		{
			$date = substr($date, 1,-1);
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if(preg_match($this->dateFormat,$date))
		{	//判断是否符合日期格式
			$rsm = $this->ShowModel->searchOneDateBrief($date);
			#$data['errorFlag'] = 0;
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Date format is incorrect'.$date;
		}
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//参数格式务必保证是yyyy-mm-dd.
	//登陆后使用账号只看我关注的剧更新的方法,需要日期和id
	public function selectOneDateEpWithUid()
	{
		$date = $this->db->escape($this->input->get('date',true));
		$u_id = intval($this->input->get('u_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$timezone = urldecode($this->input->get('timezone',true));
		$timezone = $this->db->escape($timezone);
		$this->load->model('ShowModel');
		if(empty($date))
		{
			$date = date('Y-m-d');
		}
		else
		{
			$date = substr($date, 1,-1);
		}
		if (!empty($timezone)) 
		{
			$timezone = substr($timezone, 1,-1);
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if(preg_match($this->dateFormat,$date) && !empty($u_id) )
		{	//判断是否符合日期格式
			$rsm = $this->ShowModel->searchRecentByUid($u_id,0,1,$date,$timezone);
			foreach ($rsm as &$oneShow) 
			{
				$oneShow['percent'] = $this->ShowModel->getSynPercent($u_id,$oneShow['s_id']);
			}
			#$data['errorFlag'] = 0;
			// if (empty($rsm)) 
			// {
			// 	$errno = 3;
			// 	$err = $this->errorList[$errno].'Server response with an empty set';
			// }
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Date format is incorrect or missing parameters';
		}
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	public function selectDates()
	{
		$dateStart = $this->db->escape($this->input->get('dateStart',true));
		$dateStart = substr($dateStart, 1,-1);
		$dateEnd = $this->db->escape($this->input->get('dateEnd',true));
		$dateEnd = substr($dateEnd, 1,-1);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (empty($dateStart) || empty($dateEnd)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else if(preg_match($this->dateFormat,$dateStart) && preg_match($this->dateFormat,$dateEnd))
		{	//判断是否符合日期格式
			$rsm = $this->ShowModel->searchDates($dateStart,$dateEnd);
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'Date format is incorrect';
		}
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//通过参数id查找集的详细信息
	public function searchByEpId($id = '')
	{
		$id = intval($this->input->get('id',true));
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (empty($id)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else
		{
			$rsm = $this->ShowModel->searchByEpId($id);
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//通过id查找剧的详细信息
	public function searchByShowId($id='')
	{
		$id = intval($this->input->get('id',true));
		$u_id = intval($this->input->get('u_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		if (!empty($u_id)) 
		{
			$this->checkLogin($u_id,$token);
		}
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (empty($id)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else
		{
			$rsm['show'] = $this->ShowModel->searchByShowId($id);
			$rsm['episodes'] = $this->ShowModel->searchEpsBySid($rsm['show']['s_id']);
			if (!empty($u_id)) 
			{
				if ($this->ShowModel->checkSubscribe($u_id,$id)) 
				{
					$rsm['subscribed'] = True;
				}
				else
				{
					$rsm['subscribed'] = False;
				}
			}
			else
			{
				$rsm['subscribed'] = False;
			}
			if (empty($rsm['show'])) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//输入中英文名查找剧的方法
	public function searchByName()
	{
		$words = $this->db->escape($this->input->get('words',true));
		$words = substr($words, 1,-1);
		$fullResult = $this->db->escape($this->input->get('fullResult',true));
		$fullResult = substr($fullResult, 1,-1);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		
		if (!empty($words)) 
		{
			$words = urldecode($words);
			#$words = str_replace('\'', "\\'", $words);
			#$words = str_replace('%20', ' ', $words);
			#$words = str_replace('%2F', '/', $words);

			$st = 0;
			$lg = 30;
			if ($fullResult == "fullresult") {
				$st = 0;
				$lg = 300;
			}
			$rsm = $this->ShowModel->searchByName($words,$st,$lg);
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'No search result.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//订阅剧
	public function subscribe()
	{
		$u_id = intval($this->input->get('u_id',true));
		$s_id = intval($this->input->get('s_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0" || $s_id == "0") 
		{
			$u_id = "";
			$s_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($s_id)) 
		{
			$rs = $this->ShowModel->insertSubscribe($u_id,$s_id,date('Y-m-d H:i:s'));
			if (!empty($rs)) 
			{
				if (substr($rs,0,3) == 'OK:') 
				{
					$rsm = array('OK' => substr($rs, 3));
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'You have subscribed this show.';
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//取消订阅剧
	public function unsubscribe()
	{
		$u_id = intval($this->input->get('u_id',true));
		$s_id = intval($this->input->get('s_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0" || $s_id == "0") 
		{
			$u_id = "";
			$s_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($s_id)) 
		{
			$rs = $this->ShowModel->deleteSubscribe($u_id,$s_id);
			if (!empty($rs)) 
			{
				if (substr($rs,0,3) == 'OK:') 
				{
					$rsm = array('OK' => substr($rs, 3));
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'You have not subscribed this show yet.';
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//同步集
	public function Synchron()
	{
		$u_id = intval($this->input->get('u_id',true));
		$e_id = intval($this->input->get('e_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0" || $e_id == "0") 
		{
			$u_id = "";
			$e_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($e_id)) 
		{
			$rs = $this->ShowModel->insertSynchron($u_id,$e_id,date('Y-m-d H:i:s'));
			if (!empty($rs)) 
			{
				if (substr($rs,0,3) == 'OK:') 
				{
					$rsm = array('OK' => substr($rs, 3));
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'You have not synchroned this episode.';
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters'.$u_id.'   '.$e_id;
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//取消同步集
	public function unsynchron()
	{
		$u_id = intval($this->input->get('u_id',true));
		$e_id = intval($this->input->get('e_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0" || $e_id == "0") 
		{
			$u_id = "";
			$e_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($e_id)) 
		{
			$rs = $this->ShowModel->deleteSynchron($u_id,$e_id);
			if (!empty($rs)) 
			{
				if (substr($rs,0,3) == 'OK:') 
				{
					$rsm = array('OK' => substr($rs, 3));
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'You have not synchroned this episode yet.';
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//喜欢某标签的方法
	public function like()
	{
		$u_id = intval($this->input->get('u_id',true));
		$t_id = intval($this->input->get('t_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0" || $t_id == "0") 
		{
			$u_id = "";
			$t_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($t_id)) 
		{
			$rs = $this->ShowModel->insertLike($u_id,$t_id);
			if (!empty($rs)) 
			{
				if (substr($rs,0,3) == 'OK:') 
				{
					$rsm = array('OK' => substr($rs, 3));
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'You have not likeed this tag.';
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//取消喜欢某标签的方法
	public function unlike()
	{
		$u_id = intval($this->input->get('u_id',true));
		$t_id = intval($this->input->get('t_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0" || $t_id == "0") 
		{
			$u_id = "";
			$t_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($t_id)) 
		{
			$rs = $this->ShowModel->deleteLike($u_id,$t_id);
			if (!empty($rs)) 
			{
				if (substr($rs,0,3) == 'OK:') 
				{
					$rsm = array('OK' => substr($rs, 3));
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'You have not liked this episode yet.';
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//获得我的关注的剧集,默认是前后七天
	public function myshows()
	{
		$u_id = intval($this->input->get('u_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		$errno = 1;
		$err = '';
		$rsm = array();
		$rsm['rescentEps'] = $this->ShowModel->searchRecentByUid($u_id,7,7,date('Y-m-d'),'+00');
		$rsm['mySubscribe'] = $this->ShowModel->searchByUidOrderByDate($u_id);

		foreach ($rsm['rescentEps'] as &$anEpisode) 
		{
			$synFlag = $this->ShowModel->checkSyn($u_id,$anEpisode['e_id']);
			if ($synFlag) 
			{
				$anEpisode['syn'] = 1;
			}
			else
			{
				$anEpisode['syn'] = 0;
			}
		}

		// if (empty($rsm['rescentEps']) && empty($rsm['mySubscribe'])) 
		// {
		// 	$errno = 3;
		// 	$err = $this->errorList[$errno].'The server response with an empty set.';
		// }

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);

	}


	//获得标签的方法
	public function getTag()
	{
		$u_id = intval($this->input->get('u_id',true));
		$token = $this->db->escape($this->input->get('u_token',true));
		$this->checkLogin($u_id,$token);
		$this->load->model('ShowModel');
		if ($u_id == "0") 
		{
			$u_id = "";
		}
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id)) 
		{
			$rsm = $this->ShowModel->getAllTagWithStatus($u_id);
			if (empty($rsm)) 
			{
				$errno = 3;
				$err = $this->errorList[$errno].'The server response with an empty set.';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//注册的方法，密码传密文进来
	public function mobileRegister()
	{
		$this->load->model('UserModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		$u_phone = intval($this->input->post('u_phone',true));
		$u_passwd = $this->db->escape($this->input->post('u_passwd',true));
		$u_passwd = substr($u_passwd, 1,-1);
		$u_name = $this->db->escape($this->input->post('u_name',true));
		if (!empty($u_phone) && !empty($u_passwd))
		{
			$u_passwd = md5($u_passwd);
			$rs = $this->UserModel->register($u_name,$u_phone,$u_passwd);
			if (!empty($rs)) 
			{
				if ($rs == "PHONEREPEAT") 
				{
					$errno = 5;
					$err = $this->errorList[$errno].'The phone number is repeat.';
				}
				else
				{
					$rsm = array(
						'u_id' => $rs['u_id'],
						'u_name' => $rs['u_name'],
						'u_phone' => $rs['u_phone'],
						'u_token' => $rs['u_token']
					);
				}
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Server response with an empty set';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
		
	}

	//使用token登陆的方法
	public function loginByToken()
	{
		$u_token =  $this->db->escape($this->input->get('u_token',true));
		$u_id =  intval($this->input->get('u_id',true));
		$this->load->model('UserModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_id) && !empty($u_token)) 
		{
			$rs = $this->UserModel->loginByToken($u_id,$u_token);
			if (isset($rs['u_id'])) 
			{
				$rsm = $rs;
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Incorrect userid or user token';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//账号密码登陆方法（密码是密文）
	public function loginByPassword()
	{
		$u_phone = $this->db->escape($this->input->post('u_phone',true));
		$u_passWordHash =  $this->db->escape($this->input->post('u_passwd',true));
		$u_passWordHash = substr($u_passWordHash, 1,-1);
		$this->load->model('UserModel');
		$errno = 1;
		$err = '';
		$rsm = null;
		if (!empty($u_phone) && !empty($u_passWordHash)) 
		{
			$rs = $this->UserModel->login($u_phone,$u_passWordHash);
			if (isset($rs['u_id'])) 
			{
				$rsm = $rs;
			}
			else
			{
				$errno = 3;
				$err = $this->errorList[$errno].'Incorrect user phone or user password';
			}
		}
		else
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);
	}

	//ajax更新用户密码以及个人信息的方法
	public function updateUser()
	{
		$this->load->model('UserModel');

		$u_id = intval($this->db->escape($this->input->post('u_id',true)));
		$name = $this->db->escape($this->input->post('u_name',true));
		$pwd = $this->db->escape($this->input->post('pwd',true));
		$pwdNew = $this->db->escape($this->input->post('pwdNew',true));
		if (empty($name)) 
		{
			$name = "Undefined";
		}
		if (empty($pwd) || empty($pwdNew)) 
		{
			$errno = 4;
			$err = $this->errorList[$errno].'missing parameters';
		}
		else
		{
			//旧密码与新密码相同时，只更新其他内容
			if ($pwd == $pwdNew) 
			{
				$rs = $this->UserModel->updateNameOnly($u_id,$pwd,$name);
				if (!empty($rs)) 
				{
					if ($rs == 'OK') 
					{
						$rsm = array('u_name'=>$name);
					}
					else
					{
						$errno = 3;
						$err = $this->errorList[$errno].'Incorrect user phone or user password';
					}
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'Unknown error';
				}		
			}
			else
			{
				$rs = $this->UserModel->updateUserInfo($u_id,$pwd,$pwdNew,$name);
				if (!empty($rs)) 
				{
					if ($rs == 'OK') 
					{
						$rsm = array('u_name'=>$name);
					}
					else
					{
						$errno = 3;
						$err = $this->errorList[$errno].'Incorrect user phone or user password';
					}
				}
				else
				{
					$errno = 5;
					$err = $this->errorList[$errno].'Unknown error';
				}		
			}
		}
		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);	
	}

	//二期工程预告：从一个剧中不断添加条件之后筛选出剧的方法入口
	//目前仅实现全部剧的搜索
	public function showFilter()
	{
		$this->load->model('ShowModel');
		$startPage = intval($this->input->get('startPage',TRUE));
		$itemPerPage = intval($this->input->get('itemPerPage',TRUE));

		if(empty($startPage))
		{
			$startPage = 0;
		}
		if (empty($itemPerPage) || $itemPerPage == 0 ) 
		{
			$itemPerPage = 20;
		}

		$errno = 1;
		$err = '';
		$rsm = array();
		$numberOfShows = $this->ShowModel->getNumberOfShows();
		$rsm['countShow'] = ceil(intval($numberOfShows['num'])/intval($itemPerPage));
		$rsm['shows'] = $this->ShowModel->getShows($startPage,$itemPerPage);

		$data['output'] = array(
			'errno' => $errno,
			'err' => $err,
			'rsm' => $rsm
			);
		$this->load->view('apiTemplate',$data);	
	}

	//测试方法，开发时请删除此方法
	public function test()
	{
		$u_id = '2';
		$token = '333';
		$this->checkLogin($u_id,$token);
		
		echo intval('');
		echo intval();
	}

	public function checkLogin($u_id,$token)
	{	
		if (empty($u_id) || empty($token)) 
		{
			echo '{"errno":6,"err":"missing token or user identity","rsm":""}';
			exit(-1);
		}
		$this->load->model('UserModel');
		if($this->UserModel->loginByToken($u_id,$token) == 'WrongPw')
		{
			echo '{"errno":6,"err":"wrong token","rsm":""}';
			exit(-2);
		}
	}

	//已废弃，原先用于预防SQL注入，出于兼容目的保留
	public function filter($input)
	{
		$mid = str_replace("'", ' ', $input);
		$mid = str_replace('"', ' ', $mid);
		$mid = str_replace(';', ' ', $mid);
		$mid = str_replace('?', ' ', $mid);
		$mid = str_replace('*', ' ', $mid);
		return $mid;
	}
}