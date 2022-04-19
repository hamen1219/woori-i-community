$(document).ready(function(){
		$('#submit').click(function(){
			if($('#tid').val().length < 8 || $('#tid').val().length > 15){
				alert("아이디를 다시 입력하세요") ;		
			}
			else if($('#tpw').val().length < 7 || $('#tpw').length > 12){
				alert("패스워드를 다시 입력하세요") ;				
			}
			else if($('#rpw').val().length < 7 || $('#rpw').length > 12) {
				alert("패스워드 확인을 다시 입력하세요") ;			
			}
			else if($('#tname').val().length <= 1 || $('#tname').length > 12){
				alert("이름을 다시 입력하세요") ;			
			}
			else if($('#addr').val() == "" || $('#addr_api').val() == "" ){
				alert("주소를 다시 입력하세요") ;			
			}			
			else if($('#tpw').val() !== $('#rpw').val()){
				alert("패스워드가 일치하지 않습니다") ;			
			}
			else{get_ajax_join();}
			return false;
		});
		
		msg='';
		 
		$('#tid').keyup(function(event){
			str = $('#tid').val();
			if(str.length < 8 || str.length > 15){
				$('#alert_tid').html(msg).css({color: 'red'});
				msg = "길이 : 8-15";
				$('#alert_tid').html(msg).css({color: 'red'});
			}
			else
			{
				get_ajax();					
			}						
		});

		$('#tpw').keyup(function(event){
			str = $('#tpw').val();
			if(str.length < 7 || str.length > 12)
			{				
				msg = "길이 : 7-12";
				$('#alert_tpw').html(msg).css({color: 'red'});
				$('#alert_rpw').html("");
			} 
			else
			{
				if(str != $('#rpw').val())
				{
					msg = "PW 불일치";
					$('#alert_rpw').html(msg).css({color: 'red'});
					msg = "사용 가능한 PW";
					$('#alert_tpw').html(msg).css({color: 'black'});
				}
				else
				{
					msg = "사용 가능한 PW";
					$('#alert_tpw').html(msg).css({color: 'black'});
					msg = "일치";
					$('#alert_rpw').html(msg).css({color: 'black'});
				}
				
			}
		});

		$('#rpw').keyup(function(event){
			str = $('#rpw').val();			
			if(str !== $('#tpw').val()){
				msg = "PW 불일치";
				$('#alert_rpw').html(msg).css({color: 'red'});
			}
			else
			{
				if(str.length < 7 || str.length > 12)
				{
					msg = "길이 : 7-12";
					$('#alert_rpw').html(msg).css({color: 'red'});
				}
				else
				{
					msg = "일치";
					$('#alert_rpw').html(msg).css({color: 'black'});
				}
			}		
		});

		$('#tname').keyup(function(event){
			str = $('#tname').val();

			if(str.length < 2 || str.length > 12){
				msg = "길이 : 2-12";
				$('#alert_tname').html(msg).css({color: 'red'});
			}
			else{
				$('#alert_tname').html("");
			}						
		});

		$('#addr').keyup(function(event){
			str = $('#addr').val();

			if(str.length == 0){
				msg = "주소 입력 필수"
				$('#alert_addr').html(msg).css({color: 'red'});
			}
			else{
				str = $('#addr_api').val();
				if(str.length == 0)
				{
					$('#alert_addr').html(msg).css({color: 'red'});
				}
				$('#alert_addr').html("");
			}						
		});

		$('#email').keyup(function(event){
			str = $('#email').val();

			if(str.length == 0){
				msg = "이메일 주소 입력 필수"
				$('#alert_email').html(msg).css({color: 'red'});
			}
			else{
				str = $('#email').val();
				if(str.length == 0)
				{
					$('#alert_email').html(msg).css({color: 'red'});
				}
				$('#alert_email').html("");
			}						
		});
	});



function get_ajax(){ 
	//실시간으로 회원 아이디 정보 확인하여 화면에 뿌려주기.
	$.ajax({
		type : 'post',
		url : '/Ajax/get_ajax/id',
		dataType : 'json',
		data : 	
		{
			tid : $('#tid').val()	
		},
		success: function(result){								
			if(result['code'] == 0)
			{
				msg = "이미 사용중인 아이디";
				$('#alert_tid').html(msg).css({color: 'red'});
			}
			else if(result['code'] == 1)
			{
				msg = "사용 가능한 아이디";
				$('#alert_tid').html(msg).css({color: 'black'});;
			}

		},
		error:function(request,status,error){
			document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}	

function get_ajax_join()
{
	var data1 = new FormData($('form')[0]);

	$.ajax({
		type : 'post',
		url : '/Ajax/get_ajax/join',
		data: data1,
        processData: false,
        contentType: false,  
		dataType : 'json',
		//회원가입 버튼을 눌렀을 때 결과물.
		success: function(result){
			alert(result['msg']);
			if(result['code'] == "1")	
			{						
				location.href="/main/success_join";
			}
			else if(result['code'] == "-1")
			{
				location.href="/main/gta";
			}
			else
			{
				alert('회원가입 에러입니다');
			}
		},
		error:function(request,status,error){
			document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});			
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