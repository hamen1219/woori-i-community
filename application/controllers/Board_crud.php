<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_crud extends CI_Controller {

	//읽기, 쓰기, 수정, 삭제하기 기능.
	public function __construcct()
	{
		parent::__construct();
		$this->load->model('board_m', 'board', TRUE); //게시물 정보
		$this->load->model('user_m', 'user', TRUE);  //유저 정보

		//생성자에서 전역변수 지정하면 안된다.
	}
	
	public function _remap($method) //순서 제어
	{	
		$this->load->model('board_m', 'board', TRUE); //게시물 정보
		$this->load->model('user_m', 'user', TRUE);  //유저 정보
		$this->load->model('message_m', 'msg', TRUE);  //유저 정보
		$this->load->library('paging');
		$this->load->library('comp');
		$this->load->library('upfile');

		if(method_exists($this, $method)) 
		{
			//입력한 주소값에 해당하는 메서드 있다면?
			$this->$method($this->uri->segment(3));		
		}
		else
		{
			$this->sess->get_access('alert', '', '올바르지 않은 경로입니다');
		}
		
	}

	public function get_page()
	{
		$arr = explode('/',$this->uri->uri_string());	
		$cnt = count($arr);	

		for($i=0; $i<$cnt; $i++)
		{
			//페이지 세그먼트 찾기
			if($arr[$i] == "page")
			{
				$page =  $arr[$i+1];
			}			
		}
		if(!isset($page)) 
		{
			$page = 0;
		}
		return $page;
	}


	//게시물 CRUD
	public function write()
	{
		//폼데이터
		$form= $this->input->post(); 	
		$form['user'] = $this->sess->get_id();		

		$url = "./temp/file/";
		$form = $this->comp->board($form);

		//file명에 해당하는 file 찾아보기
		if($this->upfile->do_upload('file', $url))
		{
			$form['file'] = $this->upfile->do_upload('file', $url);
		}
		//var_dump($form);


		//글 작성 함수 (등록된 페이지 번호 또는 0을 반환)
		$rs = $this->board->write($form); //글정보 board 모델에 전달.

		if($rs)
		{

			$this->sess->get_access('alert', '/board/read/page/'.$rs, '게시물이 작성되었습니다');
		}
		else
		{
			//var_dump($this->db->last_query());
			//exit;
			$this->load->view('homepage/alert/error');
		}
	}

	public function update()
	{
		$form = $this->input->post(); //게시물 입력 정보

		$page = $this->paging->get_segment('page');
		if(!$page)
		{
			$data['msg'] = "유효하지 않은 페이지 번호";
			$this->load->view('homepage/alert/error', $data);
		}
		else
		{
			//파일 첨부 x 시
			if(isset($form['ck_file']) && $form['ck_file'] == "삭제")
			{
				$form['file'] = "";
			}			
		
			else
			{
				$url = "./temp/file/";
				//파일 업로드 진행.
				if($this->upfile->do_upload('file',$url))
				{					
					$form['file'] = $this->upfile->do_upload('file',$url);
				}				
				//파일업로드 된 것이 없으면 업데이트 x
			}

			$form = $this->comp->board($form);	

			$rs = $this->board->update($page, $form); //글정보 board 모델에 전달.
			
			if($rs)
			{
				$this->sess->get_access('alert', '/board/read/page/'.$page, '게시물이 수정되었습니다');
			}
			else
			{
				$this->sess->get_access('alert', '/board/read/page/'.$page, '게시물 내용을 수정하세요');
			}
		}		
	}

	public function delete($page)
	{
		$page = $this->get_page();

		$rs = $this->board->delete($page); //글정보 board 모델에 전달.

		if($rs)
		{
			$this->load->view('homepage/alert/success');
		}
		else
		{
			$this->load->view('homepage/alert/error');
		}		
	}

	//////////////////////////////////////////////////////
	/*
		=== 파일 업로드 함수 ===
		mode = ""    : 일반 게시물 업로드 사진의 경우
 		mode = email : 이메일 업로드 사진일 경우
	*/
	public function upload($mode = "")
	{	
		if($mode == "")
		{
			$url = './img/temp/';
		}
		else if($mode == "email")
		{
			$url = './img/email/';
		}
		$this->load->model('board_m', 'board', TRUE);
		$this->upfile->ck_upload($url); //실행됨.
	}        
}
