<!--admin/main.php : 관리자 페이지-->

<!--외부 css 가져오기-->
<link rel="stylesheet" type="text/css" href="/css/admin/main.css">

<body>
	<section>
		<!--관리자 페이지 title div-->
		<div id = "title">
			<div id = "title_wrap">
				<h2>관리자 페이지</h2>
				<p>유저, 게시물 관리 등 다양한 제어가 가능합니다.</p>
			</div>
		</div>	

		<!--운영진 커뮤니티 버튼-->
		<div class= "btn_slide" id = "btn_admin_board">
			<a href="/board/list/운영진/admin">
				<h4>운영진 커뮤니티 바로가기</h4>
			</a>			
		</div>

		<!--대문글 작성 버튼-->
		<div class= "btn_slide" id = "intro_write">
			<h4>대문 작성</h4>
		</div>

		<!--대문글 작성 슬라이드-->
		<div class = "slide_contents" id = "intro_slide">
			<div id = "intro_rs">
				<b><p>					
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
					  <path fill-rule=" evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
					</svg>
					현재 작성된 대문글 현황
				</p></b><hr>
				<?php if(!$intro): ?>
					<h4>등록된 대문 글이 없습니다</h4>
				<?php else : ?>
					<b><p><?=$intro['contents']?></p></b><p> ㄴ작성 : <?=$intro['perm']?>(<?=substr($intro['created'],0,10)?>)</p>
				<?php endif; ?>
			</div>
			<textarea id = "intro_area" placeholder="대문글을 작성하세요"></textarea>			
			<button onclick="intro_write()">작성</button>
		</div>

		<!--이메일 div 버튼-->
		<div class = "btn_slide" id = "email">
			<h4>Email 발송</h4>
		</div>

		<!--이메일 슬라이드-->
		<div class = "slide_contents" id = "email_slide">
			<label for = "title">이메일 제목</label> <input type="text" name="title" id = "email_title">			

			<div id = "email_user_list">
				<p id = "email_alert">선택된 사용자가 없습니다</p>
			</div>
			<textarea name = "contents" class="form-control" id="email_area" rows="20" ></textarea>	
			<button onclick="sendEmail();">이메일 발송</button>		
		</div>		
		
		<!--사용자 컨트롤 버튼 그룹-->
		<div id = "user_group">
			<div class = "btn_group">
				<button onclick="deleteUser()">삭제</button>
				<button onclick="updateUser()">수정</button>
			</div>
			
			<?php 
				$num = $empty ? $empty['num'] : 0;
			?>			
			<!--가입대기교사 제목-->
			<div class = "user_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hexagon" viewBox="0 0 16 16">
					  <path d="M14 4.577v6.846L8 15l-6-3.577V4.577L8 1l6 3.577zM8.5.134a1 1 0 0 0-1 0l-6 3.577a1 1 0 0 0-.5.866v6.846a1 1 0 0 0 .5.866l6 3.577a1 1 0 0 0 1 0l6-3.577a1 1 0 0 0 .5-.866V4.577a1 1 0 0 0-.5-.866L8.5.134z"/>
					</svg>
					가입대기학부모
				</h3>
				<p><?=$num?></p>
			</div>

			<!--가입대기교사 리스트-->
			<div class = "user_list">	
					<table class = "user_table">
						<tr>
							<th>순서</th>
							<th>사진</th>
							<th>아이디</th>
							<th>이름</th>
							<th>가입일자</th>
							<th><label for = "all_email">메일</label> <input type="checkbox" name="all_email"></th>
							<th><label for = "all_delete">삭제</label> <input type="checkbox" name="all_delete"></th>
							<th>등급</th>
						</tr>
					<!--가입대기교사 있을 경우-->
					<?php if($empty): ?>					
						<?php $cnt = 0; ?>						
						<?php foreach($empty['rs'] as $row): ?>
							<?php $cnt++; ?>
							<tr>
								<input type="hidden" name="id" value = "<?=$row['id']?>">
								<td><?=$cnt?></td>
								<td>
									<div class = "table_img_cut">
										<img src="/img/users/<?=$row['id']?>/profile/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">									
									</div>								
								</td>
								<?php
									$id = strlen($row['id']) > 12 ? substr($row['id'], 0, 12)." ··" : $row['id']; 
								?>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$id?></a></td>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$row['name']?></a></td>
								<td><?=$row['created']?></td>
								<td><input type="checkbox" name="email" value="<?=$row['email']?>"></td>
								<td><input type="checkbox" name="delete" value="<?=$row['id']?>"></td>
								<td>
									<select name = "perm">
										<option value = "가입대기" selected>가입대기</option>
										<option value = "일반">일반</option>						
									</select>
								</td>		
							</tr>	
						<?php endforeach; ?>	

					<!--가입대기학부모 없을 경우-->
					<?php else: ?>
						<tr>
							<td colspan="9">
								해당 권한의 사용자가 없습니다
							</td>
						</tr>
					<?php endif; ?>
				</table>						
			</div>

			<?php 
				$num = $common ? $common['num'] : 0;
			?>
			<!--일반 학부모 제목-->
			<div class = "user_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hexagon-half" viewBox="0 0 16 16">
					  <path d="M14 4.577v6.846L8 15V1l6 3.577zM8.5.134a1 1 0 0 0-1 0l-6 3.577a1 1 0 0 0-.5.866v6.846a1 1 0 0 0 .5.866l6 3.577a1 1 0 0 0 1 0l6-3.577a1 1 0 0 0 .5-.866V4.577a1 1 0 0 0-.5-.866L8.5.134z"/>
					</svg>
					학부모
				</h3>
				<p><?=$num?></p>
			</div>
			<div class = "user_list">		
					<table class = "user_table">
						<tr>
							<th>순서</th>
							<th>사진</th>
							<th>아이디</th>
							<th>이름</th>
							<th>가입일자</th>
							<th><label for = "all_email">메일</label> <input type="checkbox" name="all_email"></th>
							<th><label for = "all_delete">삭제</label> <input type="checkbox" name="all_delete"></th>
							<th>등급</th>
						</tr>

					<!--일반 학부모 있을 경우-->
					<?php if($common): ?>
						<?php $cnt = 0; ?>			
						
						<?php foreach($common['rs'] as $row): ?>
							<?php $cnt++; ?>
							<tr>
								<input type="hidden" name="id" value = "<?=$row['id']?>">
								<td><?=$cnt?></td>
								<td>
									<div class = "table_img_cut">
										<img src="/img/users/<?=$row['id']?>/profile/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">									
									</div>								
								</td>
								<?php
									$id = strlen($row['id']) > 12 ? substr($row['id'], 0, 12)." ··" : $row['id']; 
								?>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$id?></a></td>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$row['name']?></a></td>
								<td><?=$row['created']?></td>
								<td><input type="checkbox" name="email" value="<?=$row['email']?>"></td>
								<td><input type="checkbox" name="delete" value="<?=$row['id']?>"></td>
								<td>
									<select name = "perm">
										<option value = "가입대기">가입대기</option>
										<option value = "일반" selected>일반</option>					
									</select>		
								</td>			
							</tr>						
						<?php endforeach; ?>

					<!--일반 학부모 없을 경우-->
					<?php else: ?>
						<tr>
							<td colspan="9">
								해당 권한의 사용자가 없습니다
							</td>
						</tr>
					<?php endif; ?>
				</table>		
			</div>

			<?php $num = $t_empty ? $t_empty['num'] : 0; ?>
			<!--가입대기교사 제목-->
			<div class = "user_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hexagon" viewBox="0 0 16 16">
					  <path d="M14 4.577v6.846L8 15l-6-3.577V4.577L8 1l6 3.577zM8.5.134a1 1 0 0 0-1 0l-6 3.577a1 1 0 0 0-.5.866v6.846a1 1 0 0 0 .5.866l6 3.577a1 1 0 0 0 1 0l6-3.577a1 1 0 0 0 .5-.866V4.577a1 1 0 0 0-.5-.866L8.5.134z"/>
					</svg>
					가입대기교사
				</h3>
				<p><?=$num?></p>
			</div>

			<!--가입대기교사 있을 경우-->
			<div class = "user_list">		
				<table class = "user_table">
					<tr>
						<th>순서</th>
						<th>사진</th>
						<th>아이디</th>
						<th>이름</th>
						<th>가입일자</th>
						<th><label for = "all_email">메일</label> <input type="checkbox" name="all_email"></th>
						<th><label for = "all_delete">삭제</label> <input type="checkbox" name="all_delete"></th>
						<th>등급</th>
					</tr>

					<!--가입대기교사 있을 경우-->
					<?php if($t_empty): ?>
						<?php $cnt = 0; ?>				
					
						<?php foreach($t_empty['rs'] as $row): ?>
							<?php $cnt++; ?>
							<tr>
								<input type="hidden" name="id" value = "<?=$row['id']?>">
								<td><?=$cnt?></td>
								<td>
									<div class = "table_img_cut">
										<img src="/img/users/<?=$row['id']?>/profile/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">									
									</div>								
								</td>
								<?php
									$id = strlen($row['id']) > 12 ? substr($row['id'], 0, 12)." ··" : $row['id']; 
								?>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$id?></a></td>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$row['name']?></a></td>					
								<td><?=$row['created']?></td>
								<td><input type="checkbox" name="email" value="<?=$row['email']?>"></td>
								<td><input type="checkbox" name="delete" value="<?=$row['id']?>"></td>
								<td>
									<select name = "perm">
										<option value = "가입대기" selected>가입대기</option>
										<option value = "일반">일반</option>		
										<option value = "부관리자">부관리자</option>						
									</select>
								</td>		
							</tr>	
						<?php endforeach; ?>	

					<!--가입대기교사 없을 경우-->
					<?php else: ?>				
						<tr>
							<td colspan="9">
								해당 권한의 사용자가 없습니다
							</td>
						</tr>
					<?php endif; ?>

					</table>
			</div>

			<?php $num = $t_common ? $t_common['num'] : 0; ?>
			<!--일반교사 제목-->
			<div class = "user_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hexagon-half" viewBox="0 0 16 16">
					  <path d="M14 4.577v6.846L8 15V1l6 3.577zM8.5.134a1 1 0 0 0-1 0l-6 3.577a1 1 0 0 0-.5.866v6.846a1 1 0 0 0 .5.866l6 3.577a1 1 0 0 0 1 0l6-3.577a1 1 0 0 0 .5-.866V4.577a1 1 0 0 0-.5-.866L8.5.134z"/>
					</svg>
					일반교사
				</h3>
				<p><?=$num?></p>
			</div>

			<!--일반교사 리스트-->
			<div class = "user_list">		
				<table class = "user_table">

					<tr>
						<th>순서</th>
						<th>사진</th>
						<th>아이디</th>
						<th>이름</th>
						<th>담당학급</th>
						<th>가입일자</th>
						<th><label for = "all_email">메일</label> <input type="checkbox" name="all_email"></th>
						<th><label for = "all_delete">삭제</label> <input type="checkbox" name="all_delete"></th>
						<th>등급</th>
					</tr>

					<!--일반교사 있을 경우-->
					<?php if($t_common): ?>
						<?php $cnt = 0; ?>				
					
						<?php foreach($t_common['rs'] as $row): ?>
							<?php $cnt++; ?>
							<tr>
								<input type="hidden" name="id" value = "<?=$row['id']?>">
								<td><?=$cnt?></td>
								<td>
									<div class = "table_img_cut">
										<img src="/img/users/<?=$row['id']?>/profile/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">									
									</div>								
								</td>
								<?php
									$id = strlen($row['id']) > 12 ? substr($row['id'], 0, 12)." ··" : $row['id']; 
								?>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$id?></a></td>
								<td><a href = "/user/myroom/<?=$row['id']?>"><?=$row['name']?></a></td>
								<?php if($row['class_name'] == "미지정"): ?>
									<td><?=$row['class_name']?></td>
								<?php else: ?>
									<td><a href = "/classroom/class/<?=$row['class_name']?>"><?=$row['class_name']?>반</a></td>
								<?php endif; ?>
								
								<td><?=$row['created']?></td>
								<td><input type="checkbox" name="email" value="<?=$row['email']?>"></td>
								<td><input type="checkbox" name="delete" value="<?=$row['id']?>"></td>
								<td>
									<select name = "perm">
										<option value = "가입대기">가입대기</option>
										<option value = "일반" selected>일반</option>		
										<option value = "부관리자">부관리자</option>						
									</select>
								</td>		
							</tr>	
						<?php endforeach; ?>	

						<!--일반교사 없을 경우-->
						<?php else: ?>				
							<tr>
								<td colspan="9">
									해당 권한의 사용자가 없습니다
								</td>
							</tr>
						<?php endif; ?>

					</table>
			</div>

			<!--부관리자는 같은 부관리자를 삭제할 수 없도록 함-->
			<?php if($user['perm'] == "관리자"): ?>

				<?php $num = $t_sub_admin ? $t_sub_admin['num'] : 0; ?>			

				<!--부관리자 교사 제목-->
				<div class = "user_title">
					<h3>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hexagon-fill" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8.5.134a1 1 0 0 0-1 0l-6 3.577a1 1 0 0 0-.5.866v6.846a1 1 0 0 0 .5.866l6 3.577a1 1 0 0 0 1 0l6-3.577a1 1 0 0 0 .5-.866V4.577a1 1 0 0 0-.5-.866L8.5.134z"/>
						</svg>
						부관리자 교사
					</h3>
					<p><?=$num?></p>
				</div>

				<!--부관리자 리스트-->
				<div class = "user_list">		
					<table class = "user_table">
						<tr>
							<th>순서</th>
							<th>사진</th>
							<th>아이디</th>
							<th>이름</th>
							<th>담당학급</th>
							<th>가입일자</th>
							<th><label for = "all_email">메일</label> <input type="checkbox" name="all_email"></th>
							<th><label for = "all_delete">삭제</label> <input type="checkbox" name="all_delete"></th>
							<th>등급</th>
						</tr>
						<!--부관리자 교사 있을 경우-->
						<?php if($t_sub_admin): ?>
							<?php $cnt = 0; ?>				
						
							<?php foreach($t_sub_admin['rs'] as $row): ?>
								<?php $cnt++; ?>
								<tr>
									<input type="hidden" name="id" value = "<?=$row['id']?>">
									<td><?=$cnt?></td>
									<td>
										<div class = "table_img_cut">
											<img src="/img/users/<?=$row['id']?>/profile/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">									
										</div>								
									</td>
									<?php
										$id = strlen($row['id']) > 12 ? substr($row['id'], 0, 12)." ··" : $row['id']; 
									?>
									<td><a href = "/user/myroom/<?=$row['id']?>"><?=$id?></a></td>
									<td><a href = "/user/myroom/<?=$row['id']?>"><?=$row['name']?></a></td>

									<?php if($row['class_name'] == "미지정"): ?>
										<td><?=$row['class_name']?></td>
									<?php else: ?>
										<td><a href = "/classroom/class/<?=$row['class_name']?>"><?=$row['class_name']?>반</a></td>
									<?php endif; ?>

									<td><?=$row['created']?></td>
									<td><input type="checkbox" name="email" value="<?=$row['email']?>"></td>
									<td><input type="checkbox" name="delete" value="<?=$row['id']?>"></td>
									<td>
										<select name = "perm">
											<option value = "가입대기">가입대기</option>
											<option value = "일반" selected>일반</option>		
											<option value = "부관리자">부관리자</option>						
										</select>
									</td>		
								</tr>	
							<?php endforeach; ?>	

						<!--부관리자 없을 경우-->
						<?php else: ?>				
							<tr>								
								해당 권한의 사용자가 없습니다							
							</tr>
						<?php endif; ?>
					</table>
				</div>
			<?php endif; ?>		
		</div>

		<!--클래스 리스트 및 수정-->		
		<div id = "class_wrap">
			<div id = "class_write">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
					  <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
					</svg>
					학급생성
				</h3>			
				
				<input type="text" name="class_name" id = "class_name" placeholder="학급 이름을 작성하세요"><br>
				<label for = "class_select">교사지정</label>
				<select class = "class_select" name = "class_select">
					<?php if($t_common): ?>
						<option selected>미지정</option>
						<?php foreach($t_common['rs'] as $row): ?>
							<option value = "<?=$row['id']?>"> <?=$row['id']?> (<?=$row['name']?> 교사)</option>
						<?php endforeach; ?>
					<?php else: ?>
						<option selected>교사없음</option>
					<?php endif; ?>
				</select><hr>

				<div>
					<textarea name = "class_comment" id = "class_comment" placeholder="코멘트를 작성하세요"></textarea>
					<button onclick="createClass();">생성</button>
					<div id = "class_bottom"></div>
				</div>				
			</div>

			<?php $num = $class ? $class['num'] : 0; ?>

			<!--학급 수정 제목-->
			<div class = "user_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
					  <path d="M1 0L0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"/>
					</svg>
					학급관리
				</h3>				
				<p><?=$num?></p>

				<!--학급 버튼 그룹-->
				<div class = "btn_group">
					<button onclick="updateClass()">수정</button>
					<button onclick="deleteClass()">삭제</button>
				</div>
			</div>

			<!--학급 정보 리스트-->
			<div class = "user_list">		
				<table class = "class_table">
					<tr>
						<th>반이름</th>
						<th>담임교사</th>
						<th>아이총원</th>
						<th>코멘트</th>
						<th><label for = "delete_class_all">삭제</label><input type="checkbox" name="delete_class_all"></th>
					</tr>
					<?php if($class): ?>

						<?php foreach($class['rs'] as $row): ?>
							<tr>
								<!--학급명 수정 input 및 학급 방문 버튼-->
								<td>
									<input type="text" value = "<?=$row['name']?>" name="update_class_name">
									<button onclick = "location.href = '/classroom/class/<?=$row['name']?>'"> 방문 </button>
								</td>
								<td>
									<!--교사 지정 select box-->
									<select class = "update_class_teacher" name = "update_class_teacher">
										<?php if($t_empty_not): ?>
											<?php if($row['teacher'] === null): ?>
												<option selected>미지정</option>
											<?php else: ?>
												<option>미지정</option>
											<?php endif; ?>
										
											<?php foreach($t_empty_not['rs'] as $row_t): ?>	
												<?php if($row_t['id'] == $row['teacher']): ?>
													<option value = "<?=$row_t['id']?>" selected> <?=$row_t['name']?> (<?=$row_t['id']?>)</option>
												<?php else: ?>
													<option value = "<?=$row_t['id']?>"> <?=$row_t['name']?> (<?=$row_t['id']?>)</option>
												<?php endif; ?>
											<?php endforeach; ?>

										<?php else: ?>
											<option>교사없음</option>
										<?php endif; ?>
									</select>								
								</td>
								<td><?=$row['total_baby']?>명</td>
								
								<!--학급에 대한 코멘트 수정 textarea-->
								<td>
									<textarea class = "update_class_comment" name = "update_class_comment">
										<?=$row['comment']?>
									</textarea>
								</td>
								<!--삭제 체크박스-->							
								<td><input type="checkbox" name="delete_class"></td>
								<!--현재 클래스 이름 hidden input-->
								<input type="hidden" name = "ori_class_name" value ="<?=$row['name']?>">
							</tr>
						<?php endforeach; ?>

					<!--데이터가 없는 경우-->
					<?php else: ?>
						<tr>							
							등록된 반이 없습니다						
						</tr>
					<?php endif; ?>
				</table>
			</div>

			<?php $num = $baby ? $baby['num'] : 0; ?>
			<!--아동리스트 div-->
			<div class = "user_title">
				<h3>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
					  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
					  <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
					</svg>
					아동관리
				</h3>
				<p><?=$num?></p>

				<!--아동정보 버튼 그룹-->
				<div class = "btn_group">
					<button name = "delete_baby_btn" id = "update_baby_btn" onclick="updateBaby()">아동수정</button>
					<button name = "delete_baby_btn" id = "delete_baby_btn" onclick="deleteBaby()">아동삭제</button>	
				</div>
			</div>

			<!--아동 리스트-->
			<div class = "user_list">				
				<table class = "baby_table">
					<tr>
						<tr>
							<th>프로필</th>
							<th>아동명</th>
							<th>학부모명</th>
							<th>학급</th>
							<th>담임교사</th>
							<th>연령</th>
							<th><label for = "delete_baby_all">삭제</label><input type="checkbox" name="delete_baby_all"></th>
						</tr>
					</tr>

					<!--등록된 아동이 있으면-->
					<?php if($baby):?>						
						<?php foreach($baby['rs'] as $row): ?>
							<tr>
								<td>
									<div class = "table_img_cut">
										<img src="/img/users/<?=$row['parent']?>/baby/<?=$row['img']?>" onerror = "this.src = '/img/error/no_img.png'">								
									</div>								
								</td>
								<td><?=$row['name']?></td>
								<td><a href = "/user/myroom/<?=$row['parent']?>"><?=$row['parent']?></a></td>
								<td>
									<select name = "select_baby_class">										
										<?php if($class): ?>
											<script type="text/javascript">
												var cnt = 0;
											</script>

											<?php foreach($class['rs'] as $row_c): ?>
												<?php if($row_c['name'] == $row['class']): ?>
													<option value = "<?=$row_c['name']?>" selected><?=$row_c['name']?></option>		

												<?php elseif($row['class'] === null): ?>
													<option selected>미지정</option>		

												<?php else: ?>
													<option value = "<?=$row_c['name']?>"><?=$row_c['name']?></option>		
												<?php endif; ?>
											<?php endforeach; ?>
										<?php else: ?>
											<option>미지정</option>
										<?php endif; ?>
									</select>
								</td>
								<td><a href = "/classroom/class/<?=$row['class']?>"><?=$row['class']?></a></td>
								<td><?=$row['old']?></td>
								<td><input type="checkbox" name="delete_baby"></td>

								<!--해당 행의 아동 및 학부모 정보 hidden input-->
								<input type="hidden" name="baby_name" value = "<?=$row['name']?>">
								<input type="hidden" name="baby_parent" value = "<?=$row['parent']?>">
							</tr>
						<?php endforeach; ?>

					<!--자료가 없다면-->
					<?php else: ?>
						등록된 아동이 없습니다
					<?php endif; ?>
				</table>
			</div>
		</div>

		<!--게시물 관리 div-->
		<div id = "ctrl_board">
			<div class = "list_title">
				<h4>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify-left" viewBox="0 0 16 16">
					  <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
					</svg>
					<b>게시물 관리</b>
				</h4>
				<?php if($board): ?>
					<h5 class = "list_cnt_num"><?=$board['num']?></h5>
				<?php endif; ?>			
			</div>

			<!--게시물 블라인드 및 삭제-->
			<div id = "btn_ctrl_board">
				<a onclick="ctrl_board('blind')">블라인드</a>
				<a onclick="ctrl_board('delete')">삭제</a>				
			</div>

			<!--게시물 리스트-->
			<div>
				<div id="board_list">
					<table>	
						<tr>
							<th>순번</td>
							<th>카테고리</td>
							<th>제목</td>
							<th>ID</td>
							<th>작성일</td>
							<th>수정하기</th>
							<th><input type="checkbox" id = "btn_blind"></th>
							<th><input type="checkbox" id = "btn_delete"></th>
						</tr>
						<!--작성된 게시물 있으면 게시물 및 수정, 삭제, 블라인드 가능한 input 출력-->
						<?php if($board): ?>
							<?php $cnt=1; ?>
							<?php foreach($board['rs'] as $row): ?>
								<tr>
									<td><?=$cnt?></td>
									<td><?=$row['cat']?></td>
									<td>
										<a href="/board/read/page/<?=$row['num']?>">
											<?php $title_b = strlen($row['title']) > 12 ? mb_substr($row['title'], 0, 12, 'UTF-8')." ··" : $row['title']?>
											<?=$title_b?>
										</a>
									</td>
									<td><?=$row['user']?></td>
									<td><?=$row['created']?></td>	
									<td>
										<a class = "btn_user_update" onclick="update_board('<?=$row['num']?>')">수정</a>
									</td>
									<?php if($row['perm'] == '블라인드'): ?>
										<td><input type="checkbox" name="board_list_blind" value = "<?=$row['num']?>" checked></td>	
									<?php else: ?>
										<td><input type="checkbox" name="board_list_blind" value = "<?=$row['num']?>"></td>	
									<?php endif; ?>									
									<td><input type="checkbox" name="board_list_delete" value = "<?=$row['num']?>"></td>															
								</tr>
								<?php $cnt++; ?>
							<?php endforeach; ?>

						<!--작성된 게시물 없으면-->
						<?php else: ?>
							데이터 없음
						<?php endif; ?>
					</table>
				</div>
			</div>
		</div>

		<!--로그인 로그 목록-->
		<div id = "visit">
			<!--리스트 제목-->
			<div class = "list_title">
				<h4>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
					  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
					</svg>
					<b>로그인 기록</b>
				</h4>
				<?php if($visit): ?>
					<h5 class = "list_cnt_num"><?=$visit['num']?></h5>
				<?php endif; ?>			
			</div>
			<!--리스트 테이블-->
			<div>
				<div id="visit_list">
					<table>
						<tr>
							<th>순번</td>
							<th>ID</td>
							<th>IP</td>
							<th>시간</td>
						</tr>
						<!--방문기록 있을 경우 출력-->
						<?php if($visit): ?>
							<?php $cnt=1; ?>
							
							<?php date_default_timezone_set('Asia/Seoul'); ?>
							<?php foreach($visit['rs'] as $row): ?>		
								<!--오늘 방문자에 대한 표시-->										
								<?php if(substr($row['visited'], 0, 10) === substr(date("Y-m-d"), 0, 10) ) : ?>
								<tr style = "background-color: silver;">
									<td><b><?=$cnt?></b></td>	
									<td><b><?=$row['user']?></b></td>
									<td><b><?=$row['ip']?></b></td>		
									<td><b><?=$row['visited']." (오늘)"?></b></td>	
								</tr>
								<!--오늘 이전의 방문자 표시-->
								<?php else: ?>
								<tr>
									<td><?=$cnt?></td>	
									<td><?=$row['user']?></td>
									<td><?=$row['ip']?></td>		
									<td><?=$row['visited']?></td>	
								</tr>
								<?php endif; ?>
							<?php $cnt++; ?>
						<?php endforeach; ?>

						<!--방문기록 없을 경우-->
						<?php else: ?>
							데이터 없음
						<?php endif; ?>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!--외부 script 불러오기-->
	<script src="/static/lib/ckeditor/ckeditor.js"></script>
	<script src = "/js/admin/main.js"></script>
</body>
</html>