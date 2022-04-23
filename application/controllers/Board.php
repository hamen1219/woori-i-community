<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	Board Controller : 게시물의 CRUD 및 Paging 담당.

*/


class Board extends CI_Controller {

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
		$len = strlen($method); 
		$url = urldecode($this->uri->uri_string());
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
		
				default:
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

	//게시물 상세보기
	public function read($mode = "")
	{	
		//1. url 검사
		$page = $this->paging->get_segment('page');
		//페이지 세그먼트 확인 불가시
		if(!$page)
		{
			$this->sess->get_access('alert', '/board/menu', '존재하지 않는 페이지입니다');
		}

		//2. 회원 로그인 검사
		$this->sess->get_access(0, "/main/login");

		//3. 게시물 불러오기
		$user = $this->sess->get_sess();	
		$data['user'] = $user['id'];

		if(!$board=$this->board->getBoard($page, $user['id']))
		{
			$this->sess->get_access('alert', '/board/menu','해당 게시물이 존재하지 않습니다');
		}
		
		$class_arr = [
			'학부모' => 'parent',
			'관리자' => 'admin',
			'교사' => 'teacher',
		];

		// var_dump($board);

		$board['class'] = empty($class_arr[$board['dept']]) ? "common" : $class_arr[$board['dept']];

		//4. 권한에 따른 페이지 제어
		switch($board['cat'])
		{

			//관리자, 부관리자 외 불가.
			case "운영진":
				$this->sess->get_access(99);
				break;

			//가입대기 회원 불가
			case "건의사항":
			case "QnA":
			case "자기소개":
			case "정모":
			case "채용":
				if($user['perm'] != "관리자" && $user['perm'] != "부관리자" && $user['perm'] != "일반")
				{
					$this->sess->get_access('alert', '', '일반 회원만 접근할 수 있습니다');
				}
				break;

			//해당 부서 외 불가
			case "학부모":
				if($user['perm'] != "관리자" && $user['perm'] != "부관리자" && $user['dept'] != "학부모")
				{
					$this->sess->get_access('alert', '', '학부모만 접근할 수 있습니다');
				}
				break;

			case "교사":
				if($user['perm'] != "관리자" && $user['perm'] != "부관리자" && $user['dept'] != "교사")
				{
					$this->sess->get_access('alert', '', '교사 회원만 접근할 수 있습니다');
				}
				break;
			default:				
				break;
		}
		

		//4. 유저 권한 확인
		if($user['perm'] != "관리자" && $user['perm'] != "부관리자")
		{
			//블라인드 게시판
			if($board['perm'] == "블라인드")
			{
				$this->sess->get_access('alert', '/board/menu', '관리자에 의해 제한된 게시물입니다');
			}		
		}

		//게시물 상세페이지 데이터 (1개의 게시물)
		$data['board'] = $board;	
		//최근 게시물 목록 (5개의 게시물)
		$data['side'] = $this->board->getSideBoards();			
		//게시물 댓글 데이터 및 댓글 갯수
		$rs = $this->reply->getReply($page,$user['id']);
		$data['reply'] = isset($rs['rs']) ? $rs['rs'] : 0;
		$data['reply_cnt'] = isset($rs['num']) ? $rs['num'] : 0;
	
		//5. 페이지 조회수 증가
		$this->board->setView($page);	

		$this->load->view('homepage/board/crud/read', $data);			
	}

	public function write()
	{
		$this->sess->get_access(0, "/main/login");
		//페이지 정보 필요 없음.
		$arr = explode('/',$this->uri->uri_string());
		
		//최근게시물 side 값 구해서 넘기기
		$data['side'] = $this->board->getSideBoards();	
		$data['user'] = $this->sess->get_sess();
		$data['cat'] = $this->paging->get_segment('cat');		
		$this->load->view('homepage/board/crud/write', $data);	
	}

	//업데이트 페이지 
	public function update()
	{
		//로그인 하지 않은 경우
		$this->sess->get_access(0, "/main/login");

		//로그인 확인 된 경우
		$user = $this->sess->get_sess();
		$page = $this->paging->get_segment('page');

		if(!$page)
		{
			$this->sess->get_access('alert', '', '잘못된 페이지 정보입니다');
		}

		//해당 페이지 번호의 게시물
		$rs = $this->board->getBoard($page);

		if(!$rs)
		{
			$this->sess->get_access('alert', '', '해당 게시물이 없습니다');
		}

		//게시물 작성자가 아닌 사람이 접근했을 때
		if($rs['user'] !== $user['id'])
		{
			//관리자, 부관리자만 허용
			if($user['perm'] != "관리자" && $user['perm'] != "부관리자")
			{
				$this->sess->get_access('alert', '', '수정 권한이 없습니다');
			}			
		}

		//현 게시물 정보, 최근 게시물 정보 불러오기
		$data['board'] = $rs;
		$data['side'] = $this->board->getSideBoards();	
		$data['user'] = $this->sess->get_sess();
		$data['cat'] = $this->paging->get_segment('cat');

		$this->load->view('homepage/board/crud/update', $data);	
	}

