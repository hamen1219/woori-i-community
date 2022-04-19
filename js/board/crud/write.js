
//ck 그리다 , textarea에 , file 업로드 하는 컨트롤러 url로 연결 

$(document).ready(function(){
	//처음 시작시는 0 보내기

	CKEDITOR.replace('area',{'height' : 400,  'filebrowserUploadUrl' : base_url+'board_crud/upload'}); //board_crud 의 ck	
	var cat = $('input[name = ori_cat]').val();
	if(cat !== undefined && cat)
	{		
		//카테고리로 들어온 str의 값이 셀렉트에 없으면

		var cat_true = $('#cat').find('option[value = '+cat+']').val();
		if(cat_true !== undefined && cat_true != "")
		{
			$('#cat').val(cat_true).prop('selected', true);
		}
		//$('#cat').val()
		
	}

	if(board != "")
	{
		var cat = board['cat'];	

		$('#cat').val(board['cat']).attr("selected", "selected");	
		startArea();

		if(cat != "자기소개" && cat != "구인" && cat != "구직" && cat != "정모" && cat != "공지사항")
		{
			hideMap();
		}		
	}
	else{
		hideMap();
	}



	$('#map_btn').click(function(){
		$('#map_slide').slideToggle(200);
	});

	$('#keyword').keydown(function(e){
		if(e.keyCode == 13) {
			searchPlaces();
			return false;
		}
	});

	$('#cat').click(function(){
		select_temp = $("#cat option:selected").val();	
	});

});	

var select_temp = "";

function startArea()
{
	CKEDITOR.instances['area'].setData(board['contents']);

	

	if(board['reply'] == "제한")
	{
		$('#ck_reply').attr("checked", true); 
	}
}

function changeArea()
{
	var area = CKEDITOR.instances.area.getData();

	//셀렉트 선택 시 val 저장될 변수
	var mode = $("#cat option:selected").val();		
	str = area_html(mode);	

	var num = confirm('작성중인 내용이 변경됩니다. 계속하시겠습니까?');
	if(num)
	{
		//자동 생성될 텍스트 가져오기
		str = area_html(mode);	
		CKEDITOR.instances['area'].setData(str);		
	}			
	else
	{
		$("#cat").val(select_temp).prop("selected", true);	
	}
}
						


function area_html(mode)
{
	//자기소개
	var intro = "<table style = \"width:100%; border-collapse: collapse; border: 1px solid black; \" >";
		intro += "<tbody><tr><td style = \"text-align: center; height: 170px; width: 80px;\">프로필</td><td><em>상단 에디터를 이용해 이 칸에 사진을 첨부하세요</em><br></td></tr>";
		intro += "<tr><td style=\"width:80px\"><strong>&nbsp;이름</strong></td><td>"+user['name']+"</td></tr>";
		intro += "<tr><td style=\"width:80px\"><strong>&nbsp;아이디</strong></td><td>"+user['id']+"</td></tr>";
		intro += "<tr><td style=\"width:80px\"><strong>&nbsp;주소</strong></td><td>"+user['addr']+"</td></tr>";
		intro += "<tr><td><strong>&nbsp;부서</strong></td><td>"+user['dept']+"</td></tr>"; 
		intro += "<tr><td colspan=\"2\"><strong>&nbsp;▼ 자기소개 한마디</strong></td></tr>";
		intro += "<tr><td style = \"height:400px;\" colspan=\"2\"  style = \"text-align: center;\">본인에 대한 소개를 작성해주세요<br></td></tr></tbody></table>";		

	//건의사항
	var help = "<table style = \"width:100%; text-align: center; height: auto; border-collapse: collapse; border: 1px solid black; \" >";
		help += "<tr><td><b>건의내용</b></td></tr>";	
		help += "<tr><td style = \"height: 350px;\"></td></tr>";
		help += "</table>";		
	;	

	var qna = "<table style = \"width:100%; text-align: center; height: auto; border-collapse: collapse; border: 1px solid black; \" >";
		qna += "<tr><td><b>Q&A</b></td></tr>";	
		qna += "<tr><td style = \"height: 350px;\"></td></tr>";	
		qna += "</table>";		
	;	

	var job = "<table style = \"width:100%; text-align: center; height: auto; border-collapse: collapse; border: 1px solid black; \" >";
		
		job += "<tr><td style = 'width: 120px;'><b>담당자 연락처</b></td><td></td></tr>";
		job += "<tr><td><b>구인부서</b></td><td></td></tr>";
		job += "<tr><td><b>연봉</b></td><td></td></tr>";

		job += "<tr><td><b>기타</b></td><td></td></tr>";
		job += "<tr><td colspan = \"2\" style = \"height: 350px;\"></td></tr>";	
		job += "</table>";		
	;

	var meeting = "<table style = \"width:100%; text-align: center; height: 250px; border-collapse: collapse; border: 1px solid black; \" >";
		meeting += "<tr><td style = 'width: 80px;'><b>주최자</b></td> <td>"+user['name']+"</td></tr>";
		meeting += "<tr><td><b>주최장소</b></td> <td></td></tr>";
		meeting += "<tr><td><b>주최일시</b></td> <td></td></tr>";
		meeting += "<tr><td><b>연락처</b></td> <td></td></tr>";
		meeting += "<tr><td style = 'height:350px;' colspan = '2'></td></tr>";
		meeting += "</table>";
	
	;

	var str = "";
	switch(mode){	

		case "건의사항":
			str = help;		
			hideMap();	
			break;
		case "Q&A":
			str = qna;
			hideMap();
			break;
		case "자기소개":
			str = intro;
			showMap();
			break;
		case "채용":
			str = job;
			hideMap();
			break;;
		case "정모":
			str = meeting;
			showMap();
			break;
		default:
			hideMap();
			break;
	}
	return str;
} 
function showMap(){
	$('#map_btn').show();
	$('#map_slide').hide();

}
function hideMap(){
	$('#map_btn').hide();
	$('#map_slide').hide();
}

function form_submit()
{
	var area = CKEDITOR.instances.area.getData();
	var mode = $("#cat option:selected").val();		

	if($('#title').val() == "")
	{
		alert("제목을 입력하세요");
		return false;
	}
	else if(area == "")
	{
		alert("내용을 입력하세요");
		return false;
	}
	else if(mode == "정모")
	{
		addr = $('input[name=addr]').val();
   		addr_api = $('input[name=addr_api]').val();
   		if(addr_api == "" || addr_api ===undefined)
   		{
   			alert("정보 장소를 지정하세요");
   			return false;
   		}
   		
	}

}