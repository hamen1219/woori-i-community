<?php 
	class Reply_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

		public function getReply($board_num, $user = "")
		{
			$select  = 'r.*, u.img user_img, r.created reply_created, lr.user lr_user, ifnull(lr.good,0) lr_good, ifnull(lr.poor,0) lr_poor,';
			$select .= 'ifnull(sum(lr.good),0) good, ifnull(sum(lr.poor),0) poor';

			//로그인 된 사용자 있을 경우
			if($user !== "")
			{
				$select .= ',(select ifnull(good, 0) from like_r where user = \''.$user.'\' and reply_num = r.num) mygood,';
				$select .= '(select ifnull(poor, 0) from like_r where user = \''.$user.'\' and reply_num = r.num) mypoor,';
			}

			//권한 없는 사용자의 경우 
			$query = [
				'select' => $select,
				'from'   => 'reply r',
				'join'   => [
					['user u', 'u.id = r.user','left'],
					['like_r lr', 'r.num = lr.reply_num', 'left']
				],
				'where'  => ['r.board_num' => $board_num],
				'group'  => 'r.num',
				'sort'   => [
					['r.reply_group', 'asc'],
					['r.parent_num', 'asc'],
					['r.created', 'asc']
				]
			];		
			$rs = $this->result->get_list($query);
			return $rs;
		}

		public function insertReply($data, $mode = "")
		{
			//일반 댓글 작성시
			if($mode === "reply")
			{				
				$query = [
					'select' => 'max(reply_group)+1 reply_group',
					'from'   => 'reply',
					'group'  => 'board_num',
					'where'  => ['board_num' => $data['board_num']]
				];
				//현재 댓글들 중 가장 큰 reply_group 찾는다.
				$rs = $this->result->get_list($query, 1);				

				//처음쓰는 댓글은 group 1
				if(!$rs)
				{
					$data['reply_group'] = 1;
				}
				else
				{
					$data['reply_group'] = $rs['reply_group'];
				}				
			}		
			//자녀 댓글이면 위 코드는 실행 x
			$this->db->insert('reply', $data);

			if($this->db->affected_rows() < 1)
			{
				return 0;
			}
			return 1;
		}

		public function deleteReply($query, $mode = "")
		{
			$where = [
				'num'  => $query['reply_num']
			];
			if($mode != "admin")
			{
				$query = ['contents' => ''];
				$this->db->where($where);	
				$this->db->update('reply', $query);
			}
			else
			{
				$this->db->delete('reply', $where);
			}

			if($this->db->affected_rows() < 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}			

			if($this->db->error()['message'] !== '')
			{
				return 0;
			}
			return 1;

		}

		function insertLike($query)
		{
			$rs = $this->db->insert('like_r', $query);

			if($this->db->affected_rows() < 1)
			{
				//var_dump($this->db->error()); exit;
				$query = [
					'user' => $query['user'],
					'reply_num' => $query['reply_num']
				];
				$rs = $this->db->delete('like_r', $query);
				//var_dump($this->db->last_query()); exit;
				if($this->db->affected_rows() < 1)
				{
					return 0;
				}
			}
			return 1;	
		}
	}