	//카테고리 메뉴 페이지
	public function menu()
	{
		$this->load->view('homepage/board/board_group');
	}

	//카테고리 내 게시물 리스트 페이지 
	public function list($cat = "전체게시물", $board_user = "")
	{

		$url = "/board/list/".$cat;
		if($cat == "작성자" && $board_user != "")
		{
			$url .= "/".$board_user;
		}
		//검색된 데이터 확인
		$form = $this->input->post();

		//

		//uri 접속시
		if(empty($form))
		{
			//검색 조건 요소들
			$arr['search'] = $this->paging->get_segment('search') ?	$this->paging->get_segment('search') : "";
			$arr['option'] = $this->paging->get_segment('option') ? $this->paging->get_segment('option') : "전체";	
			$arr['sort']   = $this->paging->get_segment('sort') ? $this->paging->get_segment('sort') : "최신순";		
			$page = $this->paging->get_segment('page') ? $this->paging->get_segment('page') : 1;
			
		}
		//첫 검색으로 들어왔을 시
		else
		{
			$arr['search'] = $form['search'];
			$arr['option']  = $form['option'];
			$arr['sort']   = $form['sort'];
			$page = 1;

			$str = "";
			foreach($arr as $key => $val)
			{
				if($val)
				{
					$str .= "/".$key."/".$val; 
				}				
			}
			redirect($url.$str);
		}

		//page : 실제 페이지 (paging 함수에 필요한 변수)
		$page = !$page ? 1 : $page; 
		//start : 페이지 내 게시물 시작 번호 값 (db 처리에 필요한 offset)
		$arr['start'] = !$page >= 1 ? 0 : ($page-1) * 10;

		//작성자 게시물 카테고리일시
		if($cat == "작성자")
		{
			if($board_user == "")
			{
				$this->sess->get_access('alert', '/board/menu', '게시물 사용자가 지정되지 않았습니다');
			}
			$arr['where'] = ['b.user' => $board_user];
			$url .= "/".$board_user;
		}

		//이외의 모든 게시판
		else if($cat != "전체게시물")
		{
			$arr['where'] = ['cat' => $cat];
		}
		//전체게시물일 경우 cat 지정 X

		//전체 결과 가져오기
		//var_dump($arr);
		$total_board = $this->board->getTotalBoardList($arr);
		$board       = $this->board->getBoardList($arr);
		$limit_board = $this->board->getLimitBoardList($arr);	
		$rs = $limit_board ? $limit_board['rs'] : 0;
		$limit_board = $limit_board ? $limit_board['num'] : 0; 
		$paging_link = $this->paging->list($url, $board, $page);

		$user = $this->sess->get_sess();
		//게시물 리스트 페이지에 필요한 최종 데이터 압축
		$data = [
			'paging_link' => $paging_link,
			'total_board' => $total_board,
			'board'       => $board,
			'limit_board' => $limit_board,
			'rs'          => $rs,        
			'search'      => $arr['search'],
			'user'        => $user,
			'url'         => $url,
			'cat'         => $cat
		];

		//게시판 카테고리별 페이지 이동
		switch($cat)
		{

			//모든 회원들이 접근 가능한 카테고리

			case "등업":
				$data['title'] = "등업신청";
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/list', $data);	
				break;
			
			//왼쪽 검색바를 이용한 검색시 전체 게시물에 대한 자료 검색
			case "전체게시물":
				$data['title'] = "전체게시물";
				$data['cat_link'] = $this->getCatLink("");
				$this->load->view('homepage/board/user_board_list', $data);		
				break;
			case "자유게시판":
				$data['title'] = "자유게시판";	
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/list', $data);
				break;
			case "공지사항":
				$data['title'] = "공지사항";
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/list', $data);
				break;

			//작성자가 작성한 댓글
			case "작성자":
				$data['title'] = $board_user."님의 게시물";				
				$str = "<div id ='a_group'><a href='/user/myroom/".$board_user."'><b>작성자 프로필 보러가기</b></a></div>";
				$data['cat_link'] = $str;
				$this->load->view('homepage/board/user_board_list', $data);		
				break;

			//가입승인 회원에게만 허용
			case "건의사항":
				$this->sess->get_access(-1);
				$data['title'] = "건의사항";
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/list', $data);
				break;
			case "QnA":
				$this->sess->get_access(-1);
				$data['title'] = "Q&A";
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/list', $data);	
				break;
			case "자기소개":
				$this->sess->get_access(-1);
				$data['title'] = "자기소개";
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/intro_list', $data);					
				break;
			case "정모":
				$this->sess->get_access(-1);
				$data['title'] = "정모게시판";
				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/meeting', $data);					
				break;
			case "채용":
				$this->sess->get_access(-1);
				$data['title'] = "채용공고";
				$data['cat_link'] = "<div id = 'a_group'>우리아이 커뮤니티의 채용공고를 확인할 수 있습니다</div>";
				$this->load->view('homepage/board/job_list', $data);	
				break;

			//부서별 접근 제한
			case "학부모":
				$data['title'] = "학부모 커뮤니티";
				if($user['dept'] != "학부모" && $user['perm'] != "관리자" && $user['perm'] != "부관리자")
				{
					$this->sess->get_access('alert','', '학부모 회원만 접근할 수 있습니다');
				}

				$url = 'https://search.naver.com/search.naver?sm=tab_hty.top&where=nexearch&query=%EC%9E%A5%EB%82%9C%EA%B0%90&oquery=%EC%9E%A5%EB%82%9C%EA%B0%90%EC%88%9C%EC%9C%84&tqi=hsUZYlp0J14ssmMLVACssssstxh-149057';
				// $data['crawling'] = $this->crawling($url);

				$data['cat_link'] = $this->getCatLink($data['title']);
				$this->load->view('homepage/board/list', $data);	
				break;
			case "교사":
				$data['title'] = "교사 커뮤니티";		 

				if($user['dept'] != "교사" && $user['perm'] != "관리자" && $user['perm'] != "부관리자")
				{
					$this->sess->get_access('alert','', '교사 회원만 접근할 수 있습니다');
				}
				$url = 'https://search.naver.com/search.naver?sm=tab_hty.top&where=nexearch&query=%EA%B1%B4%EA%B0%95%EC%8B%9D%ED%92%88&oquery=%EC%8B%9D%EB%8B%A8&tqi=hsUwKdp0JywsseDgEMwssssstMV-014272';
				
				// $data['crawling'] = $this->crawling($url);	
				$data['cat_link'] = $this->getCatLink($data['title']);

				$this->load->view('homepage/board/list', $data);	
				break;
			case "운영진":
				//관리자, 부관리자 이외 접근 제한
				$this->sess->get_access(99);
				$data['title'] = "운영진 커뮤니티";
				$str = "<div id ='a_group'><a href='javascript:history.back();'><b>이전 페이지로 돌아가기</b></a></div>";
				$data['cat_link'] = $str;
				$this->load->view('homepage/board/list', $data);	
				break;			

			//이외의 알 수 없는 카테고리
			default:
				$this->sess->get_access('alert', '/board/menu', '존재하지 않는 게시물 카테고리입니다');
				break;
		}
	}

