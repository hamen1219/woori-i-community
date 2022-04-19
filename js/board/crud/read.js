var clock_num = 0;
var clock_arr=['Bai Jamjuree, sans-serif', 'Fjalla One, sans-serif', 'Fredericka the Great, cursive', 'Sansita Swashed, cursive', 'Shrikhand, cursive'];

var object;

$(document).ready(function(){

	if(reply == "제한")
	{
		$('#reply_area').attr('disabled', true).attr('placeholder', '게시물 댓글 제한 상태입니다');
		$('#reply_btn').attr('disabled', true);	
	}
	
	//click을 통해 cnt 1씩 증가, cnt가 4가 되면 0으로 초기화 (다시 배열 처음부터)
	$('#clock').click(function(){		
		if(clock_num==4)
		{
			clock_num = 0;
		}
		else
		{
			clock_num += 1;
		}		
	});


	//댓글 카운트 메뉴 우측 아이콘 클릭시 toggle
	$(document).on("click","#reply_cnt svg",function(){
		$('#reply_slide').stop().slideToggle();  
	});

	$(document).on("click","#img_cut",function(){				
		$(this).next().toggleClass('writer_info_view');

	});

	$(document).on("click",".reply_img_cut",function(){
		if(object !== $(this)[0])
		{
			$('.reply_writer_info').removeClass('writer_info_view');
		}		
		$(this).next().toggleClass('writer_info_view');
		object = $(this)[0];
	});



	$("#foo").on("hover", function(e) {
	  if(e.type == "mouseenter") {
	    $("#foo").css('background-color', 'gray');
	  }
	  else if (e.type == "mouseleave") {
	    $("#foo").css('background-color', 'gray');
	  }
	});

	$('#map_btn').click(function(){
		$('#container').slideToggle(300);
	});


	//크롤링 슬라이드
	$('#crawling_slider').slick({
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 1000,
		vertical: true
    });

});

function ctrl_board(page, mode)
{
	if(mode == "update")
	{
		rs = confirm("게시물을 수정하시겠습니까?");
		if(rs)
		{
			location.href = "/board/update/page/"+page;
		}
		else
		{
			return;
		}
	}
	else if(mode == "delete")
	{
		rs = confirm("게시물을 삭제하시겠습니까?");
		if(rs)
		{
			delete_board(page);	
		}
		return;
	}
}
function delete_board(page)
{
	var code = 0;

	$.ajax({
		type: 'post',
		url : "/ajax/delete_board",
		dataType : 'json',
		data : {
			page : page
		},
		success: function(result){
			alert(result['msg']);
			if(result['code'])
			{
				location.href = "/board/list";
			}
		},
		error:function(request,status,error){
			document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}	
	});

	return code;
}

/**************************
=== ajax 통신 ===
$mode : good, poor, save 등 비동기통신으로 갱신
***************************/
function board_ajax(mode)
{
	$.ajax({
		type : 'post',
		url : '/ajax/like_b',
		dataType : 'json',
		data : {
			mode : mode,
			board_num : board_num
		},			
		success : function(result){

			if(result['code'])
			{			
				board_html(result['rs']);
			}
			else
			{
				alert(result['msg']);
			}
			
		},
		error:function(request,status,error){
			document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}	
	});		

}

function board_html(rs)
{
	//좋아요 눌린 다음의 버튼 내 숫자 및 색깔 바꾸어주기.
	// #good, #poor, #save
	// .css()
	// #good h5.html();

	//결과물 없을 때


	$('#good h5').html(rs['good']);

	if(rs['mygood'] === "1")
	{
		$('#good').css('background-color','skyblue').css('border-bottom', '5px solid purple');
	} 
	else
	{
		$('#good').css('background-color','rgba(20,20,20,0.1)').css('border-bottom', '0');
	}
	
	$('#poor h5').html(rs['poor']);
	if(rs['mypoor'] === "1")
	{
		$('#poor').css('background-color','red').css('border-bottom', '5px solid black');
	}
	else
	{
		$('#poor').css('background-color', 'rgba(20,20,20,0.1)').css('border-bottom', '0');
	}

	$('#save h5').html(rs['save']);
	if(rs['mysave'] === "1")
	{
		$('#save').css('background-color','lightgreen').css('border-bottom', '5px solid green');
	}
	else
	{
		$('#save').css('background-color', 'rgba(20,20,20,0.1)').css('border-bottom', '0');
	}
}

