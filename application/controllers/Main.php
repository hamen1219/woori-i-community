<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	Main Controller : 메인 페이지를 비롯한 홈페이지의 각 페이지 이동을 담당.
*/
class Main extends CI_Controller {	
	public function __construcct()   
	{
		//CI Controller 상속
		parent::__construct();
	}

	//remap을 사용하여 header, footer 붙이기
	public function _remap($method) 
	{	
		//모델 불러오기
		$this->load->model('board_m', 'board', TRUE);
		$this->load->model('user_m', 'user', TRUE);  

		//매개변수 가져오기
		$len = strlen($method); 
		$url = urldecode($this->uri->uri_string());
		$num = strpos($url, $method)+$len+1;
		$param = substr($url, $num);
		$url_arr = explode('/',$param);
		$cnt = count($url_arr);
		if(empty($url_arr[0])) $cnt = 0;	

		//현재 세션 유저정보
		$data['user'] = $this->sess->get_sess();
		if($data['user'] != "" && $data['user']['dept'] == "학부모" )
		{
			$this->load->model('message_m', 'msg', TRUE);
			$data['unread_msg_cnt'] = $this->msg->getTotalComment($this->sess->get_id(), 'unread');
		}

		//1. 헤더 가져오기
		$this->load->view('homepage/base/header', $data);	
		
		//2. 메서드, 매개변수 매칭하여 컨트롤러 내 메서드 실행

		//메서드 확인되면 
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
		//3. 푸터 가져오기
		$this->load->view('homepage/base/footer');	
	}

	/***********************************
		메인 페이지
	***********************************/
	public function index()
	{
		//메인페이지 상단 총 방문, 오늘의 방문
		$data['v_today'] = $this->user->getVisitToday();
		$data['v_total'] = $this->user->getVisitTotal();

		//메인페이지 상단 유저 랭킹 데이터
		$data['lb_max']  = $this->user->getLikeBoardMax();		
		$data['sb_max']  = $this->user->getSaveBoardMax();	
		$data['lr_max']  = $this->user->getLikeReplyMax();	
		$data['b_max']   = $this->user->getBoardMax();	
		$data['r_max']   = $this->user->getReplyMax();		
		$data['v_max']   = $this->user->getVisitMax();	

		//메인페이지 중간 게시판 그룹 데이터
		$data['intro']   = $this->board->getIntroBoard();	
		$data['gallary'] = $this->board->getGallaryBoard();	
		$data['meeting'] = $this->board->getMeeting();

		//페이지 가져오기 및 data 보내기
		$this->load->view('homepage/home', $data);
	}

	/***********************************
		회원관리
	***********************************/

	//로그인 및 회원가입
	public function login()
	{
		$this->sess->get_access(1, '/main');		
		$this->load->view('homepage/user/login');
	}

	public function join()
	{
		$this->sess->get_access(1, '/main');
		$this->load->view('homepage/user/join');
	}

	/***********************************
		기타 페이지
	***********************************/

	//관리자 인사말 페이지
	public function greeting()
	{
		$this->load->view('homepage/about/hp/greeting');
	}

	//회사 소개 페이지
	public function intro()
	{
		$this->load->view('homepage/about/hp/intro');
	}

	//약도 페이지
	public function map()
	{
		$this->load->view('homepage/about/hp/map');
	}

	//개발자 소개 페이지
	public function intro_me()
	{
		$this->load->view('homepage/about/dev/intro');
	}

	//사용 기술 페이지
	public function language()
	{
		$this->load->view('homepage/about/dev/language');
	}

	//포트폴리오 페이지
	public function library()
	{
		$this->load->view('homepage/about/dev/library');
	}

	//이력 페이지
	public function timeline()
	{
		$this->load->view('homepage/about/dev/timeline');
	}

	/***********************************
		알림 페이지
	***********************************/
	public function error($msg = "", $error = "")
	{
		//기본 에러 메세지
		$data['msg'] = "오류가 발생하였습니다";

		//사용자 에러 메세지 받아오기
		if($msg !== "")
		{
			$data['msg'] = $msg;
		}
		if($error !== "")
		{
			$data['error'] = $error;
		}

		$this->load->view('homepage/alert/error', $data);
	}

	public function success_join()
	{
		//flash 데이터 넘겨주기
		$data['user'] = $this->session->flashdata();
		$this->load->view('homepage/alert/success_join', $data);
	}

	public function test()
	{
		$data['user'] = $this->sess->get_sess();
		$this->load->view('homepage/alert/success_join', $data);
	}
}
	    