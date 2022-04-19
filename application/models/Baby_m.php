<?php 
	class Baby_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

		//모든 아동 불러오거나 조건에 해당하는 아동만 불러오기
		public function getBaby($parent="" ,$name = "")
		{
			//모든 아동 조회
			if($parent == "")
			{
				$query = [
					'from' => 'baby',
					'desc'  => 'parent'
				];
				$rs = $this->result->get_list($query);
			}

			//해당 학부모의 자녀 확인(기본 쿼리)
			else
			{
				$query = [
					'select' => 'bb.*',
					'from'   => 'baby bb',
					'where'  => ['bb.parent' => $parent],
					'join'   => [
						['user u', 'u.id = bb.parent', 'left']						
					]					
				];

				//사용자의 모든자녀
				if($name == "")
				{
					$query['select'] = "bb.*, ifnull((select count(*) from class_alert where parent = ca.parent and baby = ca.baby and view = '읽지않음'),0) msg_cnt ";
					$query['join'][1] = ['class_alert ca', 'bb.name = ca.baby', 'left'];
					$query['group'] = 'bb.name';
					$query['sort'] = ['bb.old', 'desc'];
					$rs = $this->result->get_list($query);
				}
				//사용자의 자녀 한명
				else
				{					
					$query['select'] = 'bb.*';
					$query['where'] = [
						'bb.parent' => $parent,
						'bb.name'   => $name,
					];		
					$rs = $this->result->get_list($query, 1);				
				}
				
			}
			return $rs;
		}

		//해당 학급 내 아동 불러오기
		public function getClassBaby($class, $parent = "")
		{
			$query = [
				'from' => 'baby',
				'where' => ['class' => $class]
			];

			$rs = $this->result->get_list($query);
			return $rs;
		}


		public function insert($query)
		{
			$rs = $this->db->insert('baby', $query);
			//var_dump($this->db->last_query());

			if($rs)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function update($where, $query)
		{
			$this->db->where($where);
			$this->db->update('baby',$query);

			//var_dump($this->db->error());

			
			if($this->db->affected_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function delete($where)
		{
			$this->db->delete('baby', $where);
			
			if($this->db->affected_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		
	}