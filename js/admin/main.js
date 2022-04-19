CKEDITOR.replace('email_area',{'height' : 400,  'filebrowserUploadUrl' : '/board_crud/upload/email'}); //board_crud 의 ck
			//ck 그리다 , textarea에 , file 업로드 하는 컨트롤러 url로 연결 

			//ck 그리다 , textarea에 , file 업로드 하는 컨트롤러 url로 연결 	

$(function(){
	$('.btn_slide').click(function(){
		if($(this).attr('id') != "btn_admin_board")
		{
			$(this).next().stop().slideToggle(300);
		}
		
	});

	$('#btn_blind').click(function(){
		if($('#btn_blind').prop('checked')){
			$('input[name=board_list_blind]').prop('checked',true);

		}else if(!$('#btn_blind').prop('checked')){
			$('input[name=board_list_blind]').prop('checked',false);
			}
	});

	$('#btn_delete').click(function(){
		if($('#btn_delete').prop('checked')){
			$('input[name=board_list_delete]').prop('checked',true);

		}else if(!$('#btn_delete').prop('checked')){
			$('input[name=board_list_delete]').prop('checked',false);
			}
	});

	var list = [];				


	//전체선택 체크박스

	


	$('input[name = all_delete]').click(function(){
		if(this.checked == true)
		{
			$(this).closest('table').find('input[name=delete]').prop('checked', true);
		}
		else
		{
			$(this).closest('table').find('input[name=delete]').prop('checked', false);
		}	
	});

	$('input[name = all_email]').click(function(){
		if(this.checked == true)
		{
			$(this).closest('table').find('input[name=email]').prop('checked', true);
		}
		else
		{
			$(this).closest('table').find('input[name=email]').prop('checked', false);
		}	
	});


	$('input[name = delete_class_all]').click(function(){
		if(this.checked == true)
		{
			$(this).closest('table').find('input[name=delete_class]').prop('checked', true);
		}
		else
		{
			$(this).closest('table').find('input[name=delete_class]').prop('checked', false);
		}	
	});

	$('input[name = delete_baby_all]').click(function(){
		if(this.checked == true)
		{
			$(this).closest('table').find('input[name=delete_baby]').prop('checked', true);
		}
		else
		{
			$(this).closest('table').find('input[name=delete_baby]').prop('checked', false);
		}	
	});





});



function ctrl_user(user, mode)
{
	//user에 대한 mode(delete, upgrade)
	//mode : delete, empty, common, sub_admin
 	
 	switch(mode)
 	{
 		case "delete":
 			var rs = confirm("해당 회원을 삭제하시겠습니까?");

 			break;
 		default:
 			var rs = confirm("회원 정보를 수정하시겠습니까?");
 			break;
 	}

	if(rs)
	{
		$.ajax({
			type: 'post',
			dataType : 'json',
			url : '/ajax/ctrl_user',
			data : {
				id : user,
				mode: mode
			},
			success : function(result)
			{
				alert(result['msg']);
				if(result['code'])
				{
					location.reload();
				}
			},
			error:function(request,status,error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				//return 0;
			}
		});
	}	
}


		
//이메일 보내는 함수. 전체 user 상대로 가져오기
function sendEmail()
{
	user = $(this).closest('tr').children('input[name=id]').val();
	var arr = [];
	var title = $('input[name=title]').val();
	var contents = CKEDITOR.instances.email_area.getData();


	//체크된 사용자들을 가져오기
	$('input[name=email]:checked').each(function(){
		arr.push($(this).val());						
	});

	if(arr.length === 0)
	{
		alert("이메일 수신 회원을 선택하세요");
		return false;
	}			

	else if(contents == "")
	{
		alert("이메일 내용을 입력하세요");
		return false;
	}
	else if(title == "")
	{
		alert("이메일 제목을 입력하세요");
		return false;
	}

	mode = "email";

	data = {
		arr : arr,
		title : title,
		contents : contents,
	};

	//arr는 이메일 주소들..
	getAjax(mode, "/ajax/sendEmail",data);
}


function deleteUser()
{
	var arr = [];

	//체크된 사용자들을 가져오기

	$('input[name=delete]:checked').each(function(){						
		arr.push($(this).val());
	});

	if(arr.length === 0)
	{
		alert("삭제할 유저를 선택하세요");
		return;
	}

	mode = "delete";
	getAjax(mode, "/ajax/ctrl_user", arr);
}

function updateUser()
{
	var arr = [];
	//select와 userid 가져온다.

	$('select[name = perm] option:selected').each(function(){
		perm = $(this).val();
		user = $(this).closest('tr').children('input[name=id]').val();
		mode = "update";

		//alert(user);

		data = {
			perm : perm,
			id : user
		}						
		arr.push(data);					
	});			

	getAjax(mode, '/ajax/ctrl_user',arr);
}

//======================================================================

//아동
function updateBaby()
{
	arr = [];
	//복수의 아동 불러오기
	$('.baby_table tr:eq(1)').nextAll('tr').each(function(){


		//where문
		parent = $(this).find('input[name = baby_parent]').val();
		name = $(this).find('input[name = baby_name]').val();

		//update문
		class_name = $(this).find('select[name = select_baby_class]').val();

		data = {
			where : {
				parent : parent,
				name : name
			},
			query : {
				class : class_name
			}
		};

		arr.push(data);
	});


	getAjax("", "/ajax/update_baby", arr);
}

function deleteBaby()
{
	arr = [];
	$('input[name = delete_baby]:checked').each(function(){

		//where문
		parent = $(this).closest('tr').find('input[name = baby_parent]').val();
		name = $(this).closest('tr').find('input[name = baby_name]').val();

		//where문
		data = {
			parent : parent,
			name : name
		};
		arr.push(data);
	});

	if(arr.length < 1)
	{
		alert("삭제할 아동 정보를 선택하세요");
		return false;
	}

	getAjax("", "/ajax/delete_baby", arr);
}

//////////////////////////////////////////////학급


function createClass(){
	class_name = $('input[name=class_name]').val();
	teacher = $('select[name=class_select]').val();
	comment = $('#class_comment').val();

	if(class_name == "")
	{
		alert("반 이름을 입력하세요");
		return false;
	}
	else if(comment == "")
	{
		alert("코멘트 내용을 입력하세요");
		return false;
	}

	arr = {
		name : class_name,
		comment : comment
	};
	if(teacher != "교사없음" && teacher != "미지정")
	{
		arr.teacher = teacher;
	}

	getAjax("", "/ajax/create_class", arr);					
}

function updateClass()
{
	arr = [];
	$('.class_table tr:eq(0)').nextAll('tr').each(function(){

		//where문
		ori_class_name = $(this).closest('tr').find('input[name = ori_class_name]').val();

		//update문
		class_name = $(this).closest('tr').find('input[name = update_class_name]').val();
		teacher = $(this).closest('tr').find('select[name = update_class_teacher]').val();
		comment = $(this).closest('tr').find('textarea[name = update_class_comment]').val();


		data = {
			where : {
				name : ori_class_name
			},
			query : {
				name : class_name,				
				comment : comment,
				teacher : teacher
			}			
		};

		if(teacher == "미지정")
		{
			data.query.teacher = null;
		}

		arr.push(data);
	});

	getAjax("", "/ajax/update_class", arr);

}
function deleteClass()
{
	arr = [];
	$('input[name = delete_class]:checked').each(function(){

		//where문
		class_name = $(this).closest('tr').find('input[name = ori_class_name]').val();

		data = {
			name : class_name
		};

		arr.push(data);
	});

	if(arr.length < 1)
	{
		alert("삭제할 학급 정보를 선택하세요");
		return false;
	}
	
	getAjax("", "/ajax/delete_class", arr);

}
//===================================================================

function getAjax(mode, url, arr)
{
	data  = {
		mode : mode,
		arr : arr
	};

	var code = 0;

	$.ajax({
		type: 'post',
		dataType : 'json',
		url : url,
		data : data,
		success: function(result){
			alert(result['msg']);
			if(result['code'])
			{
				location.reload();
			}				
		},
		error : function(){
			alert("fail");
		}
	});
	
}				 	



function update_board(page)
{
	rs = confirm("게시물 수정페이지로 이동하시겠습니까?");
	if(rs)
	{		
		location.href = "/board/update/page/"+page;
	}
	return;
}

//게시물 관리 함수 (mode : delete, blind))
function ctrl_board(mode)
{	
//체크박스 중 체크된 val 배열에 담기.
	var arr = [];

	//제거 클릭시 
	if(mode == 'delete')	
	{
		$('input[name=board_list_delete]:checked').each(function(){
	    	arr.push($(this).val());			    	
		});	
		rs = confirm("해당 게시물을 삭제하시겠습니까");
	}		
	else
	{  				
		$('input[name=board_list_blind]:checked').each(function(){
	    	arr.push($(this).val());			    	
		});	
		rs = confirm("해당 게시물을 블라인드 처리하시겠습니까");
	}	
	var url = "/ajax/ctrl_board";

	if(rs)
	{
		$.ajax({
			type: 'post',
			dataType : 'json',
			url : url,
			data : {
				page : arr,
				mode : mode
			},
			success : function(result)
			{
				alert(result['msg']);
				if(result['code'])
				{
					location.reload();
				}
			},
			error:function(request,status,error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				//return 0;
			}
		});
	}		
}
function intro_write()
{
	var contents = $('#intro_area').val();
	if(contents == "")
	{
		alert("대문 글을 작성해주세요");
		return;
	}

	$.ajax({
		type : 'post',
		dataType : 'json',
		url : '/ajax/intro_write',
		data : {
			contents : contents
		},
		success : function(result){
			alert(result['msg']);
			if(result['code'])
			{
				location.reload();
			}
		},
		error:function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			//return 0;
		}
	}); 	
}
