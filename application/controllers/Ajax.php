<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjAX extends CI_Controller {	
	//AJAX 통신 담당하는 컨트롤러
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

	public function sendEmail()
	{		
		$this->load->library('mail');

		//이메일 보낼 명단 배열
		$form = $this->input->post();
		//var_dump($form); exit;

		//mode, arr
		//arr : arr, title, contents
		
		$to = $form['arr']['arr'];
		$title = $form['arr']['title'];
		$contents = $form['arr']['contents'];
		$rs = $this->mail->sendEmail($to, $title, $contents);

		if($rs) 
		{
			$data['code'] = 1;
			$data['msg'] = "이메일이 전송되었습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "이메일 전송에 실패하였습니다";	
		}		
		print json_encode($data);		
	}

	public function get_ajax($mode)
	{
		//var_dump($mode); exit;

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

			if(!$rs) //사용중
			{
				$data["msg"] = "사용중인 아이디입니다";
				$data["code"] = -1;
			}
			else
			{
				//파일 업로드 시도 (실패해도 메세지 
				$url = "./img/users/".$id."/profile/";
				$do_upload = $this->upfile->do_upload("img_file", $url);
				$form['img'] = $do_upload; 				
			}	

			//사용자 정보 쿼리 배열화
			$form = $this->comp->user($form);
			$rs   = $this->user->joinUser($form);

			if(!$rs)
			{
				$data["msg"] = "회원가입에 실패하였습니다";
				$data["code"] = 0;
			}
			else
			{
				$title = $id."님 가입을 축하드립니다";
				$contents =  "<img src = 'http://hung1219.cafe24.com/img/email/1.PNG'>";
				$contents .= "<h2>".$id."님의 커뮤니티 가입을 축하드립니다 :)</h2><hr/>";
				$contents .= "<p>이제부터 회원들과 다양한 소통을 하실 수 있습니다.</p>";
				$contents .= "<p>자유로운 소통, 정모, 자기소개 등 다양한 커뮤니티에 참여해주시길 바랍니다</p>";
				$contents .= "<p>또한 이데아커뮤니티의 다양한 소식을 받아보실 수 있습니다.</p><br/>";
				$contents .= "<p><b>다시 한번 ".$id."님의 회원가입을 축하드립니다.</b></p><br/><hr/>";
				$contents .= "<p>- 이데아커뮤니티 대표 안형모</p>";
				$this->mail->sendEmail($form['email'], $title, $contents);

				$data["msg"] = "회원가입에 성공하였습니다";
				$data["code"] = 1;
				//방금 가입된 사용자 아이디에 해당하는 유저 정보를 찾아 세션 flash에 저장

				
				
				$rs = $this->user->getUser($id);
				$this->session->set_flashdata($rs);

				if($rs['name'] == "김재훈")
				{
					$data["code"] = -1;
					$data["msg"] = "재훈아 왔냐?";
				}
			}			
		}
		print json_encode($data);
	}

	//AJAX로 게시판 정보 반환. (게시판 위치 - 메인페이지)
	public function mini_board()
	{
		//$this->ajaxPerm();	
		//$this->checkForm();

		$mode = $this->input->post('board');
	
		$rs = $this->board->getAjaxBoard($mode);		

		$data = $this->get_html($rs);

		//ajax 반환
		print $data;
	}

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

	//유저 perm 바꾸기
	public function ctrl_user()
	{
		$this->ajaxPerm(99);	
		$this->checkForm();

		$arr = $this->input->post("arr");
		$mode =$this->input->post("mode");	
		
		$code = 0;	

		//var_dump($this->input->post());

		//var_dump($arr);

		//update 시
		if($mode != "delete")
		{
			//업데이트 종류에 따라 쿼리 변경 후 foreach로 업데이트 실행

			foreach($arr as $val)
			{
				$where = ['id' => $val['id']];
				$query = ['perm' =>$val['perm']];
				$rs = $this->user->update($where, $query);
				if(!$rs)
				{
					$code ++;
				}
			}
			//code 값 완성
		}

		//delete 시
		else
		{
			//선택된 유저만큼 삭제 실행
			foreach($arr as $val)
			{
				$where = ['id' => $val];
				$rs = $this->user->delete($where);
				if(!$rs)
				{
					$code ++;				
				}
			}
		}

		//삭제 또는 수정 실행 됨.

		//삭제 또는 수정 실패시
		if($code < count($arr))
		{
			if($mode == "delete")
			{
				$data['code'] = 1;
				$data['msg'] = "사용자 삭제에 성공하였습니다"; 
			}
			else
			{
				$data['code'] = 1;
				$data['msg'] = "사용자 수정에 성공하였습니다"; 
			}
		}
		else
		{
			if($mode == "delete")
			{
				$data['code'] = 0;
				$data['msg'] = "삭제할 사용자를 선택하세요"; 
			}
			else
			{
				$data['code'] = 0;
				$data['msg'] = "수정할 사용자를 선택하세요"; 
			}
		}		

		//var_dump($data); exit;

		print json_encode($data);
	}


	//게시물 좋아요
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

		if($mode == "good")
		{
			$from = "like_b";
			$query['good'] = 1;
		}
		else if($mode == "poor")
		{
			$from = "like_b";
			$query['poor'] = 1;
		}
		else if ($mode == "save")
		{
			$from = "save_b";
			$query['save'] = 1;
		}

		//중복된 좋아요 또는 싫어요
		if(!$this->board->insertLike($from, $query))
		{
			$data['code'] = 0;
			$data['msg'] = "board like error";
		}
		
		//좋아요 성공
		else
		{
			$data['code'] = 1;
			$data['rs'] = $this->board->getBoard($query['board_num'], $user);
			//var_dump($this->board->getBoard($query['board_num'], $user)); 
			//var_dump($this->db->last_query()); 
		}
		//var_dump($data['rs']['save']);

		print json_encode($data);
	}

	/*******************************
		댓글 좋아요 Ajax
	*******************************/
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
		if($mode == "good")
		{
			$query['good'] = 1;
		}
		else if($mode == "poor")
		{
			$query['poor'] = 1;
		}

		//좋아요, 싫어요, 찜하기 눌
		$rs = $this->reply->insertLike($query);

		if(!$rs)
		{
			$data['code'] = 0;
			$data['msg'] =  "ajax like 통신 오류";
		}
		else
		{
			$data['code'] = 1;
			$data['rs'] = $this->reply->getReply($post['board_num'], $user);
		}
		//var_dump($data); exit;

		print json_encode($data);	

	}	

	/*******************************
		댓글 쓰기 Ajax
	*******************************/
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

		//대댓글일때
		if(isset($post['reply_group']) && isset($post['parent_num']))
		{
			$query['reply_group'] = $post['reply_group'];
			$query['parent_num']  = $post['parent_num'];
			$rs = $this->reply->insertReply($query);	
		}
		//일반 댓글일때
		else
		{
			$rs = $this->reply->insertReply($query, "reply");	
		}

		//insert 에 실패하여 rs를 도출하지 못한다면
		if(!$rs)
		{
			$data['code'] = 0;
			$data['msg'] = "댓글 작성에 실패하였습니다";
		}		
		else
		{
			$data['code'] = 1;
			$data['msg'] = "댓글이 작성되었습니다";
			$data['rs'] = $this->reply->getReply($query['board_num'], $user);
		}							
		print json_encode($data);			
	}

	/*******************************
		댓글 지우기 Ajax
	*******************************/
	public function reply_delete()
	{
				
		$this->ajaxPerm();	
		$this->checkForm();

		$post = $this->input->post();
		//로그인 되어있는 상태에서만 작동됨.
		$user =$this->sess->get_id();

		//댓글 좋아요 입력하기 위해 필요한 것.
		//유저, 댓글번호, 좋아요 싫어요

		$query = [
			'board_num' => $post['board_num'],
			'reply_num' => $post['reply_num'],
			'user'      => $user	
		];	

		//rs : rs, num 또는 error
		$rs = $this->reply->deleteReply($query);	

		if(!$rs)
		{
			$data['code'] = 0;
			$data['msg'] = "댓글 삭제에 실패하였습니다";
		}
		else
		{
			$data['code'] = 1;
			$data['msg'] = "댓글이 삭제되었습니다";
			$data['rs'] = $this->reply->getReply($query['board_num'], $user);
		}		
		print json_encode($data);
	}


	/*******************************
		유저 권한 확인, 수정 및 탈퇴
	*******************************/
	public function check_perm()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		$id = $this->sess->get_id(); 
		
		// form data 
		$form = $this->input->post();

		// 사용자 확인 쿼리 추가
    	$rs = $this->user->checkPerm($form['id'], $form['pw']);

    	if($rs)
    	{
			$data['code'] = 1;
			$data['msg'] = "회원 인증에 성공하였습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "회원 인증에 실패하였습니다";
		}
		print json_encode($data);
	}

	public function update_user()
	{
		//post로 폼데이터 전체 옴.
		$this->ajaxPerm();	
		$this->checkForm();
		//세션 유효 확인
		$user = $this->sess->get_sess();
		$form = $this->input->post();

		//패스워드 수정을 입력하지 않은 경우 pw 수정 x
		if($form['tpw'] == "")
    	{    		
    		unset($form['tpw']);
    	}
    	if($form["addr_api"] == "")
    	{    		
    		unset($form['addr_api']);
    	}

		// 폼데이터 쿼리 배열화
    	$form = $this->comp->user($form);

    	//upload 함수에 성공하면 업로드 된 파일명 반환된다
    	$url = "./img/users/".$form['id']."/profile/";
    	$do_upload = $this->upfile->do_upload('img_file', $url);
    	if($do_upload)
    	{
    		$form['img'] = $do_upload;
    	}
    	$where = ['id' => $form['id']];	
    	$rs = $this->user->update($where, $form);

    	
    	if(!$rs)
    	{    		

    		$data['code'] = 0;
    		$data['msg'] = "정보를 수정하세요 ";
    	}
    	else
    	{
    		//var_dump($this->db->last_query()); exit;
    		//로그인 사용자 정보와 현재 마이페이지 사용자가 같지 않을 경우 세션 셋팅 x
    		

    		$data['user'] = $this->user->getUser($form['id']); 
    		if($user['id'] == $form['id'])
    		{
    			$this->session->set_userdata($data);    			
    		}

    		$data['code'] = 1;
    		$data['msg'] = "회원 정보를 성공적으로 수정하였습니다";			
    	}
    	print json_encode($data);
	}

	public function delete_user()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		$form = $this->input->post();

		$rs = $this->user->delete($form);
		if(!$rs)
		{
			$data['code'] = 1;
			$data['msg'] = "정상적으로 탈퇴처리 되었습니다";
		}
		else
		{			
			$data['code'] = 0;
			$data['msg'] = "탈퇴에 실패하였습니다";
 	  	}
		print json_encode($result);
	}

	//게시물 관리
	public function ctrl_board()
	{
		$this->ajaxPerm();	
		$this->checkForm();

		//mode와 page 들어옴 (mode : blind 또는 delete, page : 블라인드 또는 삭제할 페이지 배열)

		$id = $this->sess->get_id();
		$page = $this->input->post('page');
		$mode = $this->input->post('mode');


		if($mode == "delete")
		{
			if($page === null)
			{
				$data['code'] = 0;
			    $data['msg'] = "삭제할 게시물을 선택하세요";

			}
			else
			{
				$rs = $this->board->deletes($page);   
				if(!$rs)
				{
					$data['code'] = 0;
				    $data['msg'] = "게시물 삭제에 실패하였습니다";
				}
				else
				{
					$data['code'] = 1;
				    $data['msg'] = "게시물이 성공적으로 삭제되었습니다";
				}

			}
		
			
   		}

		if($mode == "blind")
		{	 
			$query = ['perm' => '블라인드'];
			$rs = $this->board->updates($page, $query, "blind");

			if(!$rs)
			{
				$data['code'] = 0;
			    $data['msg'] = "블라인드 처리에 실패하였습니다".$this->db->last_query();
			}
			else
			{
				$data['code'] = 1;
			    $data['msg'] = "블라인드 처리가 완료되었습니다";
			}
		}
		print json_encode($data);	
	}

	public function intro_write()
	{
		$this->ajaxPerm();	
		$this->checkForm();
		$user = $this->sess->get_sess();

		$area = $this->input->post("contents");
		$query = [
			'user' => $user['id'],
			'perm' => $user['perm'],
			'contents' => $area
		];
		$rs = $this->board->setIntroBoard($query);
		if($rs)
		{
			$data['code'] = 1;
			$data['msg'] = "대문이 작성되었습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "대문 작성에 실패하였습니다";
		}
		print json_encode($data);
	}

	public function create_class()
	{
		$this->ajaxPerm();

		$form = $this->input->post();


		//class 생성은 단수이므로 foreach 미사용
		$rs = $this->class->insert($form['arr']);

		if($rs)
		{
			$data['code'] = 1;
			$data['msg'] = "학급이 생성되었습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "학급 생성에 실패하였습니다.";
			//var_dump($this->db->last_query());
		}
		print json_encode($data);
	}