	//카테고리 링크 만드는 함수 (title에 해당하는 요소 있을 시 bold 체 str)
	public function getCatLink($title = "")
	{		
		// title : 실제 카테고리 이름
		// title 일치 값 없으면 전체 str 반환 
		$link_arr = ['공지사항', '자유게시판', '자기소개', '정모게시판', '건의사항', 'Q&A', '등업신청', '학부모 커뮤니티', '교사 커뮤니티'];

		$url_arr = ['board/list/공지사항', 'board/list/자유게시판', 'board/list/자기소개', 'board/list/정모',  'board/list/건의사항' ,'board/list/QnA', 'board/list/등업','board/list/학부모', 'board/list/교사'];
	
		//현재 카테고리명에 해당하는 배열 탐색 후 원소 빼준다.
		$cnt = 0;
		
		//링크 만들기 코드 시작 
		$str = "<div id = \"a_group\">";
		$len = count($link_arr);		
		$cnt = 0;

		//링크만들기
		foreach($link_arr as $val)
		{
			//해당 제목이 있다면 굵은 글씨체로 저장.
			if($val == $title)
			{
				//var_dump($url_arr);
				$str .= "<p><b>".$link_arr[$cnt]."</b></p>";
			}
			else
			{
				$str .= "<a href='/".$url_arr[$cnt]."'>".$link_arr[$cnt]."</a>";
			}			

			//마지막 제외한 게시판 문자열 뒤에는 |을 붙여준다.
			if($cnt < $len-1)
			{
				$str .= " | ";
			}
			else
			{
				$str .= "</div>";	
			}			
			$cnt++;
		}			
		return $str;
	}

	// public function crawling($url)
	// {
	// 	require('./static/lib/snoopy/Snoopy.class.php');
	//     $snoopy = new Snoopy;
    //  	$snoopy->fetch($url);
	//     //페이지 전체에서 리스트
	//     preg_match_all('/<li class="list_inner">(.*?)<\/li>/is', $snoopy->results, $html);

	//     //크롤링 한 장난감 데이터 배열 (1-10위)
	//   	$arr = [];
	//     for($i = 0; $i < 10; $i++)
	//     {	    
	//     	array_push($arr, $html[0][$i*4]);
	//     }

	// 	//순위 반환 
	// 	return $arr;
	// }
}
