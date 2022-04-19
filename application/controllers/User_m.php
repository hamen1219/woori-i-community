<?php 
	class User_m extends CI_Model{


		//회원가입 : 성공시 1, 실패시 0
		public function __construct()
		{
			parent::__construct();
			$this->load->library('result');
		}

		//id 중복 확인하는 메서드. ajax 컨트롤러에서 사용됨.
		//  1 : 사용가능
		//  0 : 정보 없음
		// -1 : 상호 불일치

		//pw == '' 일 경우 id 검사만 진행한다.
		public function checkUser($id, $pw='') //최종 join 시 허가 : 0, 불가 : 1
		{
			//아이디 중복확인
			$query = [
				'from'  => 'user',
				'where' => ['id' => $id]
			];

			$rs = $this->result->get_list($query, 'one');

			//해당 아이디가 존재할 경우
			if(isset($rs['rs'])) 
			{
				//1. 아이디만 중복검사 (회원가입 시 아이디 중복확인 및 회원가입 최종 확인 시)
				if($pw == '') return 1;

				//2. 모두 검사 (로그인시)
				else 
				{
					//검색된 정보 한 줄 가져오기
					$row = $rs['rs'];
					//pw도 동일하면 로그인 성공.
					if($row['pw'] == $pw) 
					{
						//사용자 정보 세션에 저장!
						$this->session->set_userdata('user', $row);
						//방문기록 저장
						$this->db->insert('visit', ['user' => $id]); 
						return 1;
					}
					else return -1; //아이디만 동일!
				}				
			}
			 //해당 아이디 없음
			else
			{
				return 0;
			}
		}

		public function joinUser($user) //form 데이터
		{
			//user(사용자 입력 폼 정보) : tid, tpw, tname, addr
			$info = [
					'id'      => $user['tid'],
					'pw'      => $user['tpw'],
					'name'    => $user['tname'],
					'addr'    => $user['addr'],
					'sex'     => $user['sex'],
					'dept'    => $user['dept']
				];
			//폼데이터 compress

			$rs_check = $this->checkUser($info['id']);
			if($rs_check == 1) //사용중
			{
				return 'error_id';
			}
			//else
			
			$do_upload = $this->do_upload($info['id']); 
			//업로드 실패하면 error, 성공하면 data


			//////////////////////////////////////////////////////////////////////////////// 에러 처리 필요.

			if(isset($do_upload['data']))
			{
				//성공
				$info['img'] = $do_upload['data']['file_name'];
			}
			//이미지 못불러오면 못불러오는대로.. img에는 빈칸....

			$rs = $this->db->insert('user', $info); //사용자 정보 db 삽입.
			if(! $rs)
			{
				return 'error_db';
			}
			//////////////////////////////////////////////////////////////////////////////// 에러 처리 필요.
			else
			{
				//회원가입 성공 : 가입된 데이터 확인 후 회원 데이터를 flashdata에 저장하여 사용자에 1회 보여줌.
				$query = [
					'from' => 'user',
					'where' => ['id' => $info['id']]
				];
				$rs = $this->result->get_list($query, 'one');

				$this->session->set_flashdata($rs['rs']); 
				return 1;
				//리턴 값은 user, error 또는 data 이다.
			}
		}

	

		//업로드 담당 메서드. 반환 : data, error
		public function do_upload($userid, $mode = '') 
        {
        	$url = "./img/users/".$userid."/profile/";
        	//업로드에 실패하더라도 유저 정보 유효성 확인 이후 작업이므로 폴더 삭제 x

        	if($mode == "")
        	{
        		mkdir($url, 0777, TRUE); //폴더 생성.     
        	} 		   		
      

            $config['upload_path']          = $url;
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 100000000;
            $config['max_width']            = 100000000;
            $config['max_height']           = 100000000;            

            $this->load->library('upload', $config); //설정내용을 적용한 upload library 불러오기.

           if(! $this->upload->do_upload('img_file')) //업로드 불러오기에 실패한다면
           {	
           		$data['error'] = $this->upload->display_errors();
           }
           else
           {
    			$data['data'] = $this->upload->data();
           }
           return $data;
        }

        //유저 개인정보 보여주는 창
        public function board($user)
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

        	$rs =$this->result->get_list($query,'one');
        	
        	return $rs;
        }

        public function get_user($user)
        {
            $query = [
                'from'  => 'user',
                'where' => ['id' => $user]
            ];

            $rs = $this->result->get_list($query, 'one')['rs'];
             //var_dump($this->db->last_query());
            return $rs;
        }

        public function update($data, $user="")
        {
        	$id = $this->sess->get_id();      
            if($user !== "")
            {
                $id = $user;
            }

        	//현재 세션에 해당하는 유저의 정보를 바꾸기!!
        	$where = ['id' => $id];
        	$this->db->where($where);	        	
   
    		//사진 저장 시도 
    		$do_upload = $this->do_upload($id, 'upload');

    		if(isset($do_upload['data']))
    		{
    			//파일 이름을 쿼리에 추가한다.
    			 $data['img'] = $do_upload['data']['file_name'];
    		} 

    		//사진은 안되도 상관 x

    		//업데이트 쿼리 실행 성공시
    		if($this->db->update('user', $data) && $this->db->affected_rows() > 0)
    		{
                if($user == "")
                {
                     //추후 관리자 모드에서 사용할 시 이 코드는 return 이외에는 없어야 함. 세션 바꾸는 코드이므로..
                    $query = [
                        'from'   => 'user',
                        'where'  => ['id' => $id]
                    ];
                    $rs = $this->result->get_list($query, 'one');

                    $this->session->set_userdata('user', $rs['rs']);                  
                }
    			
    			return 1;
    		}
    		//달라진게 없다면
    		else
    		{
    			return 0;        		   		
        	}
        }

       public function delete($data)
        {
    		$this->db->where($data);
     
    		//삭제 성공시
    		if($this->db->delete('user') && $this->db->affected_rows() > 0)
    		{                 
    			return 1;
    		}
    		//실패시
    		else
    		{
    			return 0;                
    		}        	       	       	
        }
        public function check_perm($data)
        {
        	$id = $this->sess->get_id();   
     
        	$query = [
        		'from'   => 'user',
        		'where'  => [
	        		'id' => $id,
	        		'pw' => $data['pw']
	        	]
        	];
        	//data : id, pw만 빼내면 됨        
    		$rs = $this->result->get_list($query, 'one');
    		//var_dump($this->db->last_query());

    		if(isset($rs['rs']))
    		{
    			return 1;
    		}
    		else
    		{
    			return 0;
    		}         	
        }

        public function get_user_list()
        {
    
            $query = [
                'from' => 'user',
                'where' => ['perm' => '가입대기']
            ];       
            $rs = $this->result->get_list($query);
            
            if(!isset($rs['rs']))
            {
                $data['user1'] = 0;
            }
            else
            {
                $data['user1'] = $rs['rs'];
            }
            
            $query = [
                'from' => 'user',
                'where' => ['perm' => '일반']
            ];
            $rs = $this->result->get_list($query);
            if(!isset($rs['rs']))
            {
                $data['user2'] = 0;
            }
            else
            {
                $data['user2'] = $rs['rs'];
            }            
            return $data;
        }

        public function get_visit_list()
        {
            $query = [
                'from' => 'visit',
                'sort' => ['visited', 'desc']
            ];       
            $rs = $this->result->get_list($query);
            
            if(!isset($rs['rs']))
            {
                $data['visit'] = 0;
            }
            else
            {
                $data = $rs['rs'];             
                //var_dump($rs);
            }
            return $data;
        }
	}

