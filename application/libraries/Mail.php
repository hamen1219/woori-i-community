 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

//페이지네이션 라이브러리
class Mail
{
	//CI $this 기능 담을 변수
	protected $CI;

	/*
		=== 이메일 보내는 함수 ===
		to       : 받는사람(arr or var)
		title    : 이메일 제목
		contents ; 이메일 내용
	*/
	function sendEmail($to, $title, $contents)
	{	
		$from = "hamen1219@naver.com";	

		$header = "From: 우리아이 커뮤니티 <". $from .">\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html;";
		
		$contents = str_replace('/img/email', 'https://hung1219.cafe24.com/img/email', $contents);

		//$contents = str_replace('/img/', 'http://hung1219.cafe24.com/img/', $contents);

		//복수의 사용자에게 이메일 전송
		if(is_array($to))
		{
			foreach($to as $val)
			{
				$rs = mail($val, $title, $contents, $header, $from);
			}
		}	

		//한명의 사용자에게 이메일 전송
		else
		{
			$rs = mail($to, $title, $contents, $header, $from);
		}		
		//메일 전송 결과를 보낸다!
		return $rs;
	
	}

	
}
