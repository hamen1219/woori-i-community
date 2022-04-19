<!--base/header.php : 모든 파일에 적용되는 header 파일-->	

<!DOCTYPE html>
<html>
	<head>
		<title>
			우리아이 커뮤니티
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	

		<!--jquery-->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 

		<!--bootstrap-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&family=Song+Myung&family=East+Sea+Dokdo&Julius+Sans+One&display=swap" rel="stylesheet">


		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> 
		<!--slick js-->
		<script type="text/javascript" src="/static/lib/slick/slick/slick.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/static/lib/slick/slick/slick.css"/>
		<link rel="stylesheet" type="text/css" href="/static/lib/slick/slick/slick-theme.css"/>

		<!--modal-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

		<!--외부 스타일 불러오기-->	
		<link rel="stylesheet" type="text/css" href="/css/base/header.css">
	</head>

	<body>
		<?php if(isset($unread_msg_cnt) && $unread_msg_cnt): ?>
			<div id = "alert_unread_msg">
				<a href="/user/myroom">읽지 않은 <?=$unread_msg_cnt?>개의 메세지가 있습니다. 클릭하여 확인하세요</a>
				<input type="hidden" name="unread_msg_cnt" value = "<?=$unread_msg_cnt?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
				  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
				  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg>
			</div>
		<?php endif ?>
		
		<!--모달 창 (로그인 사용자 정보 뵤여주는 창)-->	
		<div id="ex1" class="modal">
			<h4><b>사용자 정보</b></h4><hr>
			<table id = "user_info_table">
				<tr>
					<td colspan="2">
						<img class = "user_info_img" src="/img/users/<?=$user['id']?>/profile/<?=$user['img']?>" onerror="this.src='/img/error/no_img.png'">
					</td>
				</tr>
				<tr>
					<td><p><b>ID</b></p></td>
					<td><?= $user['id']?></td>					
				</tr>
				<tr>
					<td><p><b>이름</b></p></td>
					<td><?= $user['name']?></td>
				</tr>
				
				<tr>
					<td><p><b>부서</b></p></td>
					<td><?= $user['dept']?></td>
				</tr>
				<tr>
					<td><p><b>등급</b></p></td>
					<td><?= $user['perm']?></td>					
				</tr>							
			</table>
			<hr>

			<!--모달 버튼 그룹-->	
			<div id = "btn_group_modal" class="btn-group btn-group-sm" role="group" aria-label="...">
				<a class = "btn btn-secondary" href="/user/myroom/<?=$user['id']?>">마이룸</a>
				<a class = "btn btn-secondary" href="/user/logout/1">로그아웃</a> 
				<a class = "btn btn-secondary" href="/board/write">글쓰기</a>
			</div>	
		</div>


		<!------------------------------------------------------------------------------------------------>
		<!-- 웹모드 헤더 -->
		<header>
		<!--1. 헤더 BI 이미지 부분-->
		<div id = "header_d1">
			<a href="/main">
				<img id = "logo_img" src="/img/header/ci1.png">
			</a>
			
		</div>	

		<!--2. 헤더 상단 사용자 정보 부분-->
		<div id = "header_d2">	
			<div id = "top_user">

				<?php if(!isset($user['id'])): ?>
					<a id = "modal_img_cut" href="/main/login">									
						<img class = "user_info_img" src='/img/error/no_img.png'>
					</a>				

					<div id = 'user_states'>							
						<a href="/main/login">로그인 </a><p>/&nbsp;</p><a href="	/main/join">회원가입</a><hr>
						<h5>로그인이 필요합니다</h5>
					</div>

				<?php else: ?>
					
					<a id = "modal_img_cut" href="#ex1" rel="modal:open">					
						<img src="/img/users/<?=$user['id']?>/profile/<?=$user['img']?>" onerror = "this.src = '/img/error/no_img.png'">		
					</a>
					<div id ="user_states">
						<p>로그인 상태입니다</p><hr>
						<h5><?= $user['id']?>님</h5>						
					</div>						
					<?php endif; ?>			
				</div>
			</div>		
		</div>

		<!--3. 슬라이드 및 내부 테이블 부분-->
		<nav>
			<ul id = "nav_ul">

				<li><a href="/main">Home</a></li>
				<li class = "btn_menu">
					<p>홈페이지 소개</p>
					<div class = "slide_menu" id = "slide1">
					<div class = "table_title_div" id = "table_title_div1">
						<h3>홈페이지 소개</h3>						
					</div>	
						<!--버튼 내 확장 메뉴 table-->
						<table>
							<tr>
								<th>소개</th>
								<th>회사경영</th>
							
							</tr>
							<tr>
								<td><a href="/main/greeting">대표인사</a></td>
								<td><a href="/board/list/채용">채용</a></td>				
							</tr>
							<tr>
								<td><a href="/main/intro">홈페이지 소개</a></td>
								<td><a href="">공개</a></td>
							</tr>
							<tr>
								<td><a href="/main/map">오시는 길</a></td>
								<td><a href="">예결산</a></td>
							
							</tr>

						</table>
					</div>
				</li>

				<li class = "btn_menu">
					<a href="/board/menu"><p>커뮤니티</p></a>
					<div class = "slide_menu" id = "slide2">
						<div class = "table_title_div" id = "table_title_div2">
							<h3>커뮤니티</h3>						
						</div>
						<table>							
							<tr>
								<th>일반</th>
								<th>소통</th>								
								<th>학급</th>							
							</tr>
							<tr>
								<td><a href="/board/list/공지사항">공지사항</a></td>
								<td><a href="/board/list/등업">등업신청</a></td>			
								<!--로그인 상태일 때-->						
								<?php if($user): ?>
									<!--관리자, 부관리자 : 전체 학급 카테고리 버튼-->		
									<?php if($user['perm'] == "관리자" || $user['perm'] == "부관리자"): ?>
										<td><a href="/classroom/list/all">전체학급 보기</a></td>
									<!--일반 교사 : 자기 반으로 이동하는 버튼-->		
									<?php elseif($user['dept'] == "교사"): ?>
										<td><a href="/classroom/class">학급방문</a></td>
									<!--일반 학부모 : 자기 아동들이 속한 학급 카테고리 버튼-->		
									<?php elseif($user['dept'] == "학부모"): ?>
										<td><a href="/classroom/list">우리반 목록</a></td>									
									<?php endif;?>

								<!--로그인 안한 사용자는? -->		
								<?php else: ?>
									<td>로그인 후 이용하세요</td>
								<?php endif; ?>							
							</tr>
							<tr>
								<td><a href="/board/list/자유게시판">자유게시판</a></td>							
								<td><a href="/board/list/자기소개">자기소개</a></td>	

								<!--로그인 상태일 때 -->			
								<?php if($user): ?>
									<!--관리자, 부관리자 : 부서별 모든 커뮤니티 버튼-->		
									<?php if($user['perm'] == "관리자" || $user['perm'] == "부관리자"): ?>
										<td><a href="/board/list/교사">교사 커뮤니티</a></td>			
									<!--교사 : 교사 커뮤니티 버튼-->									
									<?php elseif($user['dept'] == "교사"): ?>
										<td><a href="/board/list/교사">교사 커뮤니티</a></td>	
									<!--교사 : 교사 커뮤니티 버튼-->		
									<?php elseif($user['dept'] == "학부모"): ?>
										<td><a href="/board/list/학부모">학부모 커뮤니티</a></td>	
									<?php endif; ?>

								<!--비로그인 상태-->		
					
								<?php endif; ?>	
							</tr>
							<tr>
								<td><a href="/board/list/QnA">Q&A</a></td>
								<td><a href="/board/list/정모">정모</a></td>			
								
								<!--교사 : 관리자, 부관리자 : 부서별 모든 커뮤니티 버튼-->		
								<?php if($user): ?> 
								  	<?php if ($user['perm'] == "관리자" || $user['perm'] == "부관리자"): ?>
										<td><a href="/board/list/학부모">학부모 커뮤니티</a></td>		
									<?php endif; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td><a href="/board/list/건의사항">건의사항</a></td>
							</tr>
						</table>
					</div>
				</li>

				<li class = "btn_menu">
					<p>개발센터</p>
					<div class = "slide_menu" id = "slide3">
						<div class = "table_title_div" id = "table_title_div3">
							<h3>개발센터</h3>								
						</div>	
						<table>
							<tr>
								<th>개발자</th>
								<th>참고싸이트</th>
								<th>CI</th>
							</tr>
							<tr>
								<td><a href="/main/intro_me">자기소개</a></td>								
								<td><a href="https://www.w3schools.com/">W3School</a></td>	
								<td><a href="https://cikorea.net/">CI 사용자 포럼</a></td>
							</tr>
							<tr>
								<td><a href="/main/timeline">이력사항</a></td>								
								<td><a href="http://www.ciboard.co.kr/user_guide/kr/">CI 3.0 가이드</a></td>
							</tr>
							<tr>								
								<td><a href="/main/library">사용기술</td>
														
							</tr>						
						</table>
					</div>
				</li>
				<li><a href="/main#company">협력업체</a></li>
				<div id = "wrap"></div>				
			</ul>		
		</nav>
	</header>

	<!------------------------------------------------------------------------------------------------>
	<!--Mobile 모드 헤더-->
	<div id = "m_header">
		<a href="/main"><h3>Woori-i</h3></a>
		<div id = "m_nav_btn">
			<svg viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
			</svg>	
		</div>
	</div>

	<!--Mobile 모드 우측 메뉴 슬라이드-->
	<div id = "m_nav_wrap" class = "m_nav_wrap">

		<div id = "m_nav">
		
			<svg id = "m_nav_close_btn" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>
			<!--비로그인 상태-->
			<?php if(!$user): ?>
				<div id= "m_user_info">
					<div id = "m_img_cut">
						<a href="/main/login">
							<img src="/img/error/no_img.png">
						</a>
						
					</div>
					<h4><b>로그인이 필요합니다</b></h4>
					<p><a href="/main/login">로그인</a> | <a href="/main/join">회원가입</a></p>
				</div>

			<!--로그인 상태일 경우-->
			<?php else: ?>
				<div id= "m_user_info">
					<div id = "m_img_cut">
						<img src="/img/users/<?=$user['id']?>/profile/<?=$user['img']?>" onerror = "this.src='/img/error/no_img.png'">
					</div>
					<h4><b><?=$user['id']?></b>님</h4>
					<!--유저 버튼 그룹-->
					<div id = "m_btn_group">
						<a class = "btn btn-secondary" href="/user/myroom/">마이룸</a>
						<a class = "btn btn-secondary" href="/user/logout/1">로그아웃</a> 
						<a class = "btn btn-secondary" href="/board/write">글쓰기</a>				
					</div>
				</div>
			<?php endif; ?>

			<!--슬라이드 내 카테고리 메뉴-->
			<ul id = "m_nav_ul">
				<li>
					<a href="/main">
						<h5>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
							  <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
							  <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
							</svg>
							홈으로
						</h5>
					</a>
				</li>
				<li>
					<h5>					
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
						</svg>
						홈페이지 소개
					</h5>
					<ul>
						<li><a href="/main/greeting">대표인사</a></li>
						<li><a href="/main/intro">홈페이지 소개</a></li>
						<li><a href="/main/map">오시는 길</a></li>
					</ul>
				</li>		
				<li>
					<h5>					
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
						</svg>
						커뮤니티					
					</h5>
					<ul>
						<li><a href="/board/list/공지사항">공지사항</a></li>
						<li><a href="/board/list/자유게시판">자유게시판</a></li>
						<li><a href="/board/list/QnA">Q&A</a></li>
						<li><a href="/board/list/건의사항">건의사항</a></li>
						<li><a href="/board/list/자기소개">자기소개</a></li>
						<li><a href="/board/list/정모">정모</a></li>		
						<li><a href="/board/list/채용">채용공고</a></li>
					</ul>
				</li>
				<li>
					<h5>					
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
						</svg>
						학급센터	
					</h5>
					<ul>	
						<!--로그인 상태-->
						<?php if($user): ?>
							<?php if($user['perm'] == "관리자" || $user['perm'] == "부관리자"): ?>
								<li><a href="/classroom/list/all">전체 학급보기</a></li>
								<li><a href="/board/list/학부모">학부모 커뮤니티</a></li>
								<li><a href="/board/list/교사">교사 커뮤니티</a></li>

							<?php elseif($user['dept'] == "학부모"): ?>
								<li><a href="/classroom/list/all">소속 학급보기</a></li>
								<li><a href="/board/list/학부모">학부모 커뮤니티</a></li>

							<?php elseif($user['dept'] == "교사"): ?>							
								<li><a href="/classroom/class">내 학급 관리하기</a></li>
								<li><a href="/board/list/교사">교사 커뮤니티</a></li>
							<?php endif; ?>
						<!--비로그인 상태-->
						<?php else: ?>
							<li>로그인 후 사용이 가능합니다</li>
						<?php endif; ?>
					</ul>
				</li>
				<li>
					<h5>					
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
						</svg>
						개발센터
					</h5>
					<ul>
						<li><a href="/main/intro_me">개발자소개</a></li>
						<li><a href="/main/timeline">이력사항</a></li>
						<li><a href="/main/language">개발도구</a></li>
					</ul>
				</li>	
			</ul>			
		</div>
	</div>

	<!--Web, Mobile --------------------------------------------------------------------->

	<!--전체 게시판 search div-->
	<div id = "all_search_btn">
		<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
		  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		</svg>
	</div>

	<div id = "all_search_wrap">
		<div id = "all_search_div">
			<h5>
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
				  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
				</svg>
				<b>전체 게시판 검색하기</b></h5>
			<div id = "all_search">
				<input type="text" name = "all_search" class = "form-control" placeholder="검색어를 입력하세요">
				<button onclick="all_search()">검색</button>
			</div>		
		</div>
	</div>

	<!--맨 위로 가기 버튼-->
	<a id = "topper" href="#">
		<svg id = "big_svg" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
		</svg>		
		<svg id = "sm_svg" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
		</svg>

	</a>

	<!--외부 스크립트 불러오기-->
	<script src = "/js/base/header.js"></script>

		
