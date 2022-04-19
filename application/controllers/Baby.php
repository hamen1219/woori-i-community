<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	Main Controller : 메인 페이지를 비롯한 홈페이지의 각 페이지 이동을 담당.
*/
class Baby extends CI_Controller {	

	public function __construcct()   
	{
		//CI Controller 상속
		parent::__construct();		
		$this->sess->get_access(0);

	}

	public function _remap($method)
	{
		$this->load->model('user_m', 'user',TRUE);
		$this->load->model('baby_m', 'baby',TRUE);	
		$this->load->model('class_m', 'class',TRUE);	
		$this->load->library('upfile');

		

		//들어온 메서드 명
		$len = strlen($method); 
		$url = urldecode($this->uri->uri_string());
		$num = strpos($url, $method)+$len+1;
		$param = substr($url, $num);
		$url_arr = explode('/',$param);
		$cnt = count($url_arr);
		if(empty($url_arr[0])) $cnt = 0;	
	
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
				case 2:
					$this->$method($url_arr[0], $url_arr[1]);
					break;	

				default :
					$this->$method();
					break;
			}
		}
	}

	//아이 등록 새 창 열기
	public function add_baby()
	{
		$user = $this->sess->get_id();
		$data['baby'] = $this->baby->getBaby($user,1);
		$data['class'] = $this->class->getClass();
		$this->load->view('homepage/user/baby/add_baby', $data);
	}

	//아이 수정 새 창 열기
	public function update_baby($parent, $baby)
	{  
		//var_dump($name);
		$user = $this->sess->get_id();

		if($user != $parent)
		{
			$this->sess->get_access('alert', '', '해당 아동의 학부모가 아닙니다');
		}
		$data['baby'] = $this->baby->getBaby($parent,$baby);
		$data['class'] = $this->class->getClass();

		$this->load->view('homepage/user/baby/update_baby', $data);
	}

	//내 아이 등록하기
	public function insert()
	{
		$user = $this->sess->get_id();

		$form = $this->input->post();

		$query = [
			'name'  => $form['name'],
			'old'   => $form['old'],
			'class' => $form['class'],
			'parent' => $user
		];

		$file_name = $this->upfile->do_upload('baby_img', './img/users/'.$user.'/baby');

		if($file_name)
		{
			$query['img'] = $file_name;
		}

		$rs = $this->baby->insert($query);

		if($rs)
		{
			$this->sess->get_access('alert', 'close', '등록에 성공하였습니다');
		}		
		else
		{
			$this->sess->get_access('alert', 'close', $file_name);
		}
	}

	//내 아이 정보 수정하기
	public function update()
	{		
		//id는 hidden, form
		$form = $this->input->post();

		//부모가 user인 아이 name 에 대한 수정.
		$where = [
			'parent' => $form['parent'],
			'name'   => $form['ori_name']
		];

		$query = [
			'name'  => $form['name'],
			'old'   => $form['old'],
			'class' => $form['class']
		];
	

		$file_name = $this->upfile->do_upload('baby_img', './img/users/'.$form['parent'].'/baby');
     

		if($file_name)
		{
			$query['img'] = $file_name;
			$data = ['msg' => $query['img']];
			$this->load->view('homepage/alert/error',$data);
		}
		
		$rs = $this->baby->update($where, $query);

		

		if($rs)
		{
			$this->sess->get_access('alert', 'close', '수정에 성공하였습니다');
		}		
		else
		{
			//$data = ['msg' => $this->db->last_query()];
			//$this->load->view('homepage/alert/error',$data);
			$this->sess->get_access('alert', 'close', '수정에 실패하였습니다');
		}
	}

	//내 아이 정보 삭제하기
	public function delete($parent, $baby)
	{
		$user = $this->sess->get_id();
		
		if($user != $parent)
		{
			$this->sess->get_access('alert', '', '해당 아동의 학부모가 아닙니다');
		}

		$where = [
			'parent' => $parent,
			'name'   => $baby
		];

		$rs = $this->baby->delete($where);
		if($rs)
		{
			$this->sess->get_access('alert', '', '삭제에 성공하였습니다');
		}		
		else
		{
			$this->sess->get_access('alert', 'close', '삭제에 실패하였습니다');
		}

	}
}