function reply_ajax(mode, object)
{	
	//댓글번호, 부모댓글번호, 댓글그룹번호
	reply_num = $(object).closest('.replys').children("input[name=reply_num]").val();		
	parent_num = $(object).closest('.replys').children("input[name=parent_num]").val();
	reply_group = $(object).closest('.replys').children("input[name=reply_group]").val();	


	//일반 댓글 쓰기 모드일때
	if(mode === "write")
	{
		contents = $('#reply_area').val();
		if(contents == "")
		{
			alert("댓글 내용을 입력하세요");
			return;
		}

		data = {
			contents : contents,
			board_num : board_num
		}
		
		url = "/ajax/reply_write";
	}

	//댓글 지우기 모드일때
	else if(mode === "delete")
	{			
		//confirm은 boolean 반환
		conf = confirm("댓글을 삭제하시겠습니까?");
		if(conf === true)
		{
			data = {
				reply_num : reply_num,
				board_num : board_num
			}
			url = "/ajax/reply_delete";
		}
		else
		{
			return;
		}
	}
	else if(mode === "update")
	{
		alert("ㄱㄷ");
	}

	//대댓글 작성 모드일때
	else if(mode === "re_reply_write")
	{

		//re_reply_write는 따로 뺌
		parent_num = $('#re_reply_write').children('input[name=parent_num]').val();
		reply_group = $('#re_reply_write').children('input[name=reply_group]').val(); 
		contents = $(object).closest('#re_reply_write').children('#re_reply_area').val();

		if(contents == "")
		{
			alert("대댓글 내용을 입력하세요");
			return;
		}
		
		data = {
			reply_group : reply_group,
			parent_num : parent_num,
			board_num : board_num,
			contents : contents
		}
		url = "/ajax/reply_write";
	}

	//좋아요와 싫어요 버튼을 눌렀을 때
	else if(mode === "good" || mode === "poor")
	{
		reply_num = $(object).closest('.replys').children('input[name=reply_num]').val();
		data = {
			mode : mode,
			reply_num : reply_num,
			board_num : board_num
		}
		url = "/ajax/like_r";	
	}

	//이외의 모드에서
	else
	{
		alert("Unknown mode");	
	}
	
	//reply_ajax 함수의 공통 ajax 코드
	$.ajax({
		type : 'post',
		url : url,
		dataType : 'json',
		data : data,
		success : function(result){

			if(result['code'])
			{
				reply_html(result['rs']);
			}
			else
			{
				alert(result['msg']);
			}
			//입력창 비우기
			$('#reply_area').val("");

		},
		error:function(request,status,error){
			document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}	
	});	
}

//object 값
var obj;
//대댓글 
function re_reply(object, parent_num, reply_group)
{
	//alert(parent_num);
	//현재 누른 오브젝트가 이전 누른 오브젝트와 다르다면? (맨처음 또는 다른 a 눌렀을 때)
	if($(object)[0] !== obj)
	{
		//현재 누른 오브젝트를 저장.
		obj = $(object)[0];
		//새로 생성.
		re_reply_html(object, parent_num, reply_group);
	}

	//현재 누른 오브젝트가 이전 누른 오브젝트와 같다면
	else
	{				
		//이미 만들어져 있는 상태이기 때문에 삭제, 생성 대신 toggle 사용.
		$('#re_reply_write').stop().slideToggle(200);
	}
}
//대댓글 입력창 그려주기
function re_reply_html(object, parent_num, reply_group)
{			
	//모든 re_reply 삭제후
	$('#re_reply_write').remove();
	html = "<div id = \"re_reply_write\">";
	html += "<input type = \"hidden\" name = \"parent_num\" value = \""+parent_num+"\">";
	html += "<input type = \"hidden\" name = \"reply_group\" value = \""+reply_group+"\">";
	html += "<div id = \"re_reply_title\"><p>ㄴ 답글쓰기</p></div>";

	html += "<textarea id = \"re_reply_area\" placeholder = \"내용을 입력하세요\"></textarea>";
	html += "<button id = \"re_reply_btn\" onclick = \"reply_ajax(\'re_reply_write\',this)\">작성</button>";
	html += "<div>";

	if(reply == "제한")
	{
		html += "<script> $('#re_reply_area').attr('disabled', true).attr('placeholder', '게시물 댓글 제한 상태입니다');	$('#re_reply_btn').attr('disabled', true); </script>";
	}
	
	$(object).closest('.reply_parent').after(html);	
	$('#re_reply_write').css({'display': 'none'}).slideDown(200);
}

