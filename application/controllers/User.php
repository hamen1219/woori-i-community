<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {	
	public function __construcct()   
	{
		//CI Controller 상속
		parent::__construct();		
	}

	//remap 함수를 사용하여 header, footer 
	public function _remap($method)
	{	
		//라이브러리 및 모델 가져오기
		$this->load->library('paging');
		$this->load->model('user_m', 'user',TRUE);
		$this->load->model('board_m', 'board',TRUE);
		$this->load->model('baby_m', 'baby',TRUE);
		$this->load->model('class_m', 'class',TRUE);
		$this->load->model('message_m', 'msg',TRUE);

		//사용자 컨트롤러에서는 비로그인 사용자 접근 불가
		$this->sess->get_access(0, '/main/login');

		//들어온 메서드 명
		$len = strlen($method); 
		$url = urldecode($this->uri->uri_string());
		$num = strpos($url, $method)+$len+1;
		$param = substr($url, $num);
		$url_arr = explode('/',$param);
		$cnt = count($url_arr);
		if(empty($url_arr[0])) $cnt = 0;	

		//사용자 세션 정보      
		$data['user'] = $this->sess->get_sess();

		//상단 팝업을 위한 데이터 조회
		if($data['user'] != "" && $data['user']['dept'] == "학부모" )
		{
			$this->load->model('message_m', 'msg', TRUE);
			$data['unread_msg_cnt'] = $this->msg->getTotalComment($this->sess->get_id(), 'unread');
		}

		//메서드 있는 경우
		if(method_exists($this, $method)) 
		{		
			//아동 메세지($method == "msg")의 경우 header, footer를 제외시킨다.
			if($method != "msg")
			{
				$this->load->view('homepage/base/header', $data);
			}					

			//매개변수 3개까지 받아보기
			switch ($cnt) {				
				case 1:
					$this->$method($url_arr[0]);
					break;
				case 2:
					$this->$method($url_arr[0], $url_arr[1]);
					break;
				case 3:
					$this->$method($url_arr[0], $url_arr[1],$url_arr[2]);
					break;

				default:
					$this->$method();
					break;
			}					
		}
		//유효하지 않은 메서드		
		else
		{							
			$this->sess->get_access('alert', '/main', '잘못된 경로입니다');
		}

		//아동메세지 footer 제외
		if($method != "msg")
		{
			$this->load->view('homepage/base/footer');	
		}	
	}	


	/***********************************
		사용자 마이룸
	***********************************/
	public function myroom()
	{
		//세그먼트 분석하여 마이룸 ID 있는지 확인
		$seg = $this->paging->get_segment('myroom');

		//로그인 세션 정보
		$login_user = $this->sess->get_sess();

		//들어온 마이룸 ID가 있으면 (내 마이룸 또는 상대방 마이룸 보기 모드)
		if($seg)
		{
			//세그먼트로 들어온 유저 ID에 해당하는 유저 조회
			$user = $this->user->getUser($seg);

			//유저 데이터가 존재하지 읺을 경우 거부
			if(!$user)
			{
				$this->sess->get_access('alert', '', '유효하지 않은 사용자입니다');
			}

			//유저 데이터가 존재할 경우
			else
			{	
				//본인 또는 운영진 접속시 해당 사용자에 대한 아동 관리 및 저장 스크랩 게시물 보기 권한 주기
				if($user['id'] == $this->sess->get_id() || $login_user['perm'] == "관리자" || $login_user['perm'] == "부관리자")
				{
					$perm = 1;
				}	
				//본인이 아닐 경우 권한 x (일반 보기만 가능)
			}
		}

		//세그먼트로 사용자 ID가 들어오지 않은 경우 (내 마이룸 모드)
		else
		{
			//user : 현재 로그인 사용자
			$user = $login_user;
			$perm = 1;
		}

		//내 마이룸 또는 관리자 권한일 경우의 데이터 얻기
		if(isset($perm))
		{
			//아동 정보 
			$data['baby'] = $this->baby->getBaby($user['id']);
 
			//아동 메세지 정보 (전체, 읽지않은 메세지 개수)
			$data['msg_cnt'] = $this->msg->getTotalComment($user['id']);	
			$data['unread_msg_cnt'] = $this->msg->getTotalComment($user['id'], 'unread');										

			//사용자가 스크랩 한 게시물 목록
			$data['mysave'] = $this->board->getMySave($user['id']);			
		}

		//us : 마이룸 페이지 정보의 사용자 (현재 로그인 한 유저 아닐수도 있음)
		$data['us'] = $user;

		//마이룸 사용자 정보
		$data['us2'] = $login_user;

		//최근 로그인 한 시각		
		$data['visit_latest'] =	$rs = $this->user->getVisitLatest($user['id']);	

		//사용자 작성 총 게시물
		$rs = $this->user->getUsersBoard($user);		

		//게시물 그래프 정보
		$data['us2_div'] = [			
			'total_my_b'   => $rs['total_my_b'],
			'total_my_r'   => $rs['total_my_r'],
			'total_good'   => $rs['total_good'],
			'total_poor'   => $rs['total_poor'],
			'total_save'   => $rs['total_save'],
			'total_good_r' => $rs['total_good_r'],
			'total_poor_r' => $rs['total_poor_r']
		];

		//페이지 가져오기 및 data 보내기		
		$this->load->view('homepage/user/myroom', $data);
	}

	/***********************************
		마이룸 내 메세지 창
	***********************************/
	public function msg($baby, $class="")
	{
		//학급명이 없을 경우
		if($class == "")
		{
			$this->sess->get_access('alert', 'close', '해당 아동의 반이 설정되어 있지 않습니다');
		}

		//로그인 세션 정보
		$user = $this->sess->get_id();

		//사용자의 아동 불러오기
		$rs = $this->baby->getBaby($user, $baby);

		//아동정보 없는 경우 out
		if(!$rs)
		{
			$this->sess->get_access('alert', 'close', '아동 정보를 찾을 수 없습니다');
		}

		//학급 및 아동 정보 
		$data['class'] = $class;
		$data['baby'] = $baby;

		//학급 메세지 정보
		$data['comment'] = $this->msg->getComment($class, $user, $baby);
		$data['class_msg'] = $this->msg->getClassNotice($class);
		$data['all_class_msg'] = $this->msg->getAllClassNotice();
		
		//게시물 읽음 표시 해주기!
		$this->msg->setCommentRead($class, $user, $baby);

		//메세지 페이지
		$this->load->view('homepage/user/message/baby_msg', $data);	
	}

	public function logout()
	{
		$this->sess->logout();
	}	
}