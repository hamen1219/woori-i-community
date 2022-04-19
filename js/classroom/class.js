$(function(){
	var cnt = 0;
	//알림장 작성은 teacher 모드일 때만 작동된다.
	$('.teacher').click(function(){
		$('.teacher').removeClass('selected_baby');
		$(this).addClass('selected_baby');

		var parent = $(this).find('input[name = parent]').val();
		var baby = $(this).find('input[name = baby]').val();
		if(cnt)
		{
			$('#baby_alert').remove();
		}
		var str = "<div id = 'baby_alert'><h5><b>아동 특이사항 전달</b></h5><hr/>";
		str += "학부모 : "+parent+", 자녀 : "+baby;
		str += "<br/><div><textarea name = 'baby_area' placeholder = '전달 내용을 입력하세요'></textarea>";
		str += "<button onclick = 'insertNotice(\"baby\");'>전달</button><div id = 'baby_bottom'></div></div>";
		str += "<input type = 'hidden' value = '"+parent+"' name = 'parent'>";
		str += "<input type = 'hidden' value = '"+baby+"' name = 'baby'></div>";

		$('#baby_div').append(str);

		cnt++;
	});
});

//소개글 입력하기
function insertClassComment()
{
	var comment = $('textarea[name = comment_area]').val();
	var class_name = $('input[name = class_name]').val();
	var user = $('textarea[name = user]').val();

	if(comment == "")
	{
		alert('학급 소개글을 입력하세요');
		return false;
	}
	var data = {
		name : class_name,
		comment : comment,
		user : user
	};
	var url = "/ajax/insert_class_comment";
	getAjax(url, data);
	setTimeout(1);
	location.reload();
}


function insertBoard()
{
	var contents = $('textarea[name = class_contents]').val();
	var user = $('input[name = user]').val();
	var class_name = $('input[name = class_name]').val();

	if(contents == "")
	{
		alert("내용을 입력하세요");
		return false;
	}
	var url = "/ajax/insert_class_board";

	var data = {
		user : user,
		contents :  contents,
		class : class_name
	};
	getAjax(url, data);
	setTimeout(1);
	location.reload();
}
function deleteBoard()
{
	var url = "/ajax/delete_class_board";		
	getAjax(url, data);
}

//알림장 작성
function insertNotice(mode)
{
	//user, class, msg
	var contents = $('textarea[name = notice_area]').val();
	var user = $('input[name = user]').val();
	var class_name = $('input[name = class_name]').val();
	var url = "/ajax/insert_class_notice";		

	if(mode == "baby")
	{
		url = "/ajax/insert_class_notice/baby";
		contents = $('textarea[name = baby_area]').val();
	}

	if(contents == "")
	{
		alert("내용을 입력하세요");
		return false;
	}		

	var data = {
		user : user,
		msg :  contents,
		class : class_name
	};


	if(mode == "baby")
	{
		data.parent = $('#baby_alert').find('input[name = parent]').val();
		data.baby = $('#baby_alert').find('input[name = baby]').val();
	}

	getAjax(url, data);
}

function getAjax(url,data){

	$.ajax({

		type : 'post',
		dataType : 'json',
		url : url,
		data : data,

		success : function(result)
		{
			alert(result['msg']);
		},
		error : function()
		{
			alert('error');
		}

	});
};
