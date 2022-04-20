

//수정하기 버튼 한번 누른 이후 onclick 변경 위해 cnt 필요
var form_cnt = 0;

//최초 수정하기 버튼 기능 : 누르면 사용자 정보 수정 폼으로 변경
//한번 누른 이후 기능 : ajax로 폼 데이터 전송 기능   

var win;

function deleteBaby()
{
	var rs = confirm("삭제하시겠습니까?");
	return rs;			
}

function openPage(src, mode)
{
	//창이 있다면
	if(win != null)
	{
		win.close();
	}
	//창이 없다면

	if(mode == "update" || mode == "insert")
	{		

		win = window.open(src, "", "width=500,height=570");   
		win.onbeforeunload = function(){
			setTimeout('location.reload()',1);			  
	    };     

	}
	else if(mode == "msg")
	{
		win = window.open(src, "", "width=500,height=700");  
	}		      

}


function update_form(mode)
{
	//수정하기 처음 눌렀을 때
	if(form_cnt === 0)
	{
		//사용자 ID, PW 받아오기
		id = $('input[name=tid]').val();

		// //회원 수정시 관리자, 부관리자는 pw 입력 x
		// if(mode != "admin")
		// {
		// 	pw = prompt("비밀번호를 입력하세요");
		// 	if(pw.length < 4)
		// 	{
		// 		alert("비밀번호 길이가 짧습니다");
		// 		return;
		// 	}
		// 	//사용자 정보 확인되면
		// 	if(!check_perm(id, pw))
		// 	{
		// 		alert("비밀번호가 일치하지 않습니다");
		// 		return;
		// 	}
		// }
				
		//data : 최초 사용자 정보 저장될 공간.
		//input으로 바꾸어 준 후 data에 보관해 둔 이전 데이터 넣어주기.

		data = $('p[name=tname]').text();
		str = "<input type = 'text' name = 'tname' class = 'form-control' value = '"+data+"'>";
		$('#us1_info tr:eq(0) td:last-child').html(str);

		data = $('p[name=img]').text();
		str = "<input type = 'password' name = 'tpw' class = 'form-control' placeholder='입력 시 PW 수정됩니다.'>";
		$('#us1_info tr:eq(1) td:last-child').html(str);
		
		str = "<input type = 'file' id = 'file' class = 'form-control' name = 'img_file' enctype='multipart/form-data'>";
		$('#us1_info tr:eq(2) td:last-child').html(str);

		//원래 주소 정보 합쳐서 보여주기.
		data = $('p[name=addr_api]').text() + $('p[name=addr]').text() ;
		
		url = "<input type = 'text' id ='addr_api' class = 'form-control' name = 'addr_api' placeholder='클릭하여 주소입력' readonly>";
		if(data != "")
		{
			url += "<input type = 'text' id ='addr' class = 'form-control' placeholder='나머지 주소 입력' name = 'addr'>";
		}
		else
		{
			url += "<input type = 'text' id ='addr' class = 'form-control' name = 'addr' readonly>";			
		}
		$('#us1_info tr:eq(3) td:last-child').html(url);
		

		data = $('p[name=email]').text();
		$('#us1_info tr:eq(4) td:last-child').html("<input type = 'email' class = 'form-control' name = 'email' value ='"+data+"'>");

		data = $('p[name=intro]').text();
		$('#us1_info tr:eq(5) td:last-child').html("<input type = 'text' class = 'form-control' name = 'intro' value ='"+data+"'>");

		//버튼 텍스트 및 기능 바꾸어 주기
		$("#update_btn").children('p').text('수정하기');			
		$("#update_btn").attr('onclick', 'update_user()');
		form_cnt++;
	}			
}		

$(document).on("click","#addr_api",function(){
	addrClick();
});

//confirm 창에 비밀번호 입력 시 유저 id, pw 검증에 사용되는 ajax 함수
// function check_perm(id, pw)
// {		
// 	var code;
// 	$.ajax({
// 		type : 'post',
// 		dataType : 'json',
// 		url : '/ajax/check_perm',			 
// 		data : {
// 			id : id,
// 			pw : pw
// 		},
// 		async : false,
// 		success : function(result){
// 			//비번 일치시
// 			code = result['code'];				
// 		},
// 		error:function(request,status,error){
// 			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
// 			//return 0;
// 		}
// 	});
// 	return code;
// }

//유저 정보 수정 시
function update_user()
{
	var addr_api = $('#addr_api').val();
	var addr = $('#addr').val();
	var email = $('input[name = email]').val();


	if(addr_api != "" && addr == "")
	{
		alert("상세 주소를 입력하세요");
		return false;
	}
	else if(email == "")
	{
		alert("이메일 주소를 입력하세요");
		return false;
	}

	//수정 시 관리자 포함 모든 사용자의 비번은 입력되어야 한다.

	$.ajax({
		url : '/ajax/update_user',
		type : 'post',
		dataType : 'json',
		contentType: false,
    	processData: false,
	
		data : new FormData($("form")[0]),
		success : function(result){
			//결과 또는 오류 표시			
			alert(result['msg']);
			if(result['code'] == 1)
			{
				location.reload();
			}
		},
		error:function(request,status,error){
			document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});

}
//유저 탈퇴 시
function delete_user(mode)
{
	
	//사용자 ID, PW 받아오기
	id = $('#user_id').val();

	//회원 수정시 관리자, 부관리자는 pw 입력 x
	// if(mode != "admin")
	// {
	// 	pw = prompt("비밀번호를 입력하세요");
	// 	if(pw.length < 4)
	// 	{
	// 		alert("비밀번호 길이가 짧습니다");
	// 		return;
	// 	}
	// 	//사용자 정보 확인되면
	// 	if(!check_perm(id, pw))
	// 	{
	// 		alert("비밀번호가 일치하지 않습니다");
	// 		return;
	// 	}
	// }

      id = $('#user_id').val() ;
	// pw = prompt('비밀번호를 입력하세요');
	// if(pw === null)
	// {
	// 	return;
	// }

	// if(check_perm(id, pw))
	// {
		$.ajax({
			url : '/ajax/delete_user',
			type : 'post',
			dataType : 'json',
			data : {
				id : id,
				pw : pw				
			},
			success : function(result){
				//결과 또는 오류 표시.					

				//성공적으로 탈퇴되었다면 메인 페이지로
				if(result['code'])
				{
					location.reload();
					location.href = "/user/logout";			
				}					
			}
			,
			error:function(request,status,error){
				document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	// }
}

function addrClick()
{
	new daum.Postcode({
    oncomplete: function(data) {
        $('#addr_api').val(data['roadAddress']);
        $('#addr').attr({'readonly' : false, 'placeholder' : '나머지 주소 입력'});
    }
	}).open();
}