<!--home.php : 메인 페이지-->  

<!--외부 스타일 불러오기-->
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR&family=Open+Sans+Condensed:wght@300&display=swap&family=Jua&family=Do+Hyeon&family=East+Sea+Dokdo&display=swap&family=Anton" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/home.css">
<link rel="stylesheet" type="text/css" href="/css/home_api.css">

<!--방문자 카운트 hidden input-->
<input type="hidden" id = "v_total" value="<?=$v_total?>">
<input type="hidden" id = "v_today" value="<?=$v_today?>">

<!--메인 slide-->
<div id = "main_slide">	
	<div>	
		<img id = "slide_img1" src="/img/3.png">
		<div class  ="title_group">
			<h2>아이들이 행복한 우리아이 커뮤니티 입니다</h2>
			<p>Too Happy, To Children. Woori-i Community</p>
		</div>		
	</div>
	<div>	
		<img id = "slide_img2" src="/img/1.png">
		<div class  ="title_group">
			<h2>아이들의 일상, 육아 등 다양한 교류를 즐겨보세요</h2>
			<p>Woori-i Coummunity with Various Information</p>
		</div>		
	</div>
	<div>	
		<img id = "slide_img3" src="/img/2.png">
		<div class  ="title_group">
			<h2>지금, 우리아이 커뮤니티를 시작하세요</h2>
			<p>Welcome to Woori-i Community Site</p>
		</div>		
	</div>
</div>

<!--mobile 메인 slide-->
<div id = "m_slide_wrap">
	<div id = "m_slide_title">
		<p>우리아이 커뮤니티에 오신 것을 환영합니다</p>
	</div>

	<div id = "m_slide">
		<div>		
			<img src="/img/1.png">
		</div>
		<div>
			<img src="/img/2.png">
		</div>
		<div>
			<img src="/img/3.png">
		</div>
	</div>
</div>

<!--슬라이드 이후 컨텐츠-->
<section>
	<!--대문 게시글-->
	<div id = "notice">
		<h4>
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-up" viewBox="0 0 16 16">
		  	<path d="M11.536 14.01A8.473 8.473 0 0 0 14.026 8a8.473 8.473 0 0 0-2.49-6.01l-.708.707A7.476 7.476 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/>
			  <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.483 5.483 0 0 1 11.025 8a5.483 5.483 0 0 1-1.61 3.89l.706.706z"/>
			  <path d="M10.025 8a4.486 4.486 0 0 1-1.318 3.182L8 10.475A3.489 3.489 0 0 0 9.025 8c0-.966-.392-1.841-1.025-2.475l.707-.707A4.486 4.486 0 0 1 10.025 8zM7 4a.5.5 0 0 0-.812-.39L3.825 5.5H1.5A.5.5 0 0 0 1 6v4a.5.5 0 0 0 .5.5h2.325l2.363 1.89A.5.5 0 0 0 7 12V4zM4.312 6.39L6 5.04v5.92L4.312 9.61A.5.5 0 0 0 4 9.5H2v-3h2a.5.5 0 0 0 .312-.11z"/>
			</svg>
			<span>커뮤니티 대문글</span>			
		</h4>

		<!--대문 게시글 있을 경우-->
		<?php if($intro): ?>
			<h5><b><?= $intro['contents']?></b></h5>
			<p>ㄴ 작성 : <?=$intro['perm']?> (<?= $intro['created']?>)</p>

		<!--대문 게시글 없을 경우-->
		<?php else: ?>
			<style type="text/css">
				#notice h5{
					margin-top: 30px;
					text-align: center;
				}
			</style>
			<h5><b>현재 등록된 대문글이 없습니다 :)</b></h5>
		<?php endif; ?>		
	</div>

	<!--랭킹 slide div 감싸는 div-->
	<div id = "rank_div">
		<div>
			<p>총 방문</p>		
			<div>
				<h1 id = "total_counter"></h1><p>명</p>
			</div>			
		</div>

		<div>
			<p>오늘의 로그인</p>		
			<div>
				<h1 id = "today_counter"></h1><p>명</p>
			</div>			
		</div>

		<!--게시물 및 방문 유저 Top 랭킹-->
		<div>
			<p>유저 랭킹</p>		
			<div id = "rank">
				<?php if($b_max): ?>
					<a href = "/user/myroom/<?=$b_max['user']?>">
						<div class = "slide_img_cut">
							<img src="/img/users/<?=$b_max['user']?>/profile/<?=$b_max['user_img']?>" onerror="this.src='/img/error/no_img.png'">
						</div>
						<div class = "slide_info">
							<div class = "slide_info_title">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
								</svg>
								게시물 최다
							</div><br>
							<h4 class = "user_id"><?=$b_max['user']?></h4>
							<h5 class = "total_num"><?=$b_max['b_max']?>개</h5>
						</div>							
					</a>	
				<?php endif; ?>	
				<?php if($r_max): ?>
					<a href = "/user/myroom/<?=$r_max['user']?>">
						<div class = "slide_img_cut">
							<img src="/img/users/<?=$r_max['user']?>/profile/<?=$r_max['user_img']?>" onerror="this.src='/img/error/no_img.png'">
						</div>
						<div class = "slide_info">
							<div class = "slide_info_title">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
								</svg>
								댓글 최다
							</div><br>
							<h4 class = "user_id"><?=$r_max['user']?></h4><h5 class = "total_num"><?=$r_max['r_max']?>개</h5>
						</div>							
					</a>	
				<?php endif; ?>	
				<?php if($v_max): ?>
					<a href = "/user/myroom/<?=$v_max['user']?>">
						<div class = "slide_img_cut">
							<img src="/img/users/<?=$v_max['user']?>/profile/<?=$v_max['user_img']?>" onerror="this.src='/img/error/no_img.png'">
						</div>
						<div class = "slide_info">
							<div class = "slide_info_title">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
								</svg>
								방문 최다
							</div><br>
							<h4 class = "user_id"><?=$v_max['user']?></h4><h5 class = "total_num"><?=$v_max['v_max']?>회</h5>
						</div>							
					</a>	
				<?php endif; ?>	
				<?php if($lb_max): ?>
					<a href = "/user/myroom/<?=$lb_max['user']?>">
						<div class = "slide_img_cut">
							<img src="/img/users/<?=$lb_max['user']?>/profile/<?=$lb_max['user_img']?>" onerror="this.src='/img/error/no_img.png'">
						</div>
						<div class = "slide_info">
							<div class = "slide_info_title">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
								</svg>
								좋은 게시물 최다
							</div><br>
							<h4 class = "user_id"><?=$lb_max['user']?></h4><h5 class = "total_num"><?=$lb_max['lb_max']?>개</h5>
						</div>							
					</a>	
				<?php endif; ?>	
				<?php if($lr_max): ?>
					<a href = "/user/myroom/<?=$lr_max['user']?>">
						<div class = "slide_img_cut">
							<img src="/img/users/<?=$lr_max['user']?>/profile/<?=$lr_max['user_img']?>" onerror="this.src='/img/error/no_img.png'">
						</div>
						<div class = "slide_info">
							<div class = "slide_info_title">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
								</svg>
								선플 최다 작성
							</div><br>
							<h4 class = "user_id"><?=$lr_max['user']?></h4><h5 class = "total_num"><?=$lr_max['lr_max']?>개</h5>
						</div>							
					</a>	
				<?php endif; ?>	
				<?php if($sb_max): ?>
					<a href = "/user/myroom/<?=$sb_max['user']?>">
						<div class = "slide_img_cut">
							<img src="/img/users/<?=$sb_max['user']?>/profile/<?=$sb_max['user_img']?>" onerror="this.src='/img/error/no_img.png'">
						</div>
						<div class = "slide_info">
							<div class = "slide_info_title">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
								</svg>
								게시물 pick
							</div><br>
							<h4 class = "user_id"><?=$sb_max['user']?></h4><h5 class = "total_num"><?=$sb_max['sb_max']?>개</h5>
						</div>							
					</a>		
				<?php endif; ?>										
			</div>		
		</div>
	</div>


	<!--게시판 그룹 div-->
	<div id = "board_group">
		<!--정모 게시판 미리보기-->
		<div id = "board_meeting">
			<a href="/board/list/정모">
				<h3>커뮤니티 정모</h3>
			</a>
			<hr>
			<div id="container" class="view_map">			
				<div id = "map_none">
					<p>선택된 장소가 없습니다</p>
				</div>
				<div id = "map_group">
					<div id="mapWrapper" style="width:100%;height:320px;position:relative;">
				        <div id="map" style="width:100%;height:100%">			        	
				        </div> <!-- 지도를 표시할 div 입니다 -->
				        <input type="button" id="btnRoadview" class = "hide" onclick="toggleMap(false)" title="로드뷰 보기" value="로드뷰">
				    </div>
				    <div id="rvWrapper" style="width:100%;height:320px;position:absolute;top:0;left:0;">
				        <div id="roadview" style="height:100%"></div> <!-- 로드뷰를 표시할 div 입니다 -->
				        <input type="button" id="btnMap" onclick="toggleMap(true)" title="지도 보기" value="지도">
			    	</div>					
				</div>
				<p id = "map_title" class = "hide"></p>
			</div>
			<!--정모 게시물 있을 경우-->
			<div id = "meeting">
				<?php if($meeting): ?>
					<table>
						<tr>
							<th>장소</th>
							<th>제목</th>
							<th>작성</th>
						</tr>					
					<?php foreach($meeting['rs'] as $row): ?>
						<?php $title = strlen($row['title']) > 12 ? mb_substr($row['title'], 0, 12, 'UTF-8')." ··" : $row['title']?>
						<?php $addr = mb_substr($row['addr'], 0, 2, 'UTF-8'); ?>
						<tr>
							<td><button class = "meeting_map_btn"><?=$addr?></button></td>
							<td><a href="/board/read/page/<?=$row['num']?>"><?=$title?></a></td>
							<td><?=$row['created']?></td>
							<input type="hidden" name="addr" value = "<?=$row['addr']?>">
							<input type="hidden" name="addr_api" value = "<?=$row['addr_api']?>">
						</tr>
					<?php endforeach; ?>
					</table>
					<p> * 장소명 클릭하여 지도정보 확인</p>

				<!--정모 게시물 없을 경우-->
				<?php else: ?>
					<p>등록된 정모 없음</p>
				<?php endif; ?>
			</div>
		</div>

		<!--ajax로 게시판 불러오기 (3개 카테고리)-->
		<div id = "board_ajax">
			<a href="/board/menu">
				<h3>게시판</h3>
			</a>
			<hr>
			<!--카테고리 버튼-->
			<div id = "btn_group">
				<button onclick="get_ajax('공지사항')">공지사항</button>
				<button onclick="get_ajax('자유게시판')">자유게시판</button>
				<button onclick="get_ajax('건의사항')">건의사항</button>
			</div>

			<!--게시판 들어갈 div-->
			<div id = "mini_board"></div>	
		</div>

		<!--배너 슬라이드-->
		<div id = "board_alert">
			<h3>배너</h3><hr>
			<div id ="alert_slide">
				<img src="/img/mainpage/banner_section/1.png" href="/board/read/page/">
				<img src="/img/mainpage/banner_section/2.png" href="/board/read/page/">
				<img src="/img/mainpage/banner_section/3.png" href="/board/read/page/">
				<img src="/img/mainpage/banner_section/4.png" href="/board/read/page/">
				<img src="/img/mainpage/banner_section/5.png" href="/board/read/page/">		    									
			</div>
		</div>

		<!--갤러리 슬라이드-->
		<div id = "board_gallary">
			<a href="/board/list/자기소개"><h3>회원 자기소개</h3></a><hr>

			<!--자기소개 게시물 있을 경우-->
			<?php if(!$gallary): ?>		
				<h3 style="height: 120px; width: 100%; text-align: center; margin-top: 100px; color: brown;">현재 작성된 자기소개가 없습니다</h3>					
			<!--자기소개 게시물 없을 경우-->
			<?php else: ?>
				<div id = "gallary_slide">		
					<?php foreach($gallary['rs'] as $val): ?>
						<a class = "gallary_img_cut" href="/board/read/page/<?=$val['num']?>" onerror = "this.src='img/error/no_img.png'">					
							<img src="/<?=$val['img']?>">
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>		
			</div>
		</div>
	</div>

	<!--애니메이션-->
	<div id = "truck">		
		<svg id = "truck_svg" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-truck" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5v7h-1v-7a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5v1A1.5 1.5 0 0 1 0 10.5v-7zM4.5 11h6v1h-6v-1z"/>
		  <path fill-rule="evenodd" d="M11 5h2.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5h-1v-1h1a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4.5h-1V5zm-8 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
		  <path fill-rule="evenodd" d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
		</svg>
	</div>

	<!-- learning contents div -->
	<div id = "learn_div">	
		<div id = "learn_title"> <h1>TV 속 친구들과 함께!!</h1><br><p>다양한 주제가를 부르며 춤춰봐요</p></div>

		<!--메인 동영상-->
		<div id = "mov">
			<iframe  title="YouTube video player" class="youtube-player" type="text/html"  width="560" height="315" src="//www.youtube.com/embed/lHTqUBIr5Gk?fs=1" frameborder="0" allowfullscreen></iframe>
			<div id = "text">
				<h1>Let's dance</h1>				
				<h1>and Singing</h1>
				<h1>with Friends</h1>
			</div>
		</div>

		<!--관련 동영상 그룹-->
		<h5><b>관련동영상 모음</b></h5>		
 		<div id = "mov_group">
			<iframe  title="YouTube video player" class="youtube-player" type="text/html"  width="560" height="315" src="//www.youtube.com/embed/YxzL5DW5Z7E?fs=1" frameborder="0" allowfullscreen></iframe>
			<iframe  title="YouTube video player" class="youtube-player" type="text/html"  width="560" height="315" src="//www.youtube.com/embed/E0W5sJZ2d64?fs=1" frameborder="0" allowfullscreen></iframe>
			<iframe  title="YouTube video player" class="youtube-player" type="text/html"  width="560" height="315" src="//www.youtube.com/embed/_Rvs0GIXRu8?fs=1" frameborder="0" allowfullscreen></iframe>
			<iframe  title="YouTube video player" class="youtube-player" type="text/html"  width="560" height="315" src="//www.youtube.com/embed/tVU53nGuPGw?fs=1" frameborder="0" allowfullscreen></iframe>
		</div> 
	</div>

	<!--협력업체 슬라이드-->
	<div id = "company">
		<h3>협력업체 및 기관</h3><hr>
		<div id = "company_slide">
			<a href="http://www.hanshinc.com/">
				<img src="/img/company/apt.png">
			</a>
			<a href="http://www.woori.cc/">
				<img src="/img/company/woori.png">
			</a>
			<a href="https://www.bible.ac.kr/">
				<img src="/img/company/kbu.png">
			</a>
			<a href="https://www.gg.go.kr/">
				<img src="/img/company/gg.png">
			</a>
		</div>
	</div>
</section>

<!--외부 스크립트 불러오기-->
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a5b25014628de860e329f4da35b7370e&libraries=services"></script>
<script src="/js/home.js"></script>
<script src="/js/home_api.js"></script>
