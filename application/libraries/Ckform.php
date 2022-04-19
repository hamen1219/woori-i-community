 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

//페이지네이션 라이브러리
class Ckform
{
	//CI $this 기능 담을 변수
	protected $CI;

	//생성자 메서드
	public function __construct()
	{		
		//$this->CI : $this
		$this->CI = & get_instance();
	}

	public function post()
	{
		$post = $this->CI->input->post();
		if($post === null)
		{
			$result['code'] = -1;
			$result['msg'] = "폼데이터 오류";			
			print json_encode($rs);//없음...\
			exit;
		}
	}
}