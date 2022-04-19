<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
 //초기화가 필요없음. class 아니므로

//js로 alert 생성, 이동을 도와주는 헬퍼
function alert($msg = '', $url = '')
{
	if($msg !== '') //알림 메세지 있다면
	{
		print "<script>alert('".$msg."');</script>";
	}
	if($url !== '') //경로 입력 되었을 때
	{
		print "<script>location.href = '/main/login';</script>";
	}
}
