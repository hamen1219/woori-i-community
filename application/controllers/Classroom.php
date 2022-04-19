<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom extends CI_Controller {

	/***********************************
		생성자 >> 라이브러리 및 모델 로드
	***********************************/

	public function __construct()
	{
		parent::__construct(); //오버라이드 
		$this->load->model('user_m', 'user',TRUE);
		$this->load->model('reply_m', 'reply',TRUE);	
	}

	/***********************************
		header footer 사이 들어온 메서드 넣기	
	***********************************/
	public function _remap($method)
	{	

		$this->load->library('paging');
		$this->load->model('user_m', 'user',TRUE);
		$this->load->model('board_m', 'board','TRUE');
		$this->load->model('baby_m', 'baby','TRUE');
		$this->load->model('class_m', 'class','TRUE');

		$this->sess->get_access(0, '/main/login');

		//들어온 메서드 명
		
		$url = urldecode($this->uri->uri_string());
		$url = substr($url, 9);

		$len = strlen($method); 
		$num = strpos($url, $method)+$len+1;

		$param = substr($url, $num);

		$url_arr = explode('/',$param);
		$cnt = count($url_arr);
		if(empty($url_arr[0])) $cnt = 0;	

		//세션 정보를 담아 보낸다
		$user = $this->sess->get_sess();
      
		$data['user'] = $user;
		if($data['user'] != "" && $data['user']['dept'] == "학부모" )
		{
			$this->load->model('message_m', 'msg', TRUE);
			$data['unread_msg_cnt'] = $this->msg->getTotalComment($this->sess->get_id(), 'unread');
		}

		//header + method + footer
		$this->load->view('homepage/base/header', $data);	
		if(method_exists($this, $method)) 
		{			
			//매개변수 3개까지 받아보기
			switch ($cnt) {
				case 0:
					$this->$method();
					break;
				case 1:
					$this->$method($url_arr[0]);
					break;
		
				default :
					$this->$method($url_arr[0], $url_arr[1]);
					break;
			}
		}
		else
		{
			$this->sess->get_access('alert', '/main', '잘못된 경로입니다');
		}
		$this->load->view('homepage/base/footer');	
	}

	//학급 카테고리 보여주기
	public function list($mode = "")
	{
		$user = $this->sess->get_sess();
		//커뮤니티 내 모든 학급 리스트 가져오기
		if($mode == "all")
		{
			//전체 클래스 정보
			$data['class'] = $this->class->getClass();
		}

		//학부모의 아동들이 속한 모든 반 리스트 가져오기
		else
		{
			$data['class'] = $this->class->getMyClass($user['id']);
			$data['mode'] = "my";
		}
		
		$this->load->view('homepage/classroom/class_group', $data);
	}

	//일반 학급 페이지 불러오기
	public function class($class = "")
	{		
		//들어온 반 이름 없을 경우 담임교사의 반을 찾아본다.	

		//소속 학급인 교사 및 학부모만 접근 가능
		$base_url = "/classroom/class/".$class;
		$user = $this->sess->get_sess();	
		
		$page = $this->paging->get_segment('page');
		$page = !$page ? 1 : $page;

		if($class == "")
		{
			//내가 맡은 반 있는지..
			$rs = $this->class->getMyClass($user['id'], 'teacher');
			if(!$rs)
			{
				$this->sess->get_access('alert', '', '유효하지 않은 페이지입니다');
			}
			//class 결과 있는 경우 
			$class = $rs['name'];
		}

		//관리자, 부관리자는 아무 반이나 진입 가능.
		if($user['perm'] != "관리자" && $user['perm'] != "부관리자")
		{
			$rs = $this->class->checkMyClass($user['dept'], $class, $user['id']);			
			if(!$rs)
			{
				$this->sess->get_access('alert', '', '해당 학급 소속이 아닙니다');
			}
		}

		//담임교사 : 없을 수 있음.
		$data['teacher'] = $this->user->getTeacher($class);
		//아기들 : 없을 수 있음
		$data['baby'] = $this->baby->getClassBaby($class, $user['id']);				

		//학급 별 게시판. 없을 수 있음.
		$data['total_board'] = $this->class->getBoardList($class);		
		$data['rs'] = $this->class->getLimitBoardList($class, $page);
		$data['board'] = $data['rs'] ? $data['rs']['num'] : 0;	
		$data['user'] = $user;

		//학급 없으면 접근 제한
		$data['class'] = $this->class->getClass($class);


		if(!$data['class']) 
		{
			$this->sess->get_access('alert', '', '존재하지 않는 학급입니다');
		}
		//페이징 링크
		$data['paging_link'] = $this->paging->list($base_url,$data['total_board'],$page, $list=10, $num=5);
		$this->load->view('homepage/classroom/class', $data);
	}

	//나의 학급 찾기
	public function getMyClass($teacher)
	{
		$query = [
			'from' => 'class',
			'where' => [
				'teacher' => $person
			]
		];
		$rs = $this->result->get_list($query, 1);
		return $rs;
	}
}