<?php 
	class Board_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

		public function test()
		{
			//var_dump($this->db->last_query());
		}

		public function getMeeting()
		{
			$query = [
				'from'  => 'board',
				'where' => ['cat' => '정모'],
				'limit' => 5,
				'sort'  => ['created', 'desc']
			];
			$rs = $this->result->get_list($query);

			return $rs;
		}

		//게시판 좋아요 관련 
		public function insertLike($from, $query)
		{	
			$this->db->insert($from, $query);	
	
			if($this->db->affected_rows() < 1)
			{
				///var_dump($this->db->error()); exit;
				$query = [
					'user' => $query['user'],
					'board_num' => $query['board_num']
				];
				$this->db->delete($from, $query);
				if($this->db->affected_rows() < 1)
				{
					return 0;
				}
			}
			return 1;						
		}

		//1개 게시물에 대한 상세 페이지
		public function getBoard($page, $user = "")
		{
			//user는 로그인한 사용자가 체크한 것 표시..
	
					//게시물 테이블 기본 정보 
			$select = "b.*,";
			$select .= "(u.img) user_img, (u.created) user_created, u.name, u.dept,"; 



			$select .= "(select ifnull(sum(good),0) from like_b where board_num = b.num) good,";
			$select .= "(select ifnull(sum(poor),0) from like_b where board_num = b.num) poor,";
			$select .= "(select ifnull(sum(save),0) from save_b where board_num = b.num) save";



			if($user != "")
			{
				$select .= ",ifnull((select good from like_b where board_num = b.num and user = '".$user."'),0) mygood,";
				$select .= "ifnull((select poor from like_b where board_num = b.num and user = '".$user."'),0) mypoor,";
				$select .= "ifnull((select save from save_b where board_num = b.num and user = '".$user."'),0) mysave";
			}		

			$from = "board b";

			$join = [
				['user u', 'u.id = b.user', 'left'],
				['like_b lb', 'b.num = lb.board_num', 'left'],
				['save_b sb', 'b.num = sb.board_num', 'left']
			];
			$where = ['b.num' => $page];
			$group = 'b.num';

			$query = [
				'select' => $select,
				'from'   => $from,
				'where'  => $where,
				'join'   => $join,
				'group'  => $group
			];
			$rs = $this->result->get_list($query ,1);		
			//var_dump($this->db->last_query());
			return $rs;
		}

		//게시물 수정
		public function update($where, $query)
		{		
			if(!is_array($where))
			{
				$where = ['num' => $where];
			}
			$this->db->where($where);
			$this->db->update('board', $query);
			if($this->db->affected_rows() < 1)
			{
				return 0;
			}
			return 1;
		}
		public function delete($where)
		{
			if(!is_array($where))
			{
				$where = ['num' => $where];
			}
			$this->db->delete('board', $where);
			if($this->db->affected_rows() < 1)
			{
				return 0;
			}
			return 1;		
		}
		public function updates($pages, $query, $mode = "")
		{
			if($mode == "blind")
			{
				$this->db->update('board', ['perm' => "일반"]);
			}
			if($pages !== null)
			{
				foreach($pages as $page)
				{
					$this->db->where("num", $page);
					$this->db->update('board', $query);
					if($this->db->affected_rows() < 1)
					{
						//var_dump($this->db->last_query()); exit;
						return 0;
					}			
				}
				return 1;
			}
			//pages : 수정할 페이지 들의 배열
			
			return 1;
		}
		public function deletes($pages, $mode = "")
		{
			foreach($pages as $page)
			{
				$this->db->delete('board', ['num' => $page]);
				if($this->db->affected_rows() < 1)
				{
					return 0;
				}			
			}
			return 1;
		}


		//조회수 늘리기
		public function setView($page)
		{
			//현재 board view + 1 로 수정하기		
			$query =  "update board set view = view+1 where num = ".$page;
			$this->db->query($query);
			if($this->db->affected_rows() < 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}			
		}

		public function getAjaxBoard($cat)
		{
			$query = [
				'from'  => 'board',
				'where' => ['cat' => $cat],
				'start' => 0,
				'limit' => 5,
				'sort'  => ['created', 'desc']
			];
			$rs = $this->result->get_list($query);
			return $rs;
		}

		//전체 게시물 불러오기
		public function getBoards()
		{
			$query = [
				'from'  => 'board',
				'sort'  => ['created', 'desc']
			];
			$rs = $this->result->get_list($query);
			return $rs;
		}

		public function getSideBoards()
		{			
        	$query = [
				'from'   => 'board b',
				'start'  => 0,
				'limit'  => 5,
				'sort'   => ['b.created', 'desc'],
				'where'  => ['b.cat!=' => '대문']
			];
			$side = $this->result->get_list($query);	
			return $side;
		}

		//CRUD
		public function write($query) //작성된 정보 가져오기
		{
			$this->db->from('board');
			$rs = $this->db->insert('board', $query);

			if(!$rs)
			{
				//var_dump($this->db->error());
				return 0;
				//실패
			}
			else
			{
				//등록된 페이지 번호 얻어오기
				$page = $this->db->insert_id();
				return $page;
			} 		
		}

		public function getIntroBoard()
		{
			//대문 글귀 가져오는 query 
			$query = [
				'from' => 'intro_board',
				'sort' => ['created', 'desc']
			];
			$rs = $this->result->get_list($query, 1);

			return $rs;
		}

		public function setIntroBoard($query)
		{
			$this->db->insert('intro_board', $query);
			if($this->db->affected_rows() < 1)
			{
				return 0;
			}
			return 1;
		}

		public function getGallaryBoard()
		{
			$query = [
				'select' => 'bb.num, bb.img',
				'from' => 'board b',
				'join' => [
					["(select num, substr(contents, instr(contents, 'img alt=')+17, instr(substr(contents, instr(contents, 'img alt')+17), '\"')-1) img from board) bb", 'b.num = bb.num', 'left']
				],
				'where' => [
					'b.cat' => '자기소개',
					'bb.img !=' => "" 
				],
				'start' => 0,
				'limit' => 8,
				'sort' => ['b.created', 'desc']
			];
			$rs = $this->result->get_list($query);
			//var_dump($this->db->last_query());
			if(!$rs)
			{
				return 0;
			}
			return $rs;
		}

		public function getMySave($user)
		{
			$query = [
				'select' => 'b.num, b.title, (b.user) b_user, sb.user, sb.created',
				'from'   => 'board b',
				'where'  => ['sb.user' => $user],
				'join'   => ['save_b sb', 'b.num = sb.board_num', 'left'],
				'sort'   => ['sb.created', 'desc']
			];
			$rs = $this->result->get_list($query);
			//var_dump($this->db->last_query());
			if(!$rs)
			{

				return 0;
			}

			return $rs;
		}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		

		//쿼리 만들어 주는 메서드
		private function getQuery($mode, $arr)
		{


			//1단계 쿼리 : 전체 게시물 가져오기 (cat, user 존재시 where)
			$select  = 'b.*, u.dept dept, count(r.num) reply_cnt, ifnull(sum(lb.good), 0) good,';
			$select .= "substr(b.contents, instr(b.contents, 'img alt=')+16, instr(substr(b.contents, instr(b.contents, 'img alt=')+16), '\"')-1) board_img";
			$from    = 'board b';
			$join    = [
				['user u', 'u.id = b.user', 'left'],
				['reply r', 'b.num = r.board_num', 'left'],
				['like_b lb', 'b.num = lb.board_num', 'left']
			];
			$group = 'b.num';	

			$query = [
				'select' => $select,
				'from'   => $from,
				'join'   => $join,
				'group'  => $group,
			];

			//카테고리 있을 경우 지정
			if(isset($arr['where']))
			{
				$query['where'] = $arr['where'];
			}

			if($mode === 1) return $query;


			//2단계 쿼리 : 검색 결과에 해당하는 게시물 가져오기 (like)	
			if($arr['option'] == "내용")
			{
				$query['like'] = "(b.contents like '%".$arr['search']."%')";
			}

			else if($arr['option'] == "제목") 
			{
				$query['like'] = "(b.title like '%".$arr['search']."%')";
			}
			else if($arr['option'] == "작성자")
			{
				$query['like'] = "(b.user like '%".$arr['search']."%')";
			}
			else 
			{
				$str = "(b.contents like '%".$arr['search']."%'";
				$str .= "or b.title like '%".$arr['search']."%'";
				$str .= "or b.user like '%".$arr['search']."%')";
				$query['like'] = $str;
			}	
			if($mode === 2) return $query;			


			//3단계 쿼리 : 현재 페이지에 보여질 게시물(limit, sort)
			if(($arr['sort']) && $arr['sort'] == "과거순")
			{
				$query['sort'] = ['b.created', 'asc'];
			}		
			else 
			{
				$query['sort'] = ['b.created', 'desc'];
			}

			$query['start'] = $arr['start'];

			if(!isset($arr['limit']))
			{
				$query['limit'] = 10;		
			}
			else
			{
				$query['limit'] = $arr['limit'];	
			}
					
			return $query;
		}

	//////////////////////////////////////////////////////////////////////
		//전체 데이터 검색 결과


		//조건에 맞는 검색 결과
		
		public function getTotalBoardList($arr)
		{

			$query = $this->getQuery(1, $arr);

			$rs = $this->result->get_list($query, 'num');
			return $rs;
		}
		
		public function getBoardList($arr)
		{
			$query = $this->getQuery(2, $arr);			
			$rs = $this->result->get_list($query, 'num');
			return $rs;
		}

		public function getLimitBoardList($arr)
		{
			$query = $this->getQuery(3, $arr);
			$rs = $this->result->get_list($query);
			
			return $rs;
		}


	
	}



	
