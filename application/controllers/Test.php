<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); //오버라이드 
		$this->load->model('user_m', 'user',TRUE);
		$this->load->library('result','TRUE');
	}

	public function company()
	{
		$this->load->view('/test/company.php');
	}
	public function intro()
	{
		$this->load->view('/test/intro_dev.php');
	}
	public function lang()
	{
		$this->load->view('/test/language.php');
	}

	//게시물 관련
	public function list()
	{
		$this->load->view('/test/list.html');
	}

	public function write()
	{
		$this->load->view('/test/crud/write');
	}

	public function update()
	{
		$this->load->view('/test/crud/update');
	}

	//메인게임 페이지
	public function game()
	{
		$this->load->view('/test/game.html');
	}


}
