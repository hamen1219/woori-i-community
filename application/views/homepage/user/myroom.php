<!--user/myroom.php : 회원 마이룸 페이지-->  

<!--외부 스타일 불러오기-->
<link href="https://fonts.googleapis.com/css2?family=Song+Myung&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/user/myroom.css">

<section>
	<!--상단 div-->
	<div id = "s_top" class = "s_base">
		<!-- 사용자 이미지 -->
		<div id = "my_img_cut">
			<img src="/img/users/<?=$us['id']?>/profile/<?=$us['img']?>" onerror = "this.src = '/img/error/no_img.png'">				
		</div>

		<!-- 사용자 정보 -->
		<div id = "my_title">
			<div id = "us_info">
				<h1><?=$us['id']?>님의 마이룸입니다</h1>&nbsp;&nbsp;					
				<div><?=$us['perm']?></div>					
				<?php if($us['dept'] != "관리자"): ?>
					<div><?=$us['dept']?></div>
				<?php endif; ?>
			</div>
			<p>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
				  <path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
				</svg>
				가입일 : <?=$us['created']?>
			</p>
			<?php if($visit_latest): ?>
				<p>	
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
					  <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
					  <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					</svg>
					최근 로그인 한 시각 : <?=$visit_latest['visited']?>
				</p>
			<?php endif; ?>
			<p>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wifi" viewBox="0 0 16 16">
				  <path d="M15.385 6.115a.485.485 0 0 0-.048-.736A12.443 12.443 0 0 0 8 3 12.44 12.44 0 0 0 .663 5.379a.485.485 0 0 0-.048.736.518.518 0 0 0 .668.05A11.448 11.448 0 0 1 8 4c2.507 0 4.827.802 6.717 2.164.204.148.489.13.668-.049z"/>
				  <path d="M13.229 8.271c.216-.216.194-.578-.063-.745A9.456 9.456 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.577 1.336c.205.132.48.108.652-.065zm-2.183 2.183c.226-.226.185-.605-.1-.75A6.472 6.472 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.408.19.611.09A5.478 5.478 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.611-.091l.015-.015zM9.06 12.44c.196-.196.198-.52-.04-.66A1.99 1.99 0 0 0 8 11.5a1.99 1.99 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .708 0l.707-.707z"/>
				</svg>
				현재 접속 아이피 : <?= $_SERVER["REMOTE_ADDR"] ?>
			</p>
		</div>
		<!--float 제거 div-->
		<div class = "bottom"></div>
	</div>

	<!-- 관리자 및 부관리자 버튼 그룹 (관리자 및 부관리자일 경우만 출력) -->	
	<?php if(($us['perm'] == "관리자" || $us['perm'] == "부관리자" ) && $us['id'] == $user['id']): ?>			
		<div id = "admin_btn_group">
			<a class = "admin_btn" href="/admin">
				<h4>
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
					</svg> &nbsp;
					관리자 페이지 접속하기
				</h4>
			</a>
			<a class = "admin_btn" href="/board/list/운영진">
				<h4>
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cursor-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
					</svg> &nbsp;
					운영진 커뮤니티
				</h4>
			</a>
			<!--float 제거 div-->
			<div class = "bottom"></div>					
		</div>							
	<?php endif; ?>

	<!--학부모일 경우 아동 관리 div 보이기-->
	<?php if(isset($baby)): ?>
		<!--학부모일 경우 아동 추가 및 수정 div 보이기-->
		<?php if($us['dept'] == "학부모" || $us['perm'] == "관리자"): ?>
			<div id = "baby_wrap">
				<h4 class ="s_title">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
					  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
					  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
					</svg>
					내 아동 관리
				</h4>
				<div id = "msg_info">					
					<div id = "msg_cnt">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
						  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
						</svg>
						<p>1:1 메세지 </p>
						<p class = "msg_cnt"><?=$msg_cnt?></p> 
						<p>읽지 않음 </p>
						<p class = "msg_cnt"><?=$unread_msg_cnt?></p>
					</div>

					<div id = "baby_cnt">
						<p>등록 아동 : <?=$num = $baby ? $baby['num'] : 0?>명</p> 
					</div>
				</div>	

				<!--아동 리스트-->
				<div id = "baby_list">				
					<!--아동 추가 버튼-->
					<a href = "#" onclick= "openPage('/baby/add_baby', 'insert');">	
						<div id = "baby_add_btn" class = "baby_info_list">					
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
							  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
							  <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
							</svg>
							<p>클릭하여 아동추가</p>
						</div>
					</a>

					<!--세션 본인의 마이룸 접속한 경우-->			
					<!--등록된 아동 있을 경우-->
					<?php if($baby): ?>
						<!--등록된 아동 전체 보이기-->
						<?php foreach($baby['rs'] as $row): ?>
							<div class = "baby_info_list">
								<!--아이 메세지 확인하기-->
								<a href = "#" onclick= "openPage(`/user/msg/<?=$row['name']?>/<?=$row['class']?>`, 'msg');">									
									<div class = "baby_img_cut">
										<img src="/img/users/<?=$row['parent']?>/baby/<?=$row['img']?>" onerror="this.src = '/img/error/no_img.png'">					
									</div>
								</a>
								
								<p><b><?=$row['name']?></b></p>
								<p><?=$row['old']?></p>

								<!--학급 방문 링크-->
								<?php if($row['class'] !== null) :?>
									<p><a href="/classroom/class/<?=$row['class']?>"><?=$row['class']?></a></p>
								<?php endif; ?>
								
								<div>
									<a href = "#" onclick= "openPage(`/baby/update_baby/<?=$row['parent']?>/<?=$row['name']?>`, 'update');">수정</a> 
									<a href="/baby/delete/<?=$row['parent']?>/<?=$row['name']?>" onclick = "if(!deleteBaby()) return false;">삭제</a>
								</div>
								<?php if($row['msg_cnt']): ?>
									<p class = "alert_msg_cnt"><?=$row['msg_cnt']?></p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--등록된 아동 없을 경우 아동 리스트 x-->

					<!--baby img의 float 제거 위한 div-->
					<div class = "bottom"></div>
				</div>
			<?php endif; ?>
			<!--학부모 아닌 경우 baby div x-->
		<?php endif; ?>					
	</div>
					

	<!-- 중앙 메뉴 묶음 -->
	<div id = "s_center">
		<!-- 사용자 정보 수정 메뉴 -->
		<div id = "us1">
			<h4 class = "s_title">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
				  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
				</svg>
				사용자 정보
			</h4>
				<!--form data 통해 update 진행 -->
				<form id = "f1">
					<input type="hidden" name="tid" value = "<?=$us['id']?>">

					<table id = "us1_info">
						<tr>
							<td><b>이름</b></td>
							<td><p name = "tname"><?=$us['name']?></p></td>
						</tr>
						<tr>
							<td><b>비밀번호</b></td>
							<td><p name = "tpw">********</p></td>
						</tr>
						<tr>
							<td><b>프로필</b></td>
							<td><p name = "img"><?=$us['img']?></p></td>
						</tr>
						<tr>
							<td><b>주소</b></td>
							<td><p name = "addr"><?=$us['addr']?></p></td>
						</tr>
						<tr>
							<td><b>이메일</b></td>
							<td><p name = "email"><?=$us['email']?></p></td>
						</tr>
						<tr>
							<td><b>한줄소개</b></td>
							<td><p name = "intro"><?=$us['intro']?></p></td>
						</tr>
					</table>			
				</form>	

				<!--정보 수정하기 버튼 (운영진은 권한 full) -->
				<?php if(isset($mysave)): ?>
					<?php if($user['perm'] == "관리자" || $user['perm'] == "부관리자"): ?>
						<button id = "update_btn" onclick="update_form('admin')"><p>정보 수정하기</p></button>
					<?php else: ?>
						<button id = "update_btn" onclick="update_form()"><p>정보 수정하기</p></button>
					<?php endif; ?>
				<?php endif; ?>				
			</div>

			<!-- 스크랩 된 게시물 목록 -->
			<div id = "us2">
				<h4 class = "s_title">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stickies" viewBox="0 0 16 16">
					  <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5V13a1 1 0 0 0 1 1V1.5a.5.5 0 0 1 .5-.5H14a1 1 0 0 0-1-1H1.5z"/>
					  <path d="M3.5 2A1.5 1.5 0 0 0 2 3.5v11A1.5 1.5 0 0 0 3.5 16h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 16 9.586V3.5A1.5 1.5 0 0 0 14.5 2h-11zM3 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V9h-4.5A1.5 1.5 0 0 0 9 10.5V15H3.5a.5.5 0 0 1-.5-.5v-11zm7 11.293V10.5a.5.5 0 0 1 .5-.5h4.293L10 14.793z"/>
					</svg>
					스크랩 한 게시물
				</h4>
				<!--게시물 리스트-->
				<div id = "mysave">						
					<table>
						<tr>	
							<th>게시물 번호</th>
							<th>게시물 제목</th>
							<th>작성자</th>
							<th>찜한 시각</th>
						</tr>
						<!--본인 또는 관리자, 부관리자 접속 상태이면?-->
						<?php if(isset($mysave)): ?>
							<!--스크랩 게시물 있으면-->
							<?php if($mysave): ?>
								<?php foreach($mysave['rs'] as $row): ?>
									<?php $title = mb_strlen($row['title']) > 10 ? mb_substr($row['title'],0,10,'UTF-8')." ··" : $row['title']; ?>
									<tr>	
										<td><?=$row['num']?></td>
										<td><a href="/board/read/page/<?=$row['num']?>"><?=$title?></a></td>
										<td><?=$row['b_user']?></td>
										<td><?=substr($row['created'], 0, 16)?></td>
									</tr>
								<?php endforeach; ?>
							<!--스크랩 게시물 없으면-->
							<?php else: ?>
								<td colspan="4"> 보관된 게시물이 없습니다 </td>
							<?php endif; ?>

						<!--본인 및 관리자, 부관리자가 아닐 경우-->
						<?php else: ?>
							<tr>
								<td colspan="4"> 본인 및 운영진만 볼 수 있습니다 </td>
							</tr>
						<?php endif; ?>		
					</table>				
				</div>					
			</div>	

		<!-- float 없애기 위한 div -->
		<div class = "bottom"></div>	
	</div>		

	<!-- 작성 게시물 바로가기 버튼-->
	<a id = "btn_my_board" href="/board/list/작성자/<?=$us['id']?>">
		<h4>
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
			  <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
			  <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
			</svg>
			작성한 게시물 보기
		</h4>
	</a>	

	<!-- 게시물 작성 현황 그래프 그룹 -->
	<div id = "graph_group">
		<h4 class="s_title">사용자 게시물 현황</h4>
		<div>
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner" style="height: <?= $us2_div['total_my_b'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_b']?>개의 게시물 중</p>
						<h3><?=$us2_div['total_my_b']?>개</h3>
					</div>
				</div>
				<p>게시물작성</p>
			</div>
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner" style="height: <?= $us2_div['total_my_r'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_r']?>개의 댓글 중</p>
						<h3><?=$us2_div['total_my_r']?>개</h3>
					</div>
				</div>
				<p>댓글작성</p>
			</div>
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner good" style="height: <?= $us2_div['total_good'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_b']?>개의 게시물 중</p>
						<h3><?=$us2_div['total_good']?>개</h3>
					</div>
				</div>
				<p>게시물 좋아요</p>
			</div>				
		</div>
		<div>
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner poor" style="height: <?= $us2_div['total_poor'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_b']?>개의 게시물 중</p>
						<h3><?=$us2_div['total_poor']?>개</h3>
					</div>
				</div>
				<p>게시물 싫어요</p>
			</div>
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner save" style="height: <?= $us2_div['total_save'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_b']?>개의 게시물 중</p>
						<h3><?=$us2_div['total_save']?>개</h3>
					</div>
				</div>
				<p>게시물 찜</p>
			</div>							
		</div>
		<div>
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner good" style="height: <?= $us2_div['total_good_r'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_r']?>개의 댓글 중</p>
						<h3><?=$us2_div['total_good_r']?>개</h3>
					</div>
				</div>
				<p>댓글 좋아요</p>
			</div>	
			<div class = "graph_wrap">
				<div class = "graph">
					<div class="graph_inner poor" style="height: <?= $us2_div['total_poor_r'] ?>px;"></div>
					<div class = "graph_per">
						<p><?=$us2_div['total_my_r']?>개의 댓글 중</p>
						<h3><?=$us2_div['total_poor_r']?>개</h3>
					</div>
				</div>
				<p>댓글 싫어요</p>
			</div>				
		</div>
	</div>

	<!-- 사용자 탈퇴 버튼 -->
	<?php if(isset($mysave)): ?>
		<button id = "delete_user" onclick="delete_user()">
			회원 탈퇴하기
		</button>
	<?php endif; ?>		
</section>

<!--외부 스크립트 불러오기-->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src = "/js/user/myroom.js"></script>