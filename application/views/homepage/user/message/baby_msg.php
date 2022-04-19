<!--user/message/baby_msg.php : 아동에 대한 메세지 페이지-->  

<!DOCTYPE html>
<html>
	<head>
		<title>메세지함</title>
	</head>
	<body>
		<!--외부 스타일 가져오기-->
		<link rel="stylesheet" type="text/css" href="/css/user/message/baby_msg.css">
		<section>
			<!--페이지 title-->
			<div id = "msg_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
					  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
					</svg>
					메세지함
				</h3>
			</div>

			<!--알림장 카테고리 버튼 그룹-->
			<div id = "btn_group">
				<div class = "top_btn">전체알림(<?=$num = $all_class_msg ? $all_class_msg['num'] : 0?>)</div>
				<div class = "top_btn">우리반알림(<?=$num = $class_msg ? $class_msg['num'] : 0?>)</div>
				<div class = "top_btn">우리아이(<?=$num = $comment ? $comment['num'] : 0?>)</div>
			</div>

			<!--1. 전체알림 클릭시 컨텐츠-->			
			<div class = "msg_wrap" id = "all_class_msg_wrap">		
				<!--메세지 제목-->
				<h3 class = "sub_title">				
					전체 아동 알림
				</h3>
				<hr>		
				<!--메세지 리스트-->
				<div class = "list_wrap">
					<!--들어온 메세지 있을 경우-->
					<?php if($all_class_msg): ?>
						<?php foreach($all_class_msg['rs'] as $row): ?>
							<div class = "msg_list">
								<div class ="teacher_info">
									<div class = "teacher_img_cut">
										<img src="/img/users/<?=$row['user']?>/profile/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">
									</div>
									<div class = "teacher_sub_info">
										<h3><b><?=$row['user']?> (<?=$row['perm']?>)</b></h3>
										<p class = "created"><?=$row['created']?> 전달</p>
									</div>		
									<!--float 제거 div-->
									<div class ="bottom"></div>				
								</div>
								<div class = "contents">
									<p><?=$row['msg']?></p>
								</div>									
							</div>							
						<?php endforeach; ?>

					<!--들어온 메세지 없을 경우-->
					<?php else: ?>
						<p class = "empty_msg">도착한 메세지가 없습니다</p>
					<?php endif; ?>						
				</div>	
			</div>	

			<!--2. 우리반알림 클릭시 컨텐츠-->			
			<div class = "msg_wrap" id = "class_msg_wrap">
				<!--메세지 제목-->
				<h3 class = "sub_title" class = "msg_wrap">				
					학급 알림장
				</h3><hr>			

				<!--메세지 리스트-->	
				<div class = "list_wrap">
					<!--들어온 메세지 있을 경우-->
					<?php if($class_msg): ?>
						<?php foreach($class_msg['rs'] as $row): ?>
							<div class = "msg_list">
								<div class ="teacher_info">
									<div class = "teacher_img_cut">
										<img src="/img/users/<?=$row['teacher_id']?>/profile/<?=$row['teacher_img']?>" onerror = "this.src = '/img/error/no_img.png'">
									</div>
									<div class = "teacher_sub_info">
										<h3><b><?=$row['teacher_id']?> (담임)</b></h3>
										<p class = "created"><?=$row['created']?> 전달</p>							
									</div>		
									<!--float 제거 div-->
									<div class ="bottom"></div>				
								</div>
								<div class = "contents">
									<p><?=$row['msg']?></p>
								</div>									
							</div>							
						<?php endforeach; ?>

					<!--들어온 메세지 없을 경우-->	
					<?php else: ?>
						<p class = "empty_msg">도착한 메세지가 없습니다</p>
					<?php endif; ?>						
				</div>				
			</div>	

			<!--3. 우리아이 클릭시 컨텐츠-->
			<div class = "msg_wrap" id = "comment_wrap">
				<!--메세지 제목-->
				<h3 class = "sub_title" class = "msg_wrap">				
					1:1 아동 전달사항 (<?=$baby?> - <?=$class?>)
				</h3>
				<hr>				
				<!--메세지 리스트-->
				<div class = "list_wrap">
					<!--들어온 메세지 있을 경우-->
					<?php if($comment): ?>
						<?php foreach($comment['rs'] as $row): ?>
							<!--메세지 읽음 표시 있을 경우-->
							<?php if($row['view'] == "읽음"): ?>
								<div class = "msg_list">
							<?php else: ?>
								<div class = "msg_list unread">
							<?php endif; ?>
							
								<div class ="teacher_info">
									<div class = "teacher_img_cut">
										<img src="/img/users/<?=$row['teacher_id']?>/profile/<?=$row['teacher_img']?>" onerror = "this.src = '/img/error/no_img.png'">
									</div>
									<div class = "teacher_sub_info">
										<h3><b><?=$row['teacher_id']?> (담임)</b></h3>
										<p class = "created"><?=$row['created']?> 전달
										<?php if($row['view'] != "읽음"): ?>
											| 읽지않음
										<?php else: ?>
											| 읽음
										<?php endif; ?>	
										</p>
									</div>		
									<!--float 제거 div-->
									<div class ="bottom"></div>				
								</div>

								<?php if($row['view'] != "읽음"): ?>
									<div class = "contents read">
								<?php else: ?>
									<div class = "contents">
								<?php endif; ?>						
									<p><?=$row['msg']?></p>
								</div>									
							</div>		
						<?php endforeach; ?>

					<!--들어온 메세지 없을 경우-->
					<?php else: ?>
						<p class = "empty_msg">도착한 메세지가 없습니다</p>
					<?php endif; ?>						
				</div>	
			</div>		
		</section>

		<!--외부 스크립트 불러오기-->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src = "/js/user/message/baby_msg.js"></script>
	</body>
</html>

	