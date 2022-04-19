 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

//세션 라이브러리
class Sess
{
	protected $CI; 

	public function __construct() //라이브러리 로드시 사용될 데이터
	{		
		$this->CI = & get_instance(); //생성자 실행시 ci의 this 객체 얻어오기.
	}

	
	/*****************************************
	  get_id : 현재 로그인 된 사용자의 id (없으면 0)
	*****************************************/
	public function get_id()
	{
		//사용자 정보 없으면 0 반환
		if($this->CI->session->has_userdata('user') === false)
		{	
			return 0;
		}	

		//로그인 세션 값이 있다면 아이디 반환
		else
		{
			$user = $this->CI->session->userdata('user')['id'];
			return $user;
		}
	}	

	/*****************************************
	  get_sess : 현재 로그인 된 사용자의 정보 (없으면 0)
	*****************************************/
	public function get_sess()
	{
		//사용자 정보 없으면 0 반환
		if($this->CI->session->has_userdata('user') === false)
		{	
			return 0;
		}

		//로그인 세션 값이 있다면 아이디 반환
		else
		{
			$user = $this->CI->session->userdata('user');
			return $user;
		}
	}

	/*****************************************
	  get_access : 페이지 접근 제어 메서드 
	  * mode : 접근제어 방식
	  * url  : 이동될 url
	  * msg  : 알림창 메세지
	*****************************************/
	public function get_access($mode='', $url='', $msg = '')
	{
		//현재 로그인 한 사용자
		$rs = $this->get_sess();

		//비로그인 사용자 접근시
		if($mode === 0) 
		{
			if($rs) return;
			$msg = "로그인이 필요합니다";
		}
		//로그인 사용자 접근시
		else if($mode === 1)
		{
			if(!$rs) return;
			$msg = "로그아웃이 필요합니다";
		}
		//가입대기 사용자 접근시		
		else if($mode === -1)
		{
			if($rs['perm'] != "가입대기") return;
			$msg = "권한이 부족합니다";
		}
		//관리자, 부관리자 외 접근시
		else if($mode === 99)
		{
			if($rs['perm'] == "관리자" || $rs['perm'] == "부관리자") return;
			$msg = "임원진만 접근 가능합니다";
		}
		//관리자 외 접근시
		else if($mode === 100)
		{
			if($rs['perm'] == "관리자") return;
			$msg = "최종 관리자만 접근 가능합니다";
		}

		//사용자 지정 msg 있을 경우
		if($msg != "")
		{
			print "<script>alert('".$msg."');</script>";	
		}

		//close : 새 창 닫을 때 사용 (메세지함 등..)
		if($url == "close")
		{
			print "<script> window.open('','_self').close();</script>";
		}
		//이외 사용자 지정 url 있을 경우
		else if($url != '') 
		{
			print "<script>location.href = '".$url."';</script>";	
		} 
		else
		{
			print "<script>history.back();</script>";							
		}				
		exit;
	}

	//로그아웃 메서드
	public function logout()
	{
		$this->CI->session->sess_destroy();
		redirect('/main');
	}	

	//==================================================================================

	/*
		== get_perm 함수 ==
		mode : admin, dept, perm, my (관리자인지, 동부서인지, 권한되는지, 내권한인지)
		url : redirect 주소
		msg : alert 메세지
	*/

	//게시물 관련하여 세션 확인
	public function get_perm($mode, $where, $url, $msg='') 
	{
		//mode 에는 perm,dept,my 있다. where은 조건문이 아닌 하나의 데이터
		if ($this->session->has_userdata('user') === false)
		{
			$this->get_access(0, '/main'); //로그인부터 확인
			return;
		}
		//else라면
		$user = $this->session->userdata('user');
		if($mode == 'admin') //관리자 외 출입금지
		{
			if($user['perm'] != 100 ) $str = "관리자만 접근 가능합니다";
		}
		else if($mode == 'dept') //부서 외 출입금지
		{
			if($user['dept'] != $where)  $str = "같은 부서만 접근 가능합니다";
		}
		else if($mode == 'perm') //등급 외 출입금지
		{
			if($user['perm'] != $where)  $str = "권한이 부족합니다";
		}
		else if($mode == 'my') //내 게시물 접근
		{
			if($user['id'] != $where)  $str = "작성자만 접근 가능합니다";
		}
		else{
			$str = "알수없음";
		}
		print "<script>alert(".$str.")</script>";
	}
}
