

$(function(){

	var cnt = $('input[name = unread_msg_cnt]').val();
	if(cnt !== undefined && cnt > 0)
	{
		$('#alert_unread_msg').slideDown('200');
	}

	$('#alert_unread_msg svg').click(function(){
		$('#alert_unread_msg').slideUp('200');
	});

	$('input[name = all_search]').keydown(function(e){
		if(e.keyCode == 13) {
			all_search();
		}
	});

	$('#all_search_btn').click(function(){
		$('#all_search_wrap').stop().fadeToggle(200);
	});

	$('#m_nav_btn').click(function(){
		$('#m_nav_wrap').stop().fadeIn(200);
	});
	$('#m_nav_close_btn').click(function(){
		$('#m_nav_wrap').stop().fadeOut(200);
	});
	$('#m_nav_ul>li').click(function(){
		$('#m_nav_ul ul').slideUp();
		$('#m_nav_ul>li').removeClass('m_nav_ul_toggle');
		$(this).toggleClass('m_nav_ul_toggle');
		$('ul',this).stop().slideToggle();	
	});



	$('#topper').hover(function(){
		$(this).animate({height: '80px'}, 250);
	}, function(){
		$(this).animate({height: '60px'}, 250);
	});

	//nav 버튼 hover(자체 css 변경)
	$('#nav_ul>li').hover(function(){
		$(this).css({'background-color':'lightgray', 'border-bottom' : '2px solid gray'});
	},function(){
		$(this).css({'background-color':'white', 'border-bottom' : 'none'});
	});

	//nav 버튼 hover(하단 메뉴 슬라이드)
	$('.btn_menu').hover(function(){		
		$('.slide_menu', this).stop().slideDown(500);
		$('table', this).stop().fadeIn(300);
		$('#wrap').stop().slideDown(500);			
		$('.table_title_div h3').stop().fadeIn(1000);
	}, function(){
		$('.slide_menu', this).stop().slideUp(500);
		$('table', this).stop().fadeOut(300);
		$('#wrap').stop().slideUp(500);		
		$('.table_title_div h3').stop().fadeOut(100);	
	});
});
function logout()
{
	location.href = '/user/logout';
	//로그아웃에 필요한 코드....
}
function all_search()
{
	var search = $('input[name=all_search]').val();
	if(search == "")
	{
		alert("검색어를 입력하세요");
		return;
	}
	else
	{
		location.href ="/board/list/전체게시물/search/"+search;
	}


}