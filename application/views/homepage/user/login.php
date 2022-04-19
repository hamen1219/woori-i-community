<!--user/login.php : 회원 로그인 페이지-->  

<!--외부 스타일 불러오기-->
<link rel="stylesheet" type="text/css" href="/css/user/login.css">

<section>	
	<div id = "f1">			
		<h2>로그인</h2><hr>
		<div id = "div_id">
			<p>ID</p> <input type="text" id = "tid" class="form-control" placeholder = "아이디 입력">
		</div>
		<div id = "div_pw">
			<p>PW</p> <input type="password" id = "tpw" class="form-control" placeholder = "비밀번호 입력" >
		</div>

		<!--회원 로그인 버튼-->
		<div id = "btn_group">			
			<button type="button" onclick="get_ajax()"><p>로그인</p></button>
			<button type="button" onclick="location.href = '/main/join'"><p>회원가입</p></button>
		</div>				
	</div>
</section>


<!--외부 스크립트 불러오기-->
<script src = "/js/user/login.js"></script>
