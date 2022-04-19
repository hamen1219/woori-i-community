 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

//페이지네이션 라이브러리
class Userip
{
	//CI $this 기능 담을 변수
	protected $CI;


	//생성자 메서드
	public function __construct()
	{		
		//$this->CI : $this
		$this->CI = & get_instance();
		$this->CI->load->database('test');
	}


	//기본
	public function a()
	{
		return "Aa";
	}
}