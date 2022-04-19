<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*********************************
=== 데이터베이스 결과 라이브라리===
**********************************/
class Result
{	
	//$this의 기능 저장될 변수
	protected $CI;

	public function __construct() //라이브러리 로드시 사용될 데이터
	{		
		//커스텀 라이브러리에 필요한 $this 객체 가져오기
		$this->CI = & get_instance();
	}

	/*********************************
	=== 쿼리에 따른 데이터 도출 함수 ===
	$arr : 쿼리 배열
	$mode : 도출 갯수 (1 row 또는 all row)
	return : rs, num (,error)
	**********************************/
	public function get_list($arr, $mode = "")
	{
		/*
			$arr의 구조
			===========
			select : 문자열 
  			from   : 문자열 또는 배열
			join   : 배열 내 배열
			group  : 문자열 또는 그룹
			having : 문자열 또는 배열
			where  : 믄지열 또는 배열
			like   : 문자열 
			start  : 정수
			end    : 정수
			sort   : attr, sort
		*/

		//select
		if(array_key_exists('select' , $arr)) 
		{
			$this->CI->db->select($arr['select']);
		}

		//from
		if(array_key_exists('from' , $arr)) 
		{
			$this->CI->db->from($arr['from']);
		}

		//join
		if(array_key_exists('join' , $arr)) 
		{
			//여러개의 조인
			if(isset($arr['join'][0]) && is_array($arr['join'][0]))
			{
				foreach($arr['join'] as $val)
				{
					//left또는 right 조인일 경우
					if(isset($val[2]))
	   				{
	   					$this->CI->db->join($val[0], $val[1], $val[2]);
	   				}
	   				else
	   				{
	   					$this->CI->db->join($val[0], $val[1]);  
	   				} 
				}
			}

			//한개의 조인
			else
			{
				//left 조인의 경우
				if(isset($val['join'][2]))
   				{
   					$this->CI->db->join($arr['join'][0], $arr['join'][1], $arr['join'][2]);
   				}
   				else
   				{
   					$this->CI->db->join($arr['join'][0], $arr['join'][1]);  
   				} 
   					 	
			}
		}

		//where
		if(array_key_exists('where' , $arr)) 
		{
			$this->CI->db->where($arr['where']);		
		}	

		if(array_key_exists('where_not_escape' , $arr)) 
		{		
			$this->CI->db->where($arr['where']);				
		}	

		//like
		if(array_key_exists('like' , $arr)) 
		{
			$this->CI->db->where($arr['like']);
		}

		//group_by
		if(array_key_exists('group' , $arr)) 
		{
			//여러개의 조건도 배열을 통해 group by 절에 등록된다.			
			$this->CI->db->group_by($arr['group']);					
		}

		//having
		if(array_key_exists('having' , $arr)) 
		{				
			$this->CI->db->having($arr['having']);
		}

		//order_by	
		if(array_key_exists('sort' , $arr))
		{
			//여러개 정렬 들어온 경우
			if(is_array($arr['sort'][0]))
			{			
				foreach ($arr['sort'] as $val) 
				{					
					$this->CI->db->order_by($val[0],$val[1]);	
				}				
			}
			//하나만 정렬 한다면 
			else
			{
				$this->CI->db->order_by($arr['sort'][0], $arr['sort'][1]);	
			}
		} 

		//limit
		if(array_key_exists('start' , $arr)) 
		{			
			if(array_key_exists('limit' , $arr)) 
			{
				$this->CI->db->limit($arr['limit'], $arr['start']);
			}
		}
		else
		{
			if(array_key_exists('limit' , $arr)) 
			{
				$this->CI->db->limit($arr['limit'], 0);
			}
		}

		////////////////////////////////////////
		// 조건 완료 후 query 실행
		////////////////////////////////////////

		//쿼리 오류시
		if(!$rs = $this->CI->db->get())
		{
			return 0;
		}

		//쿼리 실행시
		$num = $rs->num_rows();

		//결과값 없으면
		if($num < 1)
		{
			return 0;	
		}

		//결과값 있다면
		else
		{
			//data['num'] : 결과 요소 개수
			$data['num'] = $num;

			//1개 찾기모드
			if ($mode === 1)
			{
				//data['rs'] : 결과값
				$data = $rs->row_array();
			}
			//일반 모드
			else
			{
				if($mode == "num")
				{
					return $num;
				}
				$data['rs'] = $rs->result_array();
			}				
		}
		return $data;	
	}
} 