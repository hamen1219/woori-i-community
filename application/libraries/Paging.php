 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

//페이지네이션 라이브러리
class Paging
{
	//CI $this 기능 담을 변수
	protected $CI;

	//생성자 메서드
	public function __construct()
	{		
		//$this->CI : $this
		$this->CI = & get_instance();
	}

	public function list($base_url,$total,$page, $list=10, $num=5)
	{
		//전체 링크 개수 계산하기
		$total_link = ceil($total/$list); 
		$block = ceil($page/$num);

		//한 페이지에 보여질 첫번째, 마지막 페이징 링크 계산하기		
		$first = (($block-1) * $num) + 1;
		$last = $block * $num ; 
		$last = $last < $total_link ? $last : $total_link;

		//이전, 다음 버튼 href 에 들어갈 페이지 번호
		$next = $last+1;
		$prev = $first-1 ;	

		//페이징 링크 문자열 초기화
		$link = ""; 
		$url = "";

		//1 페이지 초과 시 
		if($page > 1)
		{
			$url = $base_url."/page/1";
			$link_first= "<a class='paging' id = 'paging_first' href = '".$url."'>처음</a>";
			$link .= $link_first;
		}
		
		//1 권역 페이지 초과 시 
		if($block > 1)
		{
			$url = $base_url."/page/".$prev;
			$link_prev= "<a class='paging' id = 'paging_prev' href = '".$url."'>◁</a>";
			$link .= $link_prev;
		}
		
		//한 페이지에 보일 처음 ~ 마지막 페이지 번호 및 링크
		for($i = $first; $i <= $last; $i++)
		{
		 	$link_url = $base_url."/page/".$i;
		 	if($page == $i)
		 	{
		 		$link_paging = "<a class='paging now_page' href = '".$link_url."' ><b>{$i}</b></a>";	
		 	}
		 	else
		 	{
		 		$link_paging = "<a class='paging' href = '".$link_url."' >{$i}</a>";
		 	}
			
			$link .= $link_paging;
		}

		//마지막 권역 페이지 미만이면
		if($block < ceil($total_link/$num))
		{
			$url = $base_url."/page/".$next;
			$link_next= "<a class='paging' id = 'paging_next' href = '".$url."'>▷</a>";
			$link .= $link_next;
		}

		//마지막 페이지 미만이면
		if($page < $last)
		{
			$url = $base_url."/page/".$total_link;
			$link_last = "<a class='paging' id = 'paging_last' href = '".$url."'>끝</a>";
			$link .= $link_last;
		}
		//완성된 페이징 링크 반환
		return $link;
	}	

	//url에서 사용자가 지정한 key(segment)가 있는지 확인후 있으면 value 값(segment)를 도출 
	public function get_segment($key, $str="")
	{
		//현재 주소 문자열
		$uri_str = $str == "" ? urldecode($this->CI->uri->uri_string()) : $str;

 		//불필요한 형식 제거
		$len = strlen($uri_str);
 		if(substr($uri_str, -1) == "/")
		{
			$uri_str = substr($uri_str, 0, $len-1); 
		}
		//주소를 세그먼트 배열화
		$uri_arr = explode('/',$uri_str);	
		$cnt = count($uri_arr); 
		//요소 숫자만큼 검사하여 지정 문자열이 있을 경우 value 값 도출

		for ($i = 0; $i < $cnt; $i++) 
		{ 		
			if($uri_arr[$i] == $key && isset($uri_arr[$i+1]))
			{
				//key 뒤에 위치한 value 값 구하기
				$rs = $uri_arr[$i+1]; 


				//해당 key의 'value 반환'
				return $rs;
			} 			
		}
		return 0;
	}
}


