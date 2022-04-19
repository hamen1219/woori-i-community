$(function(){

	$('#submit').click(function(){
		var name = $('input[name=name]').val();

		if(name == "")
		{
			alert("아동 이름을 입력하세요");
			return false;
		}
		else
		{
			$('section form').submit();
		}
	});
});