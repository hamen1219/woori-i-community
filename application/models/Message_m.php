<?php 
	class Message_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

		//msg 전송 메서드 
		public function insertAllClassNotice($form)
		{			
			$this->db->insert('class_alert',$form);
			$rs = $this->db->affected_rows();
			//var_dump($this->db->last_query());
			return $rs;
		}

		public function insertClassNotice($form)
		{			
			$this->db->insert('class_alert',$form);
			$rs = $this->db->affected_rows();
			//var_dump($this->db->last_query());
			return $rs;
		}

		public function insertComment($form)
		{
			$where = [
				'name' => $form['name']
			];
			$this->db->where($where);
			$this->db->update('class_alert',$form);
			$rs = $this->db->affected_rows();
			//var_dump($this->db->last_query());
			return $rs;
		}

		public function getQuery()
		{
			//등록된 msg 정보 가져오기
			$query = [
				'from' => 'class_alert ca',
				'join' => [
					//user : 메세지 작성자
					['user u', 'u.id = ca.user', 'left'],
					['class c', 'c.name = ca.class', 'left'],
					['user t', 't.id = c.teacher', 'left'],
					['baby bb', 'bb.name = ca.baby', 'left']
				],
				'sort' => ['ca.created', 'desc']
			];	
			return $query;			
		}

		//msg 수신 메서드 (mode : 1, 0, "")

		//전체 학부모 수신 메세지
		public function getAllClassNotice()
		{
			$query = $this->getQuery();

			//메세지 내용
			$query['select'] = "ca.*, u.img, u.perm";
			$query['where'] = [
				'ca.class' => null, 
				'ca.parent' => null
			];
			$rs = $this->result->get_list($query);
			return $rs;			
		}

		//교사가 보내는 반 메세지
		public function getClassNotice($class)
		{
			$query = $this->getQuery();
	
			$query['select'] = "ca.*, (t.img) teacher_img, (t.name) teacher_name, (t.id) teacher_id";		
			$query['where'] = [
				'ca.class' => $class,
				'ca.parent' => null
			];
			//메세지 내용
			$where = ['ca.class' => $class];		

			$rs = $this->result->get_list($query);
			return $rs;		

		}

		//교사가 개별 아동에세 보내는 메세지 정보 
		public function getComment($class, $parent, $baby)
		{
			$query = $this->getQuery();

			//메세지 정보, 아이사진, 발송인사진, 발송인 등급
			$query['select'] = "ca.*, (c.name) class_name, (u.img) teacher_img, (u.id) teacher_id";
			$query['where'] = [
				'ca.baby'   => $baby,
				'ca.parent' => $parent,
			    'ca.class'  => $class
			];

			$rs = $this->result->get_list($query);

			return $rs;
		}

		//내 아동에게 도착한 총 1:1 메세지 개수
		public function getTotalComment($parent, $mode = "")
		{
			$query = [
				'from' => 'class_alert',
				'where' => [
					'parent' => $parent
				]
			];
			if($mode == "unread")
			{
				$query['where']['view'] = "읽지않음";
			}
			$rs = $this->result->get_list($query, 'num');
			return $rs;
		}

		public function setCommentRead($class, $parent, $baby)
		{	
			//해당 아동에게 도착한 메세지 전체에 대해
			$where = [
				'class' => $class,
				'parent' =>$parent,
				'baby' => $baby
			];

			//읽음처리
			$query = [
				'view' => '읽음'
			];
			$this->db->where($where);
			$this->db->update('class_alert', $query);
			
		}

		//msg 삭제 메서드
		public function deleteMyMessage()
		{
			//
		}

	
	}