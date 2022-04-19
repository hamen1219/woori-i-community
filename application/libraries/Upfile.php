<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//세션 라이브러리
class Upfile
{
  protected $CI; 

  public function __construct() //라이브러리 로드시 사용될 데이터
  {   
    $this->CI = & get_instance(); 
  }


  public function do_upload($file_name, $url, $config = "") 
  {  	
    //해당 경로가 유효하지 않으면 생성한다

      if(!file_exists($url))
      {          
          mkdir($url, 0777, TRUE); 
      }

      //기본 설정 값
      if($config == "")
      {
          $config =[];
          $config['upload_path']          = $url;
          $config['allowed_types']        = 'gif|jpg|png|jpeg';
          $config['max_size']             = 100000000;
          $config['max_width']            = 100000000;
          $config['max_height']           = 100000000;   
      }             

      $this->CI->load->library('upload', $config); //설정내용을 적용한 upload library 불러오기.

      //file 태그에서 받아온 파일 업로드 실패시...
       if(!$this->CI->upload->do_upload($file_name))
       { 
          return 0;

       }
       else
       {
          $rs = $this->CI->upload->data();
          return $rs['file_name'];
       }
    }

    
    //ck 에디터 이미지 첨부시 사용되는 ajax 이미지 업로드 및 파일명 추출 메서드
    public function ck_upload($url, $config= "") 
    {
      //사용자 지정 경로가 유효하지 않으면 생성
      if(!file_exists($url))
      {          
          mkdir($url, 0777, TRUE); 
      }

      //사용자 지정 config 없을 시 초기 값
      if($config == "")
      {
          $config = [];
          $config['upload_path']          = $url;
          $config['allowed_types']        = 'gif|jpg|png|jpeg|txt|hwp|ppt|pptx|php|exe|zip|css|js';
          $config['max_size']             = 100000000;
          $config['max_width']            = 100000000;
          $config['max_height']           = 100000000;   
      }               

       $this->CI->load->library('upload', $config); //설정내용을 적용한 upload library 불러오기.

       if(! $this->CI->upload->do_upload("upload")) //업로드 불러오기에 실패한다면
       {              
          var_dump("<p>path : ".$url."<hr/>error : ".$this->CI->upload->display_errors()."</p>");
       }
       else
       {              
          $func_num = $this->CI->input->get('CKEditorFuncNum');
          $data = $this->CI->upload->data();
          $filename= $data['file_name'];
 
          $url = substr($url,1).$filename;
          print "<script type = 'text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$func_num."', '".$url."', '전송에 성공했습니다')</script>";                                                           //이미지번호 , 연결 url
      }
       exit;     
    }
  } 
    
