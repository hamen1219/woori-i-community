<!--user/join.php : 회원가입 페이지-->  

<!--외부 스타일 불러오기-->
<link rel="stylesheet" type="text/css" href="/css/user/join.css">

<section>
	<!--사용자 데이터 입력 폼-->
	<form action="" method="POST" id = "f1" enctype="multipart/form-data" name="f1">	
		<h2>회원가입</h2><hr>
		<div id = "input_wrap">
			<div class = "input">
				<p>* 아이디</p>
				<input type="text" class = "form-control" id = "tid" name="tid" placeholder="아이디를 입력하세요">
			</div>
			<!--alert_** : 해당 input에 대한 alert msg로 조건 불만족시 script를 통해 해당 요소에 msg 추가됨-->
			<p id = "alert_tid" class = "input_alert_msg"></p>

			<div class = "input">
				<p>* 비밀번호</p>
				<input type="password" class = "form-control" id = "tpw" name="tpw" placeholder="비밀번호를 입력하세요" >
			</div>
			<p id = "alert_tpw" class = "input_alert_msg"></p>

			<div class = "input">
				<p>* 비밀번호확인</p>
				<input type="password" class = "form-control" id = "rpw" name="rpw" placeholder="비밀번호 확인">
			</div>	
			<p id = "alert_rpw" class = "input_alert_msg"></p>

			<div class = "input">
				<p>* 이름</p>
				<input type="text" class = "form-control" id = "tname" name="tname" placeholder="이름을 입력하세요">
			</div>
			<p id = "alert_tname" class = "input_alert_msg"></p>

			<div class = "input">
				<p>* 주소</p>
				<div id = "addr_wrap">
					<input type="text" class = "form-control" id = "addr_api" name="addr_api" placeholder="클릭하여 주소 찾기" onclick="addrClick()" readonly>
					<input type="text" class = "form-control" id = "addr" name="addr" readonly>
				</div>				
			</div>	
			<p id = "alert_addr" class = "input_alert_msg"></p>

			<div class = "input">
				<p>* 이메일</p>
				<input type="text" class = "form-control" id = "email" name="email" placeholder="이메일 주소를 입력하세요">		
			</div>

			<div class = "input">
				<p>상세</p>
				<div id = "select_wrap">
					<select name = "sex">
						<option selected>남자</option>
						<option>여자</option>
					</select>

					<select name = "dept">
						<option value = "학부모" selected>학부모</option>
						<option value = "교사">교사</option>
					</select>
				</div>			
			</div>	

			<div class = "input">
				<p>프로필</p>
				<input type="file"  name="img_file" id = "file">
			</div>
			<div id = "input_bottom"></div>
		</div>		

		<!--가입 버튼 그룹-->
		<div id = btn_group>
			<button id = "submit" value = "회원가입"><p>가입</p></button>
			<button onclick="location.href='/main'"><p>홈으로</p></button>
		</div>		
	</form>
</section>

<!--외부 스크립트 불러오기-->
<script src = "/js/user/join.js"></script>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>