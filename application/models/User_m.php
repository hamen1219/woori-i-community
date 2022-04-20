<?php 
	class User_m extends CI_Model{

		public function __construct()
		{
			parent::__construct();			
		}

        /**
         * 사용자 확인 함수 
         * @param string $id 사용자 ID
         * @param string $pw 사용자 PW
         * @return int 결과코드
         */     
		public function checkUser($id, $pw = "")
		{
			// 해당 아이디의 사용자 있는지 확인
			$query = [
                'from' => 'user',
                'where' => ['id' => $id]
            ];

            // get user info 
            $rs = $this->result->get_list($query, 1);

			// ID만 검사하는 모드
			if($pw == "") {
                
                if(!$rs) { // 사용자 정보 없는 경우 
                    return 1;

                } else {   // 사용자 정보 있는 경우  
                    return 0;
                }
			}

            // PW 검사하는 모드 
			
			// 해당 사용자 있는 경우 
            if(!empty($rs)) {
                if(!password_verify($pw, $rs['pw'])) { // 비밀번호 일치하지 않는 경우 -1
                    return -1;
                }

                // success
                return 1;
            }

            // 해당 사용자 없음. 
            return 0;        
		}

        /**
         * 방문자 처리 함수 
         * @param string $user_id 사용자 아이디
         * @return boolean 상태코드
         */
        public function setVisit($user_id)
        {
            // insert data
            $query = [
                'user' => $user_id,
                'ip' => $this->input->ip_address()
            ];

            // insert
            $this->db->insert('visit', $query);

            // insert fail
            if($this->db->affected_rows() < 1) {
                return 0;
            }

            // success
            return 1;
        }

        /**
         * 사용자 회원가입 함수
         * @param array $form 가입양식
         * @return boolean 결과 코드 
         */
		public function joinUser($form)
		{
            // insert user
			$rs = $this->db->insert('user', $form);

			if(empty($rs) || $this->db->affected_rows() < 1) { // 등록실패 
				return 0;  
			} 

            // success 
            return 1;			
		}

        /**
         * 사용자 정보 가져오기 (1명) 
         * @param string $id 사용자 ID
         * @return int|array 결과 코드 또는 데이터
         */
		public function getUser($id)
		{
            // user fine query 
			$query = [
				'from' => 'user',
				'where' => ['id' => $id]
			];	

            // user info 
			$rs = $this->result->get_list($query, 1);

			if(empty($rs)) { // empty user 
				return 0;
			} 
            // return user data
            return $rs;
			
		}

        /**
         * 사용자 정보 업데이트 함수
         * @param array $where 수정할 사용자 key query 
         * @param array $query 수정될 사용자 data query
         * @return boolean 상태코드
         */
		public function update($where, $query)
		{
            // update query 
			$this->db->where($where)
                    ->update('user', $query);

            // update fail
			if($this->db->affected_rows() < 1) {
				return 0;
			}   

            // success
		    return 1;			
		}
        
        /**
         * 학급 담임 정보 가져오는 함수 
         * @param string $class 학급명
         * @return array 교사정보 
         */
        public function getTeacher($class)
        {
            // get teacher query 
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

            // get teacher info 
            $rs = $this->result->get_list($query, 1);
            
            // return teacher info 
            return $rs;
        }

        /**
         * 등급별 교사 목록 불러오기 
         * @param int $mode 모드 번호
         * @return array 학급 리스트 
         */
        public function getTeachers($mode = "")
        {
            // get teacher query 
            $query['select']  = 'u.*, (c.name) class_name';
            $query['from']  = 'user u';
            $query['where'] = ['dept' => '교사'];
            $query['join'] = [
                ['class c', 'u.id = c.teacher','left']
            ];
            $query['sort'] = ['u.created', 'desc'];

            // 모드별 쿼리 대입 
            switch($mode) {
                case 0 : 
                    $query['where']['perm'] = '가입대기' ;      
                    break ;

                case -1 :
                    $query['where']['perm!='] = '가입대기' ;      
                    break ;

                case 1 : 
                    $query['where']['perm'] = '일반' ;
                    break ;
                    
                case 99 :  
                    $query['where']['perm'] = '부관리자' ;    
                    break ;

                default : 
                    $query['where']['perm'] = '' ;
                    break;    
            }

            // get teacher list
            $rs = $this->result->get_list($query);
            
            // return teacher list
            return $rs;
        }

        /**
         * 학부모 리스트 불러오는 함수 
         * @param int $mode 모드값
         * @return $array 학부모 리스트 
         */
        public function getParents($mode = "")
        {
            // get parents query
            $query['from']  = 'user';
            $query['where'] = ['dept' => '학부모'];
            $query['sort'] = ['created', 'desc'];

            // 모드별 쿼리 대입
            switch($mode) {
                case 0 : 
                    $query['where']['perm'] = '가입대기' ;
                    break ;

                case 1 : 
                    $query['where']['perm'] = '일반' ;
                    break ;

                default :
                    $query['where']['perm'] = '' ;
                    break ;
            }
           
            // get parents list
            $rs = $this->result->get_list($query);

            // return parents list 
            return $rs;
        }

        /**
         * 권한 체크하는 함수  ???
         * @param array $query 쿼리
         * @return boolean 상태코드 
         */
		public function checkPerm($user_id, $user_pw)
		{
            // 사용자 확인 쿼리 
            $query = [
                'from'   => 'user',
                'where'  => [
                    'id' => $user_id
                ]
            ];

            // get user list
			$rs = $this->result->get_list($query ,1);
			
            // 사용자 정보를 찾을 수 없거나, 입력 비밀번호가 DB에 저장된 비밀번호와 정보가 다를 때 
            if(empty($rs) || !password_verify($user_pw, $rs['pw'])) {
                return 0;
            }

            // success
            return 1; 
		}

        /**
         * 사용자 삭제 함수
         * @param array $where 삭제 쿼리 조건 배열
         * @return boolean 
         */

		public function delete($where)
		{
            // delete query
			$this->db->delete('user', $where);

            // delete fail
			if(!$this->db->affected_rows()) {
				return 0;
			}

            // success
            return 1;
		}

        /**
         * 가입대기 회원 목록 불러오는 함수 
         * @return array 회원 목록
         */
		 public function getUserEmpty()
         {
            // 가입 대기 회원 불러오는 쿼리 
            $query = [
                'from' => 'user',
                'where' => ['perm' => '가입대기']
            ];

            // get user list
            $rs = $this->result->get_list($query);
            
            // return user list
            return $rs;
        }

        /**
         * 일반 회원 목록 불러오는 함수 
         * @return array 회원 목록
         */
        public function getUserCommon()
        {
            // 일반 회원 불러오는 쿼리
            $query = [
                'from' => 'user',
                'where' => ['perm' => '일반']
            ];

            // get user list
            $rs = $this->result->get_list($query);

            // return user list
            return $rs;
        }

        /**
         * 부관리자 목록 불러오는 함수
         * @return array 회원 목록
         */
        public function getUserSubAdmin()
        {
            // get user query 
            $query = [
                'from' => 'user',
                'where' => ['perm' => '부관리자']
            ];

            // get user info
            $rs = $this->result->get_list($query);          
            
            // return user info
            return $rs;  
        }

        /**
         * 방문자 목록 불러오는 함수 
         * @return array 방문자 목록 
         */
        public function getVisit()
        {
            // get visitor list query 
            $query = [
                'from' => 'visit',
                'sort' => ['visited', 'desc']
            ];       

            // get visitor list
            $rs = $this->result->get_list($query);

            // return list
            return $rs;
        }


        /******************************************************
         ** 메인페이지 통계 관련 함수 
         ******************************************************/   

        /**
         * 게시물 좋아요 최다 유저 정보 가져오는 함수 
         * @return int|array 유저 정보 
         */
        public function getLikeBoardMax()
        {
            // get max user query 
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

            // get info
        	$rs = $this->result->get_list($query, 1);

            if(!$rs || $rs['lb_max'] == 0) { // 0
                return 0;
            }

            // return user info 
            return $rs;
        }

        /**
         * 댓글 좋아요 최다 유저 정보 불러오는 함수 
         * @return int|array 유저 정보 
         */
        public function getLikeReplyMax()
        {
            // get max user query 
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

            // get max user 
            $rs = $this->result->get_list($query, 1);

            if(!$rs || $rs['lr_max'] == 0) { // 0
                return 0;
            }

            // return user info
            return $rs;
        }
        /**
         * 게시물 찜하기 최다 유저 정보 불러오는 함수 
         * @param array 유저 정보 
         */
        public function getSaveBoardMax()
        {
            // get max user query
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

            // get max user
            $rs = $this->result->get_list($query, 1);           

            if(!$rs || $rs['sb_max'] == 0) { // 0
                return 0;
            }

            // return user info 
            return $rs;
        }

        /**
         * 게시물 좋아요 최다 유저 정보 불러오는 함수 
         * @return int|array 유저 정보 
         */
        public function getBoardMax()
        {
            // get max user query
            $query = [
                'select' => "ifnull(count(b.num), 0) b_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['board b', 'u.id = b.user', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['b_max', 'desc']
            ];

            // get max user
            $rs = $this->result->get_list($query, 1);

            if(!$rs || $rs['b_max'] == 0) { // 0
                return 0;
            }

            // return user info 
            return $rs;
        }

        /**
         * 댓글 좋아요 최다 유저 정보 불러오는 함수 
         * @return int|array 유저 정보 
         */
        public function getReplyMax()
        {
            // get user query 
            $query = [
                'select' => "ifnull(count(r.num), 0) r_max, (u.id) user, (u.img) user_img", 
                'from' => 'user u',
                'join' => [
                    ['reply r', 'u.id = r.user', 'left']
                ],
                'group' => 'u.id',
                'sort'  => ['r_max', 'desc']
            ];

            // get user info
            $rs = $this->result->get_list($query, 1);

            if(!$rs || $rs['r_max'] == 0) { // 0
                return 0;
            }

            // return user info
            return $rs;
        }


        /**
         * 홈페이지 최다 방문 유저 정보 불러오는 함수 
         * @return int|array 유저 정보 
         */
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

            
            if(!$rs || $rs['v_max'] == 0) { // 0
                return 0;
            }

            // return user info 
            return $rs;
        }

        /**
         * 오늘 홈페이지에 방문한 총 인원 구하는 함수  
         * @param int 인원수
         */
        public function getVisitToday()
        {
            // get cnt query 
            $query = "select count(*) today from visit where date(visited) = date(now())";    
            
            // get cnt row 
            $rs = $this->db->query($query);
            $rs = ($rs === null) ? 0 : $rs->row_array();

            // 정보 없는 경우 
            if(!$rs || $rs['today'] == 0) {
                return 0;
            }

            // return cnt
            return $rs['today'];  
        }

        /**
         * 홈페이지 총 방문 인원 구하는 함수 
         * @param int 인원수 
         */
        public function getVisitTotal()
        {
            // get cnt query 
            $query = [
                'select' => "count(*) total", 
                'from' => 'visit'
            ];

            // get cnt 
            $rs = $this->result->get_list($query, 1);

            if(!$rs || $rs['total'] == 0) { // 0
                return 0;
            }

            // return cnt
            return $rs['total'];              
        } 

        /**
         * 최근 방문자 구하는 함수 
         * @param string $user_id 사용자 아이디
         * @return array 방문 정보 row
         */
        public function getVisitLatest($user)
        {
            // 최근 방문 정보 구하는 query
            $query = [
                'select' => 'visited',
                'from' => 'visit',
                'where' => ['user' => $user],
                'sort' => ['visited', 'desc']
            ];

            // get visit info 
            $rs = $this->result->get_list($query ,1);

            // return visit info 
            return $rs;
        }

        /**
         * 사용자의 게시물 관련 정보 일괄 가져오는 함수 
         * @param array $user 유저 정보
         * @param array 유저 정보 
         */
        public function getUsersBoard($user_info)
        {
            // select subquery
        	$select  = "(select count(*) from board) total_b,";
        	$select .= "(select count(*) from reply) total_r,";

        	$select .= "(select count(*) from board where user = u.id) total_my_b,";        	
        	$select .= "(select count(*) from reply where user = u.id) total_my_r,";

        	$select .=  "ifnull((select sum(lb.good) from user uu left join board b on uu.id = b.user left join like_b lb on b.num = lb.board_num where uu.id = u.id group by u.id),0) total_good,";
        	$select .= "ifnull((select sum(lb.poor) from user uu left join board b on uu.id = b.user left join like_b lb on b.num = lb.board_num where uu.id = u.id group by u.id),0) total_poor,";
        	$select .= "ifnull((select sum(sb.save) from user uu left join board b on uu.id = b.user left join save_b sb on b.num = sb.board_num where uu.id = u.id group by u.id),0) total_save,";

        	$select .=  "ifnull((select sum(lr.good) from user uu left join reply r on uu.id = r.user left join like_r lr on r.num = lr.reply_num where uu.id = u.id group by u.id),0) total_good_r,";
        	$select .= "ifnull((select sum(lr.poor) from user uu left join reply r on uu.id = r.user left join like_r lr on r.num = lr.reply_num where uu.id = u.id group by u.id),0) total_poor_r";
        	
        	// get info query 
        	$query = [
        		'select' => $select,
        		'from'   => ['user u'],
        		'where'  => ['u.id' => $user_info['id']]
        	];

            // get info 
        	$rs =$this->result->get_list($query,1); 
            
            // return info 
        	return $rs;
        }
	}

