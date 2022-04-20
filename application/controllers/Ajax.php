<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ajax 통신 담당 컨트롤러 
 */
class AjAX extends CI_Controller {	

	// init setting 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_m', 'user', TRUE);
		$this->load->model('board_m', 'board', TRUE);
		$this->load->model('reply_m', 'reply', TRUE);
		$this->load->model('class_m', 'class', TRUE);
		$this->load->model('baby_m', 'baby', TRUE);
		$this->load->model('Message_m', 'msg', TRUE);
		$this->load->library('upfile');	
		$this->load->library('comp');
		$this->load->library('mail');		
	}

	/**
	 * 가입시 이메일 보내는 함수 
	 */
	public function sendEmail()
	{		
		$this->load->library('mail');

		//이메일 보낼 명단 배열
		$form = $this->input->post();
		
		// data 
		$to = $form['arr']['arr'];
		$title = $form['arr']['title'];
		$contents = $form['arr']['contents'];

		// send email 
		$rs = $this->mail->sendEmail($to, $title, $contents);

		if($rs) {
			$data['code'] = 1;
			$data['msg'] = "이메일이 전송되었습니다";
		} else {
			$data['code'] = 0;
			$data['msg'] = "이메일 전송에 실패하였습니다";	
		}		
		print json_encode($data);		
	}

	/**
	 * 
	 */
	public function get_ajax($mode)
	{
		$this->checkForm();

		//폼데이터가 있다면
		$form = $this->input->post();

		if($mode == "id")
		{
			$id = $form['tid'];
			$rs = $this->user->checkUser($id);
			if(!$rs)
			{
				$data["msg"] = "이미 사용중인 아이디입니다";
				$data["code"] = 0;
			}
			else
			{
				$data["msg"] = "사용 가능한 아이디입니다";
				$data["code"] = 1;
			}
		}

		//로그인 모드
		else if($mode == "login")
		{
			$id = $form['tid'];
			$pw = $form['tpw'];

			$rs = $this->user->checkUser($id, $pw);
			
			if($rs === 1)
			{
				//유저 정보 세션에 등록
				$user =$this->user->getUser($id);
				$us['user'] = $user;				
				$this->session->set_userdata($us);

				//사용자 id 등록
				$this->user->setVisit($user['id']);
				$data["msg"] = "로그인 성공";
				$data["code"] = 1;
			}
			else if(!$rs)
			{
				$data["msg"] = "존재하지 않는 아이디입니다";
				$data["code"] = 0;
			}
			else if($rs === -1)
			{
				$data["msg"] = "비밀번호가 일치하지 않습니다";
				$data["code"] = -1;
			}
		}

		else if($mode == "join")
		{
			//아이디 중복확인
			$id = $form['tid'];
			$rs = $this->user->checkUser($id);

			if(!$rs) { //사용중
				$data["msg"] = "사용중인 아이디입니다";
				$data["code"] = -1;
			} else {
				//파일 업로드 시도 (실패해도 메세지)
				$url = "./img/users/".$id."/profile/";
				$do_upload = $this->upfile->do_upload("img_file", $url);
				$form['img'] = $do_upload; 				
			}	

			//사용자 정보 쿼리 배열화
			$form = $this->comp->user($form);
			$rs   = $this->user->joinUser($form); 

			if(!$rs) { // 가입 실패 
				$data["msg"] = "회원가입에 실패하였습니다";
				$data["code"] = 0;

			} else { // 가입 성공 

				// 가입성공 이메일 발송 문구
				$title = $id."님 가입을 축하드립니다";
				$contents =  "<img src = 'http://hung1219.cafe24.com/img/email/1.PNG'>";
				$contents .= "<h2>".$id."님의 커뮤니티 가입을 축하드립니다 :)</h2><hr/>";
				$contents .= "<p>이제부터 회원들과 다양한 소통을 하실 수 있습니다.</p>";
				$contents .= "<p>자유로운 소통, 정모, 자기소개 등 다양한 커뮤니티에 참여해주시길 바랍니다</p>";
				$contents .= "<p>또한 이데아커뮤니티의 다양한 소식을 받아보실 수 있습니다.</p><br/>";
				$contents .= "<p><b>다시 한번 ".$id."님의 회원가입을 축하드립니다.</b></p><br/><hr/>";
				$contents .= "<p>- 이데아커뮤니티 대표 안형모</p>";

				// send email
				$this->mail->sendEmail($form['email'], $title, $contents);

				$data["msg"] = "회원가입에 성공하였습니다";
				$data["code"] = 1;

				// 회원 정보 플래시 데이터에 저장 (가입 성공 페이지에 1회 보여주기)				
				$rs = $this->user->getUser($id);
				$this->session->set_flashdata($rs);
			}			
		}
		print json_encode($data);
	}

	/**
	 * 메인페이지 mini_board 데이터 반환 
	 */
	public function mini_board()
	{
		$mode = $this->input->post('board');	
		$rs   = $this->board->getAjaxBoard($mode);		
		$data = $this->get_html($rs);

		//ajax 반환
		print $data;
	}

	/**
	 * DB 결과 리스트를 html으로 변환시켜주는 함수 
	 * @param array $data DB 결과 리스트
	 * @return string html 문자열 
	 */
	public function get_html($data)
    {    
    	//data : 카테고리별 쿼리 결과 
    	if($data['num'] == 0)
        {
        	$msg = "등록된 게시물이 없습니다";
        }
        else if(is_array($data))
        {       
        	//msg : Ajax로 전달할 html 텍스트
        	$msg = "<table id = 'mini_table'><tr><th>작성자</th><th>글제목</th><th>작성일</th></tr>";

        	//Ajax 게시판 테이블 데이터 가져오기
        	foreach ($data['rs'] as $val) {   
        		//유저명 및 게시물 제목 길이 제한 (한글 인식 문제로 mb_substr 사용)

        		$user  = strlen($val['user']) > 9 ?  mb_substr($val['user'], 0, 9, 'UTF-8')." ··"  : $val['user'];
        		$title = strlen($val['title']) > 10 ?  mb_substr($val['title'], 0, 8, 'UTF-8')." ··"  : $val['title'];		
        		$created = substr($val['created'], 0, 10);

        		$msg .= "<tr><td>".$user."</td><td><a href = '/board/read/page/".$val['num']."'>".$title."</a></td><td>".$created."</td></tr>";
        	}
        	$cat = '';
        	
        	$msg .= "<tr><td colspan = '3'><a id = 'mini_table_a' href = '/board/list/".$val['cat']."'><b>";
        	$msg .= "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-arrow-right-circle-fill\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">
					  <path fill-rule=\"evenodd\" d=\"M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z\"/>
					</svg>&nbsp;";
        	$msg .= "게시판 더보기</b></tr></a></table>";
        }
        //반환
    	return $msg;
    }

	/**
	 * 관리자 페이지에서 선택된 회원의 등급 변경 또는 회원 삭제 함수  
	 */
	public function ctrl_user()
	{
		$this->ajaxPerm(99);	
		$this->checkForm();

		$arr = $this->input->post("arr");
		$mode =$this->input->post("mode");	
		
		$code = 0;	

		//update 시
		if($mode == "update") {
			
			foreach($arr as $val)
			{
				$where = ['id' => $val['id']];
				$query = ['perm' =>$val['perm']];

				// 등급변경
				$rs = $this->user->update($where, $query);
	
				if(!$rs) { // fail
					$code ++;
				}
			}

		} else { // delete

			// 선택된 유저만큼 삭제 실행
			foreach($arr as $val)
			{
				$where = ['id' => $val];

				// 회원 삭제 
				$rs = $this->user->delete($where);
				
				if(!$rs) { // fail
					$code ++;				
				}
			}
		}

		//삭제 또는 수정 실패시
		if($code < count($arr)) {
			if($mode == "delete") {
				$data['code'] = 1;
				$data['msg'] = "사용자 삭제에 성공하였습니다"; 
			} else {
				$data['code'] = 1;
				$data['msg'] = "사용자 수정에 성공하였습니다"; 
			}
		}
		else {
			if($mode == "delete") {
				$data['code'] = 0;
				$data['msg'] = "삭제할 사용자를 선택하세요"; 
			} else {
				$data['code'] = 0;
				$data['msg'] = "수정할 사용자를 선택하세요"; 
			}
		}		

		print json_encode($data);
	}

	/**
	 * 게시물 좋아요 처리 함수 
	 */
	public function like_b()
	{
		$this->ajaxPerm();	
		$this->checkForm();
		
		$post = $this->input->post();
		$user = $this->sess->get_id();	

		$mode = $post['mode'];

		//좋아요, 싫어요, 보관하기에 필요한 조건은?
		$query = [
			'user' => $user,
			'board_num' => $post['board_num']			
		];

		if($mode == "good") { // 좋아요 처리
			$from = "like_b";
			$query['good'] = 1;

		} else if($mode == "poor") { // 싫어요 처리
			$from = "like_b";
			$query['poor'] = 1;

		} else if ($mode == "save") { // 스크랩 처리
			$from = "save_b";
			$query['save'] = 1;
		}

		if(!$this->board->insertLike($from, $query)) { // 적용 실패 
			$data['code'] = 0;
			$data['msg'] = "board like error";

		} else { // 성공 
 			$data['code'] = 1;
			$data['rs'] = $this->board->getBoard($query['board_num'], $user);
		}
		//var_dump($data['rs']['save']);

		print json_encode($data);
	}

	/**
	 * 댓글 좋아요 처리 함수 
	 */
	public function like_r()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		$post = $this->input->post();
		$mode = $post['mode'];
		$user = $this->sess->get_id();

		$query = [
			'user'      => $user,
			'reply_num' => $post['reply_num']
		];	

		if($mode == "good") { // 좋아요 처리 
			$query['good'] = 1;

		} else if($mode == "poor") {// 싫어요 처리
			$query['poor'] = 1;
		}

		//좋아요, 싫어요 처리 
		$rs = $this->reply->insertLike($query);

		if(!$rs) { // 실패 
 			$data['code'] = 0;
			$data['msg'] =  "ajax like 통신 오류";

		} else { // 성공 
			$data['code'] = 1;
			$data['rs'] = $this->reply->getReply($post['board_num'], $user);
		}

		print json_encode($data);	
	}	

	/**
	 * 게시물에 대한 댓글 작성 함수 
	 */
	public function reply_write()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		//로그인 확인 되면 유저 데이터 및 폼데이터 가져온다.
		$user =$this->sess->get_id();
		$post = $this->input->post();

		//댓글 좋아요 입력하기 위해 필요한 것.
		//유저, 댓글번호, 좋아요 싫어요
		$query = [
			'user' => $user,
			'contents' => $post['contents'],
			'board_num' => $post['board_num']
		];

		if(isset($post['reply_group']) && isset($post['parent_num'])) { // 대댓글인 경우 
			$query['reply_group'] = $post['reply_group'];
			$query['parent_num']  = $post['parent_num'];
			$rs = $this->reply->insertReply($query);	

		} else { // 일반 댓글인 경우 
			$rs = $this->reply->insertReply($query, "reply");	
		}

		if(!$rs) { // 작업 실패 
			$data['code'] = 0;
			$data['msg'] = "댓글 작성에 실패하였습니다";

		} else { // 성공 
			$data['code'] = 1;
			$data['msg'] = "댓글이 작성되었습니다";
			$data['rs'] = $this->reply->getReply($query['board_num'], $user);
		}				

		print json_encode($data);			
	}

	/**
	 * 게시물에 대한 댓글 지우기 함수 
	 */
	public function reply_delete()
	{				
		$this->ajaxPerm();	
		$this->checkForm();

		$post = $this->input->post();

		//로그인 되어있는 상태에서만 작동됨.
		$user =$this->sess->get_id();

		//댓글 좋아요 입력하기 위해 필요한 것.
		//유저, 댓글번호, 좋아요 싫어요

		// 댓글 정보 확인 
		$query = [
			'board_num' => $post['board_num'],
			'reply_num' => $post['reply_num'],
			'user'      => $user	
		];	

		// 댓글 삭제 
		$rs = $this->reply->deleteReply($query);	

		if(!$rs) { // 삭제 실패
			$data['code'] = 0;
			$data['msg'] = "댓글 삭제에 실패하였습니다";
		
		} else { // 삭제 성공 
			$data['code'] = 1;
			$data['msg'] = "댓글이 삭제되었습니다";
			$data['rs'] = $this->reply->getReply($query['board_num'], $user);
		}		

		print json_encode($data);
	}

	/**
	 * 회원 인증 함수 
	 */
	public function check_perm()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		// 현재 로그인 사용자 id
		$user_id = $this->sess->get_id(); 
		
		// form data 
		$pw = $this->input->post('pw');

		// 사용자 확인 쿼리 추가
    	$rs = $this->user->checkPerm($user_id, $pw);

    	if($rs) { // 회원 확인 성공 
			$data['code'] = 1;
			$data['msg'] = "회원 인증에 성공하였습니다";

		} else { // 확인 실패 
			$data['code'] = 0;
			$data['msg'] = "회원 인증에 실패하였습니다";
		}

		print json_encode($data);
	}

	/**
	 * 사용자 수정 함수 
	 */
	public function update_user()
	{
		//post로 폼데이터 전체 옴.
		$this->ajaxPerm();	
		$this->checkForm();
		
		//세션 유효 확인
		$user = $this->sess->get_sess();
		$form = $this->input->post();

		// 패스워드 수정하지 않는 경우 배열에서 제외
		if(empty($form['tpw'])) {    		
    		unset($form['tpw']);
    	} 

		// 주소 변경 없을 시 배열에서 제외 
    	if(empty($form["addr_api"])) {    		
    		unset($form['addr_api']);
    	}

		// 폼데이터 쿼리 배열화
    	$form = $this->comp->user($form);

    	//upload 함수에 성공하면 업로드 된 파일명 반환된다
    	$url = "./img/users/".$form['id']."/profile/";
    	$do_upload = $this->upfile->do_upload('img_file', $url);

    	if($do_upload) { // 파일 업로드 성공시 데이터 넣어주기
    		$form['img'] = $do_upload;
    	}

		// 해당 사용자의 정보 update
    	$where = ['id' => $form['id']];	
    	$rs = $this->user->update($where, $form);

    	if(!$rs) { // 수정 실패시 
    		$data['code'] = 0;
    		$data['msg'] = "정보를 수정하세요 ";

    	} else{ // 수정 성공시 

    		$data['user'] = $this->user->getUser($form['id']); 

    		if($user['id'] == $form['id']) { 
    			$this->session->set_userdata($data);    			
    		}

    		$data['code'] = 1;
    		$data['msg'] = "회원 정보를 성공적으로 수정하였습니다";			
    	}

    	print json_encode($data);
	}

	/**
	 * 회원정보 삭제하는 함수
	 */
	public function delete_user()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		$form = $this->input->post();
		$rs = $this->user->delete($form);
		
		if(!$rs) { // 삭제 실패 
			$data['code'] = 1;
			$data['msg'] = "정상적으로 탈퇴처리 되었습니다";

		} else { // 삭제 성공  
			$data['code'] = 0;
			$data['msg'] = "탈퇴에 실패하였습니다";
 	  	}

		print json_encode($data);
	}

	/**
	 * 게시물 CRUD 함수 
	 */
	public function ctrl_board()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		//mode와 page 들어옴 (mode : blind 또는 delete, page : 블라인드 또는 삭제할 페이지 배열)

		$id = $this->sess->get_id();
		$page = $this->input->post('page');
		$mode = $this->input->post('mode');

		if($mode == "delete") { // 게시물 삭제 모드 
			if($page === null) { 
				$data['code'] = 0;
			    $data['msg'] = "삭제할 게시물을 선택하세요";

			} else { // 게시물 확인 된 경우 
				// 게시물 삭제 
				$rs = $this->board->deletes($page);   

				if(!$rs) { // 삭제 실패 
					$data['code'] = 0;
				    $data['msg'] = "게시물 삭제에 실패하였습니다";

				} else { // 삭제 성공
					$data['code'] = 1;
				    $data['msg'] = "게시물이 성공적으로 삭제되었습니다";
				}
			}
   		}

		if($mode == "blind") { // 블라인드 처리 모드 

			// 블라인드 처리 
			$query = ['perm' => '블라인드'];
			$rs = $this->board->updates($page, $query, "blind");

			if(!$rs) { // 블라인드 처리 실패 
				$data['code'] = 0;
			    $data['msg'] = "블라인드 처리에 실패하였습니다".$this->db->last_query();

			} else { // 블라인드 처리 성공 
				$data['code'] = 1;
			    $data['msg'] = "블라인드 처리가 완료되었습니다";
			}
		}

		print json_encode($data);	
	}

	/**
	 * 메인 페이지 대문 문구 변경 함수 
	 */
	public function intro_write()
	{
		$this->ajaxPerm();	
		$this->checkForm();
		$user = $this->sess->get_sess();

		// 내용 
		$area = $this->input->post("contents");

		// 업데이트 내용 
		$query = [
			'user' => $user['id'],
			'perm' => $user['perm'],
			'contents' => $area
		];

		// insert of update
		$rs = $this->board->setIntroBoard($query);

		if($rs) { // 작성 성공시 
			$data['code'] = 1;
			$data['msg'] = "대문이 작성되었습니다";
		
		} else { // 작성 실패시 
			$data['code'] = 0;
			$data['msg'] = "대문 작성에 실패하였습니다";
		}

		print json_encode($data);
	}

	/**
	 * 학급 생성 함수 
	 */
	public function create_class()
	{
		$this->ajaxPerm();

		$form = $this->input->post();

		// create
		$rs = $this->class->insert($form['arr']);

		if($rs) { // 학급 생성 성공시  
			$data['code'] = 1;
			$data['msg'] = "학급이 생성되었습니다";

		} else { // 학급 생성 실패시 
			$data['code'] = 0;
			$data['msg'] = "학급 생성에 실패하였습니다.";

		}
		print json_encode($data);
	}

	/**
	 * 학급 정보 수정
	 */
	public function update_class()
	{
		$this->ajaxPerm();
		$form = $this->input->post();

		$code = 0;
		$cnt = count($form['arr']);

		// 학급 별 수정 
		foreach($form['arr'] as $row)
		{
			// update class
			$rs = $this->class->update($row['where'], $row['query']);

			if(!$rs) { // 수정 실패시 
				$code ++;
			}
		}
	
		if($code < $cnt) { 
			$data['code'] = 1;
			$data['msg'] = "학급 정보가 수정되었습니다";

		} else { // 전부 실패시 
			$data['code'] = 0;
			$data['msg'] = "학급 정보를 수정하세요";
		}

		print json_encode($data);
	}

	/**
	 * 학급 삭제 함수 
	 */
	public function delete_class()
	{
		$this->ajaxPerm();
		$form = $this->input->post();

		$code = 0;
		$cnt = count($form['arr']);

		// 학급 별 삭제 
		foreach($form['arr'] as $row) 
		{
			// delete class 
			$rs = $this->class->delete($row);

			// 삭제 실패시 
			if(!$rs) {
				$code++;
			}
		}
	
		if($code < $cnt) { 
			$data['code'] = 1;
			$data['msg'] = "학급 정보가 삭제되었습니다";

		} else { // 전부 실패시 
			$data['code'] = 0;
			$data['msg'] = "학급 정보 삭제에 실패했습니다.";
		}

		print json_encode($data);
	}

	/**
	 * 아동 정보 수정 함수 
	 */
	public function update_baby()
	{
		$this->ajaxPerm();
		$form = $this->input->post();

		$code = 0;
		//var_dump($form);
		$cnt = count($form['arr']);

		// 아동별로 수정 
		foreach($form['arr'] as $row)
		{
			// update
			$rs = $this->baby->update($row['where'], $row['query']);
			
			if(!$rs) { // 수정 실패시 
				$code ++;
			}
		}

		if($code < $cnt) { 
			$data['code'] = 1;
			$data['msg'] = "아동 정보가 수정되었습니다";
		} else { // 전부 실패시 
 			$data['code'] = 0;
			$data['msg'] = "아동 정보를 수정하세요.";
		}
		print json_encode($data);
	}	

	/**
	 * 아동 삭제 함수 
	 */
	public function delete_baby()
	{
		$this->ajaxPerm();
		$form = $this->input->post();
		$code = 0;
		$cnt = count($form['arr']);

		//학급정보 하나씩 읽기.
		if(isset($form['arr'])) {
			foreach($form['arr'] as $row)
			{
				// delete
				$rs = $this->baby->delete($row);
			
				if(!$rs) { // 삭제 실패시 
					$code ++;
				}
			}

		} else { // ????
			$rs = $this->baby->delete($form['arr']);
			
			if(!$rs) {
				$code = 'one';
			}
		}		
		
		if($code > $cnt || $code = 'one') {
			$data['code'] = 1;
			$data['msg'] = "아동 정보가 삭제되었습니다";				
		
		} else { 
			$data['code'] = 0;
			$data['msg'] = "아동 정보 삭제에 실패했습니다.";					
		}

		print json_encode($data);
	}

	/**
	 * 폼 체크 함수 
	 * @return void
	 */
    public function checkForm()
	{
		$post = $this->input->post();

		// 올바르지 않은 폼 
		if(empty($post)) {
			$result['code'] = -1;
			$result['msg'] = "폼데이터 오류";			
			print json_encode($result);//없음...
			exit;
		}				
		return;
	}

	/**
	 * Ajax 접근시 권한 확인 함수 
	 * @param int $mode 접근 권한모드 숫자값 
	 * @return void
	 */
	function ajaxPerm($mode=0)
	{
		if($this->sess->get_id() == "") { // 권한 없음 
			$rs['code'] = -1;
			$rs['msg'] = "로그인이 필요합니다";			
			print json_encode($rs);//없음...
			exit;
		}

		// 데이터 가져오기 
		$user = $this->sess->get_sess();
		$perm = $user['perm'];

		// 권한별 
		if($mode === 100) { // 관리자만 접근 가능 

			if($perm != "관리자") { // 권한 없음
				$rs['code'] = -1;
				$rs['msg'] = "권한이 없습니다";			
				print json_encode($rs);//없음...
				exit;	
			}

		} else if($mode === 99) { // 부관리자까지 접근 가능 

			if($perm != "관리자" && $perm != "부관리자") { // 권한 없음 
				$rs['code'] = -1;
				$rs['msg'] = "권한이 없습니다";			
				print json_encode($rs);//없음...
				exit;	
			}
		}
		
		return ;
	}

	/**
	 * 게시물 삭제 함수 
	 */
	public function delete_board()
	{
		$this->ajaxPerm();	
		$this->checkForm();
		$page = $this->input->post('page');
		$rs = $this->board->delete($page);
		
		if(!$rs) { // 삭제 실패시 
			$data['code'] = 0;
			$data['msg'] = "게시물 삭제에 실패하였습니다"; 

		} else { // 삭제 성공시 
			$data['code'] = 1;
			$data['msg'] = "게시물이 삭제되었습니다";
		}

		print json_encode($data);
	}

	/**
	 * 학급방 게시판 글쓰기 함수  
	 */
	public function insert_class_board()
	{
		$form = $this->input->post();		

		// insert 
		$rs = $this->class->insertBoard($form);

		if($rs) { // 작성 성공시 
			$data['msg'] = "게시물이 작성되었습니다";
			$data['code'] = 1;

		} else { // 작성 실패시 
			$data['msg'] = "게시물이 작성에 실패하였습니다";
			$data['code'] = 0;
		}

		print json_encode($data);
	}

	/**
	 * 학급방 게시물 삭제 함수 
	 */
	public function delete_class_board()
	{
		$form = $this->input->post();

		// delete
		$rs = $this->class->deleteBoard($form);

		if($rs) { // 삭제 성공시 
			$data['msg'] = "게시물이 삭제되었습니다";
			$data['code'] = 1;

		} else { // 삭제 실패시 
			$data['msg'] = "게시물 삭제에 실패하였습니다";
			$data['code'] = 0;
		}

		print json_encode($data);
	}

	/**
	 * 학급방 내 알림 작성 함수 
	 * @param string $mode 알림 작성모드 ("baby"인 경우 아동의 학부모에게 알림 개별 전달, ""인 경우 전체 알림장 등록)
	 */
	public function insert_class_notice($mode = "")
	{
		$form = $this->input->post();

		// insert
		$rs = $this->msg->insertClassNotice($form);

		if($rs) { // 작성 성공시 
			$data['msg'] = $mode == "baby" ? "전달되었습니다" : "알림장이 등록되었습니다";
			$data['code'] = 1;

		} else { // 작성 실패시 
			$data['msg'] = $mode == "baby" ? "전달에 실패하였습니다" : "알림장 등록에 실패하였습니다";
			$data['code'] = 0;
		}

		print json_encode($data);
	}

	/**
	 * 학급방 내 소개글 작성 및 수정 함수 
	 */
	public function insert_class_comment()
	{
		$form = $this->input->post();

		// insert or update
		$rs = $this->class->insertComment($form);

		if($rs) { // 작성 성공시
			$data['msg'] = "학급 소개글이 작성되었습니다";
			$data['code'] = 1;

		} else { // 작성 실패시 
			$data['msg'] = "학급 소개글 작성에 실패하였습니다";
			$data['code'] = 0;
		}

		print json_encode($data);
	}



	
}
	