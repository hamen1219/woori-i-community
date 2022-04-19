<?php 
	class User_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

		public function checkUser($id, $pw = "")
		{
			//아이디 확인하는 공통 쿼리
			$query = [
					'from' => 'user',
					'where' => ['id' => $id]
				];
				$rs = $this->result->get_list($query, 1);

			//id검사
			if($pw == "")
			{
                if(!$rs)
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
			}

			//pw검사			
			else
			{
				//아이디 결과 있으면
				if($rs)
				{
                    if(!password_verify($pw, $rs['pw'])) {
                        return -1;
                    }
                    return 1;
				}

				//아이디 일치하지 않음
				return 0;
			}

		}

        public function setVisit($user)
        {
            $query = [
                'user' => $user,
                'ip' => $this->input->ip_address()
            ];
            $this->db->insert('visit', $query);
            if($this->db->affected_rows() < 1)
            {
                return 0;
            }
            return 1;
        }

		public function joinUser($form)
		{
			$rs = $this->db->insert('user', $form);

            //ar_dump($this->db->last_query());
			if(!$rs || !$this->db->affected_rows())
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function getUser($id)
		{
			$query = [
				'from' => 'user',
				'where' => ['id' => $id]
			];	
			$rs = $this->result->get_list($query, 1);

			if(!$rs)
			{
				return 0;
			}
			else
			{

				return $rs;
			}
		}

		public function update($where, $query)
		{
			$this->db->where($where);
			$this->db->update('user', $query);
			if(!$this->db->affected_rows())
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

        public function getTeacher($class)
        {
            //class명이 - 인 사용자

            ///class teacher, 
            $query = [
                'select' => 'u.*, (c.name) class_name',
                'from'  => 'user u',
                'where' => [
                    'c.name' => $class
                ],
                'join' => [
                    ['class c', 'u.id = c.teacher', 'left']
                ]
            ];
            $rs = $this->result->get_list($query, 1);
            return $rs;
        }

        public function getTeachers($mode = "")
        {
            $query['select']  = 'u.*, (c.name) class_name';
            $query['from']  = 'user u';
            $query['where'] = ['dept' => '교사'];
            $query['join'] = [
                ['class c', 'u.id = c.teacher','left']
            ];
            $query['sort'] = ['u.created', 'desc'];
            
            if($mode === 0)
            {
                $query['where']['perm'] = '가입대기' ;                
            }
            else if($mode === -1)
            {
                $query['where']['perm!='] = '가입대기' ;                
            }
            else if($mode === 1)
            {
                $query['where']['perm'] = '일반' ;
            }
            else if($mode === 99)
            {
                $query['where']['perm'] = '부관리자' ;                
            }

            $rs = $this->result->get_list($query);
        

            return $rs;

        }
        public function getParents($mode = "")
        {
            $query['from']  = 'user';
            $query['where'] = ['dept' => '학부모'];
            $query['sort'] = ['created', 'desc'];

            if($mode === 0)
            {
                $query['where']['perm'] = '가입대기' ;
            }
            else if($mode === 1)
            {
                $query['where']['perm'] = '일반' ;
            }
            $rs = $this->result->get_list($query);
            //var_dump($this->db->last_query());


            return $rs;
        }

		public function checkPerm($query)
		{
			$rs = $this->result->get_list($query ,1);
			if(!$rs)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function delete($where)
		{
			$this->db->delete('user', $where);
			if(!$this->db->affected_rows())
			{
				return 0;
			}
			else
			{
				return 1;
			}

		}


		 public function getUserEmpty()
         {
            $query = [
                'from' => 'user',
                'where' => ['perm' => '가입대기']
            ];
            $rs = $this->result->get_list($query);
            return $rs;
        }

        public function getUserCommon()
        {
            $query = [
                'from' => 'user',
                'where' => ['perm' => '일반']
            ];
            $rs = $this->result->get_list($query);
            return $rs;
        }

        public function getUserSubAdmin()
        {
            $query = [
                'from' => 'user',
                'where' => ['perm' => '부관리자']
            ];
            $rs = $this->result->get_list($query);          
            return $rs;  
        }

        public function getVisit()
        {
            $query = [
                'from' => 'visit',
                'sort' => ['visited', 'desc']
            ];       
            $rs = $this->result->get_list($query);
            return $rs;
        }

        //////////////////////////////////////////////////////



        //게시물 좋아요 최다 유저
        public function getLikeBoardMax()
        {
        	$query = [
                'select' => "ifnull(sum(lb.good), 0) lb_max, (u.id) user, (u.img) user_img",
        		'from' => 'user u',
                'join' => [
                    ['board b', 'u.id = b.user', 'left'],
                    ['like_b lb', 'b.num = lb.board_num', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['lb_max', 'desc']
        	];
        	$rs = $this->result->get_list($query, 1);
            if(!$rs || $rs['lb_max'] == 0)
            {
                return 0;
            }
            return $rs;
        }

        //댓글 좋아요 최다 유저
        public function getLikeReplyMax()
        {
            $query = [
                'select' => "ifnull(sum(lr.good), 0) lr_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['reply r', 'u.id = r.user', 'left'],
                    ['like_r lr', 'r.num = lr.reply_num', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['lr_max', 'desc']
            ];
            $rs = $this->result->get_list($query, 1);

            if(!$rs || $rs['lr_max'] == 0)
            {
                return 0;
            }
            return $rs;
        }

        //게시물 찜하기 최다 유저
        public function getSaveBoardMax()
        {
            $query = [
                'select' => "ifnull(sum(sb.save), 0) sb_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['board b', 'u.id = b.user', 'left'],
                    ['save_b sb', 'b.num = sb.board_num', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['sb_max', 'desc']
            ];
            $rs = $this->result->get_list($query, 1);           

            if(!$rs || $rs['sb_max'] == 0)
            {
                return 0;
            }
            return $rs;
        }

        //게시물 최다 작성 유저
        public function getBoardMax()
        {
            $query = [
                'select' => "ifnull(count(b.num), 0) b_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['board b', 'u.id = b.user', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['b_max', 'desc']
            ];
            $rs = $this->result->get_list($query, 1);
            if(!$rs || $rs['b_max'] == 0)
            {
                return 0;
            }
            return $rs;
        }


        //댓글 좋아요 최다 유저
        public function getReplyMax()
        {
            $query = [
                'select' => "ifnull(count(r.num), 0) r_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['reply r', 'u.id = r.user', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['r_max', 'desc']
            ];
            $rs = $this->result->get_list($query, 1);


            if(!$rs || $rs['r_max'] == 0)
            {
                return 0;
            }
            return $rs;
        }


        //홈페이지 방문 최다 유저
        public function getVisitMax()
        {
            $query = [
                'select' => "ifnull(count(v.num), 0) v_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['visit v', 'u.id = v.user', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['v_max', 'desc']
            ];
            $rs = $this->result->get_list($query, 1);

            
            if(!$rs || $rs['v_max'] == 0)
            {
                return 0;
            }
            return $rs;
        }

        public function getVisitToday()
        {
            $query = "select count(*) today from visit where date(visited) = date(now())";    
            $rs = $this->db->query($query);
            $rs = ($rs === null) ? 0 : $rs->row_array();
            
            if(!$rs || $rs['today'] == 0)
            {
                return 0;
            }
            return $rs['today'];  
        }
        public function getVisitTotal()
        {
            $query = [
                'select' => "count(*) total", 
                'from' => 'visit'
            ];
            $rs = $this->result->get_list($query, 1);
            if(!$rs || $rs['total'] == 0)
            {
                return 0;
            }
            return $rs['total'];              
        } 

        public function getVisitLatest($user)
        {
            $query = [
                'select' => 'visited',
                'from' => 'visit',
                'where' => ['user' => $user],
                'sort' => ['visited', 'desc']
            ];
            $rs = $this->result->get_list($query ,1);
            //var_dump($this->db->last_query());
            return $rs;

        }

        public function getUsersBoard($user)
        {
        	$select  = "(select count(*) from board) total_b,";
        	$select .= "(select count(*) from reply) total_r,";

        	$select .= "(select count(*) from board where user = u.id) total_my_b,";        	
        	$select .= "(select count(*) from reply where user = u.id) total_my_r,";

        	$select .=  "ifnull((select sum(lb.good) from user uu left join board b on uu.id = b.user left join like_b lb on b.num = lb.board_num where uu.id = u.id group by u.id),0) total_good,";
        	$select .= "ifnull((select sum(lb.poor) from user uu left join board b on uu.id = b.user left join like_b lb on b.num = lb.board_num where uu.id = u.id group by u.id),0) total_poor,";
        	$select .= "ifnull((select sum(sb.save) from user uu left join board b on uu.id = b.user left join save_b sb on b.num = sb.board_num where uu.id = u.id group by u.id),0) total_save,";

        	$select .=  "ifnull((select sum(lr.good) from user uu left join reply r on uu.id = r.user left join like_r lr on r.num = lr.reply_num where uu.id = u.id group by u.id),0) total_good_r,";
        	$select .= "ifnull((select sum(lr.poor) from user uu left join reply r on uu.id = r.user left join like_r lr on r.num = lr.reply_num where uu.id = u.id group by u.id),0) total_poor_r";
        	
        	//var_dump($user);
        	$query = [
        		'select' => $select,
        		'from'   => ['user u'],
        		'where'  => ['u.id' => $user['id']]
        	];

        	$rs =$this->result->get_list($query,1);

        	//var_dump($rs);
        	
        	return $rs;
        }


	}