function reply_html(result)
{
	if(result === undefined)
	{
		alert('error');
		return;
	}

	// reply div 내부 초기화
	$('#reply').html('');


	//댓글 없을 때 
	var str = '';

	if(result['num'] < 1)
	{
		str = '<div id = "reply_cnt"><h6>댓글 없음</h6></div>';
		$('#reply').append(str);
	}

	//댓글 있을 때
	else
	{
		str += "<div id = \"reply_cnt\">";
		str += "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-chat-square-dots\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"><path fill-rule=\"evenodd\" d=\"M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z\"/><path d=\"M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z\"/></svg>";
		str += " <h6>댓글("+result['num']+")</h6>";
		//svg
		str += "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-border-width\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-2zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z\"/></svg>";
		str += "</div>";

		// 댓글 슬라이더
		str += "<div id = \"reply_slide\">";

		for(var i=0; i<result['rs'].length; i++)
		{							
			var row = result["rs"][i];					

			//부모 댓글일때
			if(row["parent_num"] === null)
			{												
				str += "<div class = \"reply_parent replys\">";						
			}				
			else
			{
				str += "<div class = \"reply_child replys\">";						
			}		

			str += "<input type=\"hidden\" name = \"reply_num\" value = \""+row["num"]+"\">";	
			str += "<input type=\"hidden\" name = \"parent_num\" value = \""+row["parent_num"]+"\">";								
			str += "<input type=\"hidden\" name = \"reply_group\" value = \""+row["reply_group"]+"\">";		

			str += "<input type = \"hidden\" name = \"reply_num\" value = \""+row['num']+"\">";

			if(row['user'] !== undefined && row['user'] === user_id)
			{							
				str += "<div class = \"reply_modify\"><a onclick=\"reply_ajax(\'update\', this)\"><svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-pencil\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"> <path fill-rule=\"evenodd\" d=\"M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z\"/></svg></a> <a onclick=\"reply_ajax(\'delete\', this)\"><svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-x\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"><path fill-rule=\"evenodd\" d=\"M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z\"/></svg></a></div>";
			}			
		
								
			//이미지 및 이미지 cut div
			str += "<div class = \"reply_img_cut\">";
			if(row["user_img"] !== "")
			{						
				str += "<img src= \"/img/users/"+row["user"]+"/profile/"+row["user_img"]+"\" onerror = \"this.src=\'/img/error/no_img.png\'\">";
			}
			else
			{
				str += "<img src= \"/img/error/no_img.png\">";
			}
			str += "</div>";

			str += "<ul class = \"writer_info writer_info_hidden reply_writer_info\">";
		    str += "<li><a href=\"/user/myroom/"+row['user']+"\">유저상세보기</a></li>";
			str += "<li><a href=\"/board/list/사용자/"+row['user']+"\">작성글보기</a></li></ul>";
			// str += "<li><a href=\"\">쪽지보내기</a></li></ul>";

			str += "<h5>"+row["user"]+"</h5>";

			//댓글 내용 div
			str += "<div class = \"reply_contents\">";
			if(row['contents'] === "")
			{						
				str += "<b><p style = \"color: blue;\">작성자가 삭제한 댓글입니다</p></b>";
			}
			else
			{
				str += "<p>"+row['contents']+"</p>";
			}
			str += "</div>";

			//좋아요 div
			str += "<div class = \"reply_like\">";
				str += "<p>"+row["reply_created"]+"</p>";
				//버튼 div
				if(row['parent_num'] === null && row['contents'] !== '')
				{
					str += " <a class = \"re_reply_btn\" onclick=\"re_reply(this, "+row["num"]+", "+row["reply_group"]+")\">답글</a>";
				}
				str += "<div>";

				if(row['contents'] !== "")
				{
					if(row['mygood'] == "1")
					{
						str += "<button style = \'background-color:rgba(20,20,120,0.2);\' class = \'reply_btn_good\' onclick=\"reply_ajax(\'good\', this)\">공감 "+row["good"]+"</button> |";
						str += "<button style = \'background-color:transparent;\' class = \'reply_btn_poor\' onclick=\"reply_ajax(\'poor\', this)\">&nbsp;비공감 "+row["poor"]+"</button>";
					}
					else if(row['mypoor'] == "1")
					{
						str += "<button style = \'background-color:transparent;\' class = \'reply_btn_good\' onclick=\"reply_ajax(\'good\', this)\">공감 "+row["good"]+"</button> |";
						str += "<button style = \'background-color:rgba(20,20,120,0.2);\' class = \'reply_btn_poor\' onclick=\"reply_ajax(\'poor\', this)\">&nbsp;비공감 "+row["poor"]+"</button>";
					}
					else
					{
						str += "<button class = \'reply_btn_good\' onclick=\"reply_ajax(\'good\', this)\">공감 "+row["good"]+"</button> |";
						str += "<button class = \'reply_btn_poor\' onclick=\"reply_ajax(\'poor\', this)\">&nbsp;비공감 "+row["poor"]+"</button>";
					}							
				}
				else
				{
					str += "<button style = \"cursor: default;\" class = \'reply_btn_good\' >공감 "+row["good"]+"</button> |";
					str += "<button style = \"cursor: default;\" class = \'reply_btn_poor\' >&nbsp;비공감 "+row["poor"]+"</button>";
				}
					
				str += "</div>";

			str += "</div>";
			//좋아요 div 끝

			//parent 또는 child div 마무리
			str += "</div>";

		}
		//슬라이더 마무리
		str += "</div>";
		$('#reply').append(str);

		//jquery 문제로 script문 다시 작성해주기.
		str = "";
		//str += "<script>";		
		//str += "$('#reply_cnt svg').click(function(){$('#reply_slide').stop().slideToggle(1000);});";
		//str += "<\/script>";

		$('#left').after(str);
	}
}