<!--classroom/class.php : 학급 커뮤니티 페이지-->  

<!--외부 스타일 불러오기-->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poor+Story&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/classroom/class.css">

<section>
	<!--클래스 title-->
	<div id = "class_title">
		<div id = "title_wrap">			
			<h1>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
				  <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
				</svg>
				<?=$class['name']?>
			</h1>
		</div>		
	</div>

	<!--교사 정보-->
	<div id = "teacher_div">
		<?php if($teacher): ?>
			<h3>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
				  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
				</svg>
				담임교사 <?=$teacher['name']?>
			</h3>
			<hr>

			<div>
				<a href="/user/myroom/<?=$teacher['id']?>">
					<div id = "teacher_img_cut">
						<img src="/img/users/<?=$teacher['id']?>/profile/<?=$teacher['img']?>" onerror="this.src='/img/error/no_img.png'">
					</div>					
				</a>
				
				<!--학급 코멘트 div-->
				<div id = "comment">
					<p>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-quote-fill" viewBox="0 0 16 16">
						  <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM7.194 6.766a1.688 1.688 0 0 0-.227-.272 1.467 1.467 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 5.734 6C4.776 6 4 6.746 4 7.667c0 .92.776 1.666 1.734 1.666.343 0 .662-.095.931-.26-.137.389-.39.804-.81 1.22a.405.405 0 0 0 .011.59c.173.16.447.155.614-.01 1.334-1.329 1.37-2.758.941-3.706a2.461 2.461 0 0 0-.227-.4zM11 9.073c-.136.389-.39.804-.81 1.22a.405.405 0 0 0 .012.59c.172.16.446.155.613-.01 1.334-1.329 1.37-2.758.942-3.706a2.466 2.466 0 0 0-.228-.4 1.686 1.686 0 0 0-.227-.273 1.466 1.466 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 10.07 6c-.957 0-1.734.746-1.734 1.667 0 .92.777 1.666 1.734 1.666.343 0 .662-.095.931-.26z"/>
						</svg>
						<b>우리반 한마디</b>
					</p><hr>
					<p id = "class_comment">
						<?=$class['comment']?>
					</p>
				</div>
				<!--float 제거 div-->
				<div class = "bottom"></div>
			</div>

			<!--해당 학급 교사 또는 관리자일 경우-->			
			<?php if($user['dept'] == "교사" || $user['perm'] == "관리자"):?>
				<div id = "comment_write">
					<div id = "comment_write_div">
						<h5>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
							  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
							</svg>
							<b>우리반 소개 문구 수정</b>
						</h5><hr>
						<textarea name = "comment_area" placeholder="우리반 소개글을 입력하세요"></textarea>
						<button onclick="insertClassComment()">적용</button>
						<div class = "bottom"></div>
					</div>				
				</div>
			<?php endif; ?>

		<!--이외 일반일 경우-->
		<?php else: ?>
			<h3>교사 미배정</h3>
			<div class = "teacher_img_cut">
				<img src="/img/error/no_img.png">					
			</div>			
		<?php endif; ?>
		</div>
	</div>

	<!--아동 div-->
	<div id = "baby_div">
		<!--아동정보 있을 경우-->
		<?php if($baby): ?>
			<!--해당 학급 교사 또는 관리자일 경우-->
			<?php if($user['dept'] == "교사" || $user['perm'] == "관리자"):?>
				<h5>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
					  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					</svg>
					학급 인원 (<?=$baby['num']?>)
				</h5>
				<?php foreach($baby['rs'] as $row): ?>
					<div class = "baby_wrap teacher">
						<div class = "baby_img_cut">
							<img src="/img/users/<?=$row['parent']?>/baby/<?=$row['img']?>" onerror = "this.src='/img/error/no_img.png'">					
						</div>
						<p>										
							<?php $name = mb_strlen($row['name']) > 6 ? mb_substr($row['name'],0, 6)."··" : $row['name']; ?>
							<?=$name?>		
						</p>	

						<input type="hidden" name="parent" value = "<?=$row['parent']?>">
						<input type="hidden" name="baby" value = "<?=$row['name']?>">		
					</div>				
				<?php endforeach; ?>

			<!--이외 일반일 경우-->
			<?php else: ?>
				<h5>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
					  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					</svg>
					학급 인원 (<?=$baby['num']?>)
				</h5>
				<?php foreach($baby['rs'] as $row): ?>
					<div class = "baby_wrap parent">
						<div class = "baby_img_cut">
							<img src="/img/users/<?=$row['parent']?>/baby/<?=$row['img']?>" onerror = "this.src='/img/error/no_img.png'">					
						</div>	

						<!--내 아동일 경우 표시-->					
						<?php if($row['parent'] == $user['id']): ?>
							<p class = "my_baby">
						<!--일반 아동일 경우 표시-->								
						<?php else: ?>
							<p>
						<?php endif; ?>
							<?php $name = mb_strlen($row['name']) > 6 ? mb_substr($row['name'],0, 6)."··" : $row['name']; ?>
							<?=$name?>		
						</p>	

						<!--학부모, 아동 정보 hidden input-->
						<input type="hidden" name="parent" value = "<?=$row['parent']?>">
						<input type="hidden" name="baby" value = "<?=$row['name']?>">		
					</div>				
				<?php endforeach; ?>
			<?php endif; ?>

		<!--아동정보 없을 경우-->	
		<?php else: ?>
			<h5>학급에 등록된 아동이 없습니다</h5>
		<?php endif; ?>
	</div>

	<!--담임교사일 경우 알림장 작성 가능-->
	<?php if($user['dept'] == "교사"):?>
		<div id = "class_notice_write">
			<h5>
				<b>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
				  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
				  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
				</svg>
				우리반 알림장 전체 발송
				</b>
			</h5><hr>
			<div>
				<textarea name = "notice_area" placeholder="알림장 내용을 작성하세요"></textarea>
				<button onclick="insertNotice();">작성</button>
				<div class = "bottom"></div>
			</div>			
		</div>
	<?php endif; ?>	

	<!--학급 커뮤니티-->	
	<div id = "class_community">
		<h3>학급 커뮤니티</h3><hr>
		<div id = "class_write">
			<h5>글 작성</h5>			
			<input type="hidden" name="user" value = "<?=$user['id']?>">
			<input type="hidden" name="class_name" value = "<?=$class['name']?>">
			<textarea name = "class_contents" placeholder="게시물 내용을 입력하세요"></textarea>
			<button onclick="insertBoard();">등록</button>	
			<div id = "class_write_bottom"></div>
		</div>

		<!--게시물 결과 값 없으면-->
		<div id = "class_board">
			<div id = "board_cnt">
				<p>전체 게시물 : <?=$total_board?>개</p>
				<p>현재 페이지 게시물 : <?=$board?>개</p>
			</div>

			<!--게시물 결과 값 있으면-->
			<?php if($rs): ?>
				<!--하나씩 뽑아내기-->
				<?php foreach($rs['rs'] as $row): ?>
					<div class = "class_board">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
						  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
						</svg>
						<div class = "list_title">
							<div class = "board_img_cut">
								<img src="/img/users/<?=$row['user']?>/profile/<?=$row['user_img']?>" onerror = "this.src='/img/error/no_img.png'">
							</div>		
							<div>
								<h5><b><?=$row['user']?></b></h5>		
								<p class = "created"><?=$row['created']?> 작성</p>								
							</div>					
																	
						</div>
						<div class = "contents">
							<?=$row['contents']?>
						</div>
						
						<div class = "bottom"></div>
					</div>
				<?php endforeach; ?>
		
			<!--게시물 결과 값 없으면-->
			<?php else: ?>
				<div class = "class_board" style="text-align: center;">
					<h5><b>게시물 없음</b></h5>					
				</div>
			<?php endif; ?>

			<!--페이지 링크-->
			<div id = "paging_link">
				<?=$paging_link?>	
			</div>
		</div>
	</div>	
</section>

<!--외부 스크립트 불러오기-->
<script type="text/javascript" src = "/js/classroom/class.js"></script>