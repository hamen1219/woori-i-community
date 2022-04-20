 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

//페이지네이션 라이브러리
class Comp
{
	//CI $this 기능 담을 변수
	protected $CI;

	//생성자 메서드
	public function __construct()
	{		
		//$this->CI : $this
		$this->CI = & get_instance();
	}

	public function user($form)
	{		
		try 
		{		
			if(array_key_exists("tid", $form))
			{				
				$arr['id'] = $form['tid'];
			}
			if(array_key_exists("tpw", $form))
			{
				$arr['pw'] = password_hash($form['tpw'], PASSWORD_DEFAULT);
			}
			if(array_key_exists("tname", $form))
			{
				$arr['name'] = $form['tname'];
			}
			if(array_key_exists("addr_api", $form))
			{
				$addr = $form['addr_api'];	 	
				if(array_key_exists("addr", $form))
				{
					$addr .= " ".$form['addr'];						
				}
				$arr['addr'] = $addr;
			}
			if(array_key_exists("img", $form))
			{
				$arr['img'] = $form['img'];
			}
			if(array_key_exists("dept", $form))
			{
				$arr['dept'] = $form['dept'];
			}
			if(array_key_exists("perm", $form))
			{
				$arr['perm'] = $form['perm'];
			}
			if(array_key_exists("sex", $form))
			{
				$arr['sex'] = $form['sex'];
			}
			if(array_key_exists("intro", $form))
			{
				$arr['intro'] = $form['intro'];
			}
			if(array_key_exists("email", $form))
			{
				$arr['email'] = $form['email'];
			}
			if(empty($arr))
			{
				return 0;
			}				
			//var_dump($arr);
			return $arr;
		}
		catch (Throwable $e) 
		{
			return 0;
		}		

	}

	public function board($form)
	{
		$arr = [];
		try 
		{
			if(array_key_exists("tid", $form))
			{
				$arr['id'] = $form['tid'];
			}
			if(array_key_exists("title", $form))
			{
				$arr['title'] = $form['title'];
			}
			if(array_key_exists("contents", $form))
			{
				$arr['contents'] = $form['contents'];
			}
			if(array_key_exists("file", $form))
			{
				$arr['file'] = $form['file'];
			}
			if(array_key_exists("reply", $form))
			{				
				if($form['reply'] == "제한")
				{
					$arr['reply'] = "제한";
				}		
				else
				{
					$arr['reply'] = "허용";
				}		
			}
			else{
				$arr['reply'] = "허용";
			}
			if(array_key_exists("cat", $form))
			{
				$arr['cat'] = $form['cat'];
			}
			if(array_key_exists("updated", $form))
			{
				$arr['updated'] = $form['updated'];
			}
			if(array_key_exists("user", $form))
			{
				$arr['user'] = $form['user'];
			}
			if(array_key_exists("perm", $form))
			{
				$arr['perm'] = $form['perm'];
			}
			
			if(array_key_exists("addr", $form) && array_key_exists('addr_api', $form))
			{
				$arr['addr'] = $form['addr'];
				$arr['addr_api'] = $form['addr_api'];			
			}
			if(empty($arr))
			{
				return 0;
			}	
			return $arr;
		} 
		catch (Throwable $e) 
		{
			return 0;
		}
		
		
	}
}