/////////////
	public function update_class()
	{
		$this->ajaxPerm();
		$form = $this->input->post();

		$code = 0;
		$cnt = count($form['arr']);

		//학급정보(array) 하나씩 읽기.

		foreach($form['arr'] as $row)
		{
			$rs = $this->class->update($row['where'], $row['query']);
			if(!$rs)
			{
				$code ++;
			}
		}
	
		if($code < $cnt)
		{
			$data['code'] = 1;
			$data['msg'] = "학급 정보가 수정되었습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "학급 정보를 수정하세요";

			var_dump($this->db->last_query());
		}
		print json_encode($data);

	}

	public function delete_class()
	{
		$this->ajaxPerm();
		$form = $this->input->post();

		$code = 0;
		$cnt = count($form['arr']);

		//학급정보(array) 하나씩 읽기.
		foreach($form['arr'] as $row)
		{
			$rs = $this->class->delete($row);
			if(!$rs)
			{
				$code++;
			}
		}
	
		if($code < $cnt)
		{
			$data['code'] = 1;
			$data['msg'] = "학급 정보가 삭제되었습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "학급 정보 삭제에 실패했습니다.";
			var_dump($this->db->last_query());
		}
		print json_encode($data);
	}

	public function update_baby()
	{
		$this->ajaxPerm();
		$form = $this->input->post();

		$code = 0;
		//var_dump($form);
		$cnt = count($form['arr']);

		foreach($form['arr'] as $row)
		{
			$rs = $this->baby->update($row['where'], $row['query']);
			if(!$rs)
			{
				$code ++;
			}
		}

		if($code < $cnt)
		{
			$data['code'] = 1;
			$data['msg'] = "아동 정보가 수정되었습니다";
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "아동 정보를 수정하세요.";
			//var_dump($this->db->last_query());
		}
		print json_encode($data);
	}	

	public function delete_baby()
	{
		$this->ajaxPerm();
		$form = $this->input->post();
		$code = 0;
		$cnt = count($form['arr']);

		//학급정보(array) 하나씩 읽기.
		if(isset($form['arr']))
		{
			foreach($form['arr'] as $row)
			{
				$rs = $this->baby->delete($row);
				if(!$rs)
				{
					$code ++;
				}
			}
		}
		else
		{
			$rs = $this->baby->delete($form['arr']);
			if(!$rs)
			{
				$code = 'one';
			}
		}		
		
		if($code > $cnt || $code = 'one')
		{
			//var_dump($this->db->last_query());
			$data['code'] = 1;
			$data['msg'] = "아동 정보가 삭제되었습니다";				
		}
		else
		{
			$data['code'] = 0;
			$data['msg'] = "아동 정보 삭제에 실패했습니다.";					
		}
		print json_encode($data);
	}


    public function checkForm()
	{
		$post = $this->input->post();

		if($post === null)
		{
			$result['code'] = -1;
			$result['msg'] = "폼데이터 오류";			
			print json_encode($result);//없음...
			exit;
		}
		return ;
	}

	function ajaxPerm($mode = "")
	{
		if($this->sess->get_id() == "")
		{
			$rs['code'] = -1;
			$rs['msg'] = "로그인이 필요합니다";			
			print json_encode($rs);//없음...
			exit;
		}

		$user = $this->sess->get_sess();
		$perm = $user['perm'];


		if($mode === 100)
		{
			if($perm != "관리자")
			{
				$rs['code'] = -1;
				$rs['msg'] = "권한이 없습니다";			
				print json_encode($rs);//없음...
				exit;	
			}
		}
		else if($mode === 99)
		{
			if($perm != "관리자" && $perm != "부관리자")
			{
				$rs['code'] = -1;
				$rs['msg'] = "권한이 없습니다";			
				print json_encode($rs);//없음...
				exit;	
			}
		}
		
		return ;
	}

	public function delete_board()
	{
		$this->ajaxPerm();	
		$this->checkForm();
		$page = $this->input->post('page');
		$rs = $this->board->delete($page);
		if(!$rs)
		{
			$data['code'] = 0;
			$data['msg'] = "게시물 삭제에 실패하였습니다"; 
		}
		else
		{
			$data['code'] = 1;
			$data['msg'] = "게시물이 삭제되었습니다";
		}
		print json_encode($data);
	}

	public function insert_class_board()
	{
		$form = $this->input->post();		

		$rs = $this->class->insertBoard($form);

		if($rs)
		{
			$data['msg'] = "게시물이 작성되었습니다";
			$data['code'] = 1;
		}
		else
		{
			$data['msg'] = "게시물이 작성에 실패하였습니다";
			$data['code'] = 0;
		}
		print json_encode($data);
	}
	public function delete_class_board()
	{
		$form = $this->input->post();

		$rs = $this->class->deleteBoard($form);

		if($rs)
		{
			$data['msg'] = "게시물이 삭제되었습니다";
			$data['code'] = 1;
		}
		else
		{
			$data['msg'] = "게시물 삭제에 실패하였습니다";
			$data['code'] = 0;
		}
		print json_encode($data);

	}


	public function insert_class_notice($mode = "")
	{
		$form = $this->input->post();

		$rs = $this->msg->insertClassNotice($form);

		if($rs)
		{
			$data['msg'] = $mode == "baby" ? "전달되었습니다" : "알림장이 등록되었습니다";
			$data['code'] = 1;
		}
		else
		{
			$data['msg'] = $mode == "baby" ? "전달에 실패하였습니다" : "알림장 등록에 실패하였습니다";
			$data['code'] = 0;
		}
		print json_encode($data);

	}

	public function insert_class_comment()
	{
		$form = $this->input->post();

		$rs = $this->class->insertComment($form);

		if($rs)
		{
			$data['msg'] = "학급 소개글이 작성되었습니다";
			$data['code'] = 1;
		}
		else
		{
			$data['msg'] = "학급 소개글 작성에 실패하였습니다";
			$data['code'] = 0;
		}
		print json_encode($data);
	}



	
}
	