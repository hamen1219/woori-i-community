<?php 
	class Class_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

		public function getClass($class = "")
		{
			$query = [
				'from' => 'class c'
			];
			if($class != "")
			{
				$query['where'] = ['name' => $class];
				$rs = $this->result->get_list($query,1);
			}
			else
			{
				$query['select'] = "c.*, (u.img) teacher_img,(u.name) teacher_name, (u.id) teacher_id, (select count(*) from baby where class = c.name) total_baby";
				$query['join'] = [
					['user u', 'u.id = c.teacher','left']
				];
				$query['group'] = "c.name";
				//모든 클래스 가져오기
				$rs = $this->result->get_list($query);
			}			
			
			return $rs;
		}

		//학부모의 아동이 속한 모든 반 불러오기
		public function getMyClass($parent, $mode = "")
		{
			//나의 아이들 반

			//등록된 모든 아동 중 부모 이름이 parent인 아동들이 속한 반
			$query = [
				'from'  => 'class c'											
			];

			//담임모드일 경우 본인이 맡은 반이 있는지 가져온다 (1개)
			if($mode == "teacher")
			{
				$query['where'] = ['c.teacher' => $parent];
				$rs = $this->result->get_list($query, 1);
			}		

			//담임모드 아니면 아이가 속한 모든 반 가져온다
			else
			{

				$query['select'] = "c.*, (t.img) teacher_img, (t.id) teacher_id, (t.name) teacher_name";
				$query['where'] = [   
					'bb.parent' => $parent
				];

				$query['join'] = [
					['baby bb', 'c.name = bb.class', 'left'],
					['user t', 't.id = c.teacher', 'left']
				];	
				$query['group'] = 'c.name';
				$rs = $this->result->get_list($query);
				//var_dump($this->db->last_query());

			}	
			return $rs;
		}

		public function insert($form)
		{
			$this->db->insert('class',$form);
			$rs = $this->db->affected_rows();
			return $rs;
		}

		public function update($where, $query)
		{
			$this->db->where($where);
			$query['teacher'] = ($query['teacher'] == "") ? null : $query['teacher'];

			$this->db->update('class', $query);


			$rs = $this->db->affected_rows();
			return $rs;
		}
		public function delete($where)
		{
			$this->db->delete('class',$where);
			$rs = $this->db->affected_rows();
			return $rs;
		}

		//id = parent_id

		public function insertBoard($form)
		{			
			$this->db->insert('class_board',$form);
			$rs = $this->db->affected_rows();
			//   _dump($form);
			return $rs;

		}
		public function deleteBoard($form)
		{
			$where= [
				'num' => $form['num']
			];
			$this->db->delete('class_board',$where);
			$rs = $this->db->affected_rows();
			return $rs;

		}

		public function getBoardList($class)
		{
			$query = [
				'from' => 'class_board',
				'where' => [
					'class' => $class
				]
			];
			$rs = $this->result->get_list($query, 'num');

			return $rs;
		}		
		public function getLimitBoardList($class, $page)
		{
			$start = ($page-1) * 10;
			$query = [
				'select' => 'cb.*, (u.img) user_img', 
				'from' => 'class_board cb',
				'where' => [
					'cb.class' => $class					
				],
				'join' => [
					['user u', 'u.id = cb.user', 'left']
				],
				'start' => $start,
				'sort' => ['cb.created', 'desc'],
				'limit' => 10
			];
			$rs = $this->result->get_list($query);

			//부모 없는 거 먼저
			return $rs;
		}	
		

		public function checkMyClass($mode, $class, $user)
		{
			//parent, teacher

			if($mode == "교사")
			{
				$query = [
					'from' => 'class',
					'where' => [
						'name' => $class,
						'teacher' => $user
					]
				];
				$rs = $this->result->get_list($query,1);
			}
			else if($mode == "학부모")
			{
				$query = [
					'from' => 'class c',
					'where' => [
						'c.name' => $class,
						'bb.parent' => $user
					],
					'join' => [
						['baby bb', 'c.name = bb.class', 'left']
					]
				];
				$rs = $this->result->get_list($query);
			}
			return $rs;
			
		}

		public function insertComment($form)
		{
			$where = [
				'name' => $form['name']
			];
			$this->db->where($where);
			$this->db->update('class',$form);
			$rs = $this->db->affected_rows();
			//ar_dump($this->db->last_query());
			return $rs;
		}
	}
