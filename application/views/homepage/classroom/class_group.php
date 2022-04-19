<!--classroom/class_group.php : 학급 리스트 페이지-->  

<!--외부 스타일 불러오기-->
<link rel="stylesheet" type="text/css" href="/css/classroom/class_group.css">

<section>	
	<h1>학급별 커뮤니티</h1><hr>

	<!--학급 전체 카테고리 div-->
	<div id = "class_group">
		<!--등록된 학급 있을 경우-->
		<?php if($class): ?>
			<?php foreach($class['rs'] as $row): ?>				
				<a href="/classroom/class/<?=$row['name']?>">
					<div class = "class_div">
						<div>
							<h3><?=$row['name']?>반</h3>
					
								<div class = "teacher_img_cut">
									<img src="/img/users/<?=$row['teacher_id']?>/profile/<?=$row['teacher_img']?>" onerror = "this.src = '/img/error/no_img.png'">
								</div>								
					
							<p>담임교사 | <?=$teacher = $row['teacher_name'] == "" ? "미배정" : $row['teacher_name']?>님</p>
							
						</div>						
					</div>				
				</a>							
			<?php endforeach; ?>
			<!--float 제거 div-->
			<div id = "class_bottom"></div>

		<!--등록된 학급 없을 경우-->
		<?php else: ?>
			<!--학부모 접근시-->
			<?php if(isset($mode)): ?>
				<div class = "class_div">
					<h3>아동이 소속된 학급이 없습니다</h3>
				</div>	
			<!--관리자, 부관리자 접근시-->
			<?php else: ?>
				<div class = "class_div">
					<h3>등록된 학급이 없습니다</h3>
				</div>
			<?php endif; ?>			
		<?php endif; ?>		
	</div>	
</section>