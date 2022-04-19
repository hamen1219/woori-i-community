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

	public function ctrl()
	{
		//form 검색시
		$form = $this->post->form();
		//form 검색 값 있을 때
		if($form !== null)
		{
			$search = isset($form['search']) && $form['search'] === "" ? "" : "/search/".$form['search'] ;			
			$type = isset($form['type']) ? "/type/".$form['type'] : "";
			$sort = isset($form['sort']) ? "/sort/".$form['sort'] : "";		
			$page_url = urldecode($base_url.$search.$type.$sort."/page/1");		
		}
		else
		{
			//uri 탐색
			$uri_str = urldecode($this->CI->uri->uri_string());
			$uri_arr = $this->segment_explode($uri_str);

			//조건받기	
			$search = $this->url_explode($uri_arr, 'search');	
			$type = $this->url_explode($uri_arr, 'type');	
			$sort = $this->url_explode($uri_arr, 'sort');		
			$page = $this->url_explode($uri_arr, 'page');	
		}

		//조건들을 모아 보내기

		$arr = [
			'search' => $search,
			'option' => $option,
			'sort'   => $sort,
			'user'   => $user,
			'cat'    => $cat 
		];

		$rs = $this->board->getBoardList($arr);

		$this->paging->
	
	}
}


