$(function(){
	var ori_class = $('input[name=ori_class]').val();
	var old = $('input[name=ori_old]').val();


	//셀렉트 박스의 값을 val에 해당하는 것으로 바꾸어준다.

	if(ori_class != "" && ori_class != undefined )
	{
		$('select[name = class]').val(ori_class).prop('selected', true);
	}
	else
	{
		html = "<option>미지정</option>";
		$('select[name = class]').prepend(html);
		$('select[name = class]').val("미지정").prop('selected', true);
	}

	if(old != "" && old != undefined )
	{
		$('select[name = old]').val(old).prop('selected', true);
	}

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
