<!--alert/success_join.php : 회원가입 성공 페이지-->

<!--외부 스타일 불러오기-->	
<link rel="stylesheet" type="text/css" href="/css/alert/success_join.css">

<section>	
	<script>
		var user = "";
	</script>

	<?php 
		$user = [
			'id' => 'ㅁㄷㅎㅁㄷㅎ',
			'name' => 'ㄷㅁㅎㄷㅁㅎ',
			'sex' => 'ㅁㅎㄷㄷㅁㅎ',
			'dept' => 'ㄷㄷㄷ', 
			'email' => 'ㄷㄷㄷ', 
			'addr' => 'ㅁㄷㅎㅁㄷ',
			'perm' => 'ㅁㄷㅎㅁㄷㅎㄷㅁ',
			'img'=>'ㄷㄷㄷ'
		];
	?>

	<!--가입 후 가입성공 페이지를 중복 진입한 경우 만료 페이지 (flashdata 사용으로 1회만 보여주고 만료됨)-->
	<?php if(!isset($user['id'])): ?>
		<div id = "join_title" class = "join_error">				
			<h3>만료된 페이지 :(</h3>
			<p>invalid page</p>	
		</div>
		<div id = "btn_group">
			<button id = "btn_error" onclick="location.href='/main'">홈으로</button>
		</div>

	<!--가입 후 가입성공 페이지 첫 진입시-->
	<?php else: ?>
		<script>
			user = "<?=$user['name']?>";
		</script>
		<div id ="join_title">
			<!-- <img id = "apeach" src="/img/join/1.gif" onerror="this.src = '/img/error/no_img.png'"> -->

			<div id = "join_title">		
				<h3><?=$user['id']?>님!! 가입을 축하합니다 :)</h3>
				<p>Congratuation</p>	
			</div>
		</div><hr>

	<!--사용자 정보 데이터-->
	<h5><b>사용자 정보</b></h5>
	<div id = "join_user_info">
		<div class="join_user_center">
			<div id = "join_user_img_div">
				<img id ="join_user_img" src="/img/users/<?=$user['id']?>/profile/<?=$user['img']?>" onerror = "this.src='/img/error/no_img.png'">
			</div>
			
			<table>		
				<tr>
					<td><p>ID</p></td>
					<td><p><?=$user['id']?></p></td>
				</tr>
				<tr>
					<td><p>이름</p></td>
					<td><p><?=$user['name']?></p></td>
				</tr>
				<tr>
					<td><p>성별</p></td>
					<td><p><?=$user['sex']?></p></td>
				</tr>
				<tr>
					<td><p>부서</p></td>
					<td><p><?=$user['dept']?></p></td>
				</tr>
				<tr>
					<td><p>이메일</p></td>
					<td><p><?=$user['email']?></p></td>
				</tr>
				<tr>
					<td><p>주소</p></td>
					<td><p><?=$user['addr']?></p></td>
				</tr>
				<tr>
					<td><p>상태</p></td>
					<td><p><?=$user['perm']?></p></td>
				</tr>
			</table>				
		</div>

		<!--버튼그룹-->
		<div id = "btn_group">
			<button id = "btn_home" onclick="location.href='/main'"><p>홈으로</p></button>
			<button id = "btn_login" onclick="location.href='/main/login'"><p>로그인</p></button>
		</div>		
	</div>
	<?php endif; ?>	
</section>

<!--외부 스크립트 불러오기-->	
<script src = "/js/alert/success_join.js"></script>
