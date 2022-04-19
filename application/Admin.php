<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {	
	//관리자 모드 컨트롤러
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_m', 'user', TRUE);
		$this->load->model('board_m', 'board', TRUE);	
		$this->load->model('baby_m', 'baby', TRUE);		
		$this->load->model('class_m', 'class', TRUE);
	}

	//remap을 이용한 header, method, footer 합치기 ========
	public function _remap($method) 
	{	
		//로그인 되지 않은 경우 거절	
		$this->sess->get_access(0, '/main/login');

		//현재 로그인 사용자가 관리자, 부관리자가 아닐 경우 거절
		$user = $this->sess->get_sess();

		if($user['perm'] !== '관리자' && $user['perm'] !== '부관리자')
		{
			$this->sess->get_access('alert', '/main', '관리자 권한이 아닙니다.');
		}
	

		//헤더 (사용자 정보 넘겨준다)
		$data['user'] = $user;

		if($data['user'] != "" && $data['user']['dept'] = "학부모" )
		{
			$this->load->model('message_m', 'msg', TRUE);
			$data['unread_msg_cnt'] = $this->msg->getTotalComment($this->sess->get_id(), 'unread');
		}
		$this->load->view('homepage/base/header', $data);	

		//메서드 확인되면 실행
		if(method_exists($this, $method)) 
		{
			$this->$method();			
		}
		//해당 메서드 없다면 에러페이지
		else
		{
			$this->sess->get_access('alert', '/main', '잘못된 경로입니다');
		}
		//footer
		$this->load->view('homepage/base/footer');	
	}

	//관리자 페이지 초기화면
	public function index()
	{
		$user = $this->sess->get_sess();

		//1. 현재 사용자의 데이터
		$data['user'] = $user;

		//2. 대문 데이터 가져오기
		$data['intro'] = $this->board->getIntroBoard();

		//사용자 목록
		$data['empty'] = $this->user->getParents(0);
		$data['common'] = $this->user->getParents(1);

		//교사목록
		$data['t_empty'] = $this->user->getTeachers(0);
		$data['t_common'] =  $this->user->getTeachers(1);
		$data['t_sub_admin'] =  $this->user->getTeachers(99);
		$data['t_empty_not'] =  $this->user->getTeachers(-1);

		//반과 아이들 목록
		$data['class'] = $this->class->getClass();
		$data['baby'] = $this->baby->getBaby();

		////////
 
		$data['visit'] = $this->user->getVisit();

		//3. 전체 게시물 목록 가져오기
		$data['board'] = $this->board->getBoards();

		//4. 전체 방문자 목록 가져오기		

		//관리자 페이지로 데이터 넘겨주기
		$this->load->view('homepage/admin/main', $data);	
	}	
}


