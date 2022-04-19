$(function(){
	$(function(){
		$('.top_btn').eq(2).addClass('btn_click');
		$('.msg_wrap').eq(2).addClass('msg_show');
	});
	$('.top_btn').click(function(){
		$('.top_btn').removeClass('btn_click');
		$(this).addClass('btn_click');
		var num = $(this).index();
		//alert(num);
		$('.msg_wrap').removeClass('msg_show');
		$('.msg_wrap').eq(num).addClass('msg_show');
	});
});