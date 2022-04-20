<!--board/crud/update.php : 게시물 수정 페이지-->	

<!--외부 스타일 불러오기-->	
<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&family=Fjalla+One&family=Fredericka+the+Great&family=Sansita+Swashed&family=Shrikhand&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/board/crud/update_api.css">
<link rel="stylesheet" type="text/css" href="/css/board/crud/update.css">
<link rel="stylesheet" type="text/css" href="/css/board/crud/right.css">

<section>
	<script>
		var user = <?=json_encode($user)?>,
		    board = <?=json_encode($board)?>,
		    base_url = <?=json_encode(base_url())?>;
	</script>

	<!--게시물 데이터 전송할 form-->	
	<form id = "left" action = "/board_crud/update/page/<?=$board['num']?>" enctype="multipart/form-data" method="post" onsubmit="return form_submit();">
		<!--클릭한 주소를 저장할 hidden. 이후 form 데이터 전달 시 사용-->
		<input type="hidden" name = "addr" value="<?=$board['addr']?>">
		<input type="hidden" name = "addr_api" value="<?=$board['addr_api']?>">

		<div id = "form_title">
			<h2>게시물 수정</h2>
			<p>게시물을 수정할 수 있습니다</p>
		</div>

		<!--게시물 상단 입력 정보-->	
		<table id = "board_info_table">
			<tr>
				<td><p><b>제목</b></p></td>
				<td>
					<input type="text" id = "title" name="title" value="<?=$board['title']?>">
				</td>
			</tr>

			<tr>
				<td><p><b>옵션</b></p></td>
				<td>
					<label><p>댓글 제한</p><input type="checkbox" id = "ck_reply" name="reply" value="제한"></label> &nbsp;
				</td>
			</tr>

			<tr>
				<td><p><b>카테고리</b></p></td>
				<td>				
					<!--카테고리 select box-->	
					<select name = "cat" id = "cat" onchange="changeArea()">				
						<option value="등업" selected>등업신청</option>	
			
						<?php if($user['perm'] == "관리자" || $user['perm'] == "부관리자"): ?>
							<option value ="채용">채용공고</option>
							<option value="공지사항">공지사항</option>
							<option value="운영진">운영진</option> 
							<option value="교사">교사 커뮤니티</option>
							<option value="학부모">학부모 커뮤니티</option>		

						<?php elseif($user['dept'] == "교사"):?>
							<option value="교사">교사 커뮤니티</option>
						<?php elseif($user['dept'] == "학부모"):?>
							<option value="학부모">학부모 커뮤니티</option>
						<?php endif;?>

						<option value="자유게시판" selected>자유게시판</option>
					    <option value="건의사항">건의사항</option>			
					    <option value="Q&A">Q&A</option>
					    <option value="자기소개">자기소개</option>
						<option value ="정모">정모</option>					
					</select>
				</td>
			</tr>			
		</table>

		<!--게시물 contents-->	
		<div id = "contents">
			<textarea name = "contents" class="form-control" id="area" rows="20" ></textarea>
		</div>

		<!--첨부 파일-->	
		<table id = "file_table">
			<tr>
				<td>
					<p>첨부된 파일</p>
				</td>
				<td>
					<p>현재파일 : 
						<?php if($board['file'] == ""): ?>
							없음
						<?php else: ?>
							<?=$board['file']?> &nbsp; | &nbsp; 삭제하기
							<input type="checkbox" name="ck_file" value="삭제"> 
						<?php endif; ?>					
					</p>					
				</td>
			</tr>
			<tr>
				<td>
					<p>새로운 파일첨부</p>
				</td>
				<td>
					<input type="file" name="file">
				</td>
			</tr>			
		</table>

		<!--지도 버튼-->	
		<div id = "map_btn">
			<h3>지도 사용하기</h3>
		</div>

		<!--지도 슬라이드-->	
		<div>
			<div id = "map_slide">
				<div id = "map_tip">
					<p>원하는 장소를 검색 후 클릭하면 지정 및 변경 됩니다. x표시를 누르면 취소됩니다</p>
				</div>
				<div id="location_xy"></div>	
				<div class="map_wrap">
			    	<div id="map"></div>

				    <div class="hAddr">
				        <span><b>지도중심기준 행정동 주소정보</b></span>
				        <span id="centerAddr"></span>
				    </div>

				     <div id="menu_wrap" class="bg_white">
				        <div class="option">
				            <div>
				            	<!-- input button 으로 사용해야 form의 submit 강제 실행 방지 가능 -->			   
			                    키워드 : <input type="text" id="keyword" size="15"> 
			                    <input type = "button" onclick="searchPlaces()" value = "검색하기">			           
				            </div>
				        </div>
				        <hr>
			        	<ul id="placesList"></ul>
			        	<div id="pagination"></div>
		    		</div>		   
				</div>				
			</div>

			<!--게시물 버튼 그룹-->	
			<div id = "btn_group">
				<button class="btn btn-primary" type = "submit">등록</button>
				
				<button class="btn btn-secondary" onclick="history.back()">뒤로</button>
			</div>			
		</div>			
	</form>	

	<!--오른쪽 div (현재시간, 최근 게시물)-->	
	<div id = "right">
		<!--시계-->
		<div id = "clock">			
			<div class="clock_inner"></div>
		</div>
		<!--최근 게시물-->
		<div id = "latest">
			<h4>최근게시물</h4>

			<!--최근 게시물 있을 경우-->	
			<?php if($side['rs']): ?>
				<?php $cnt = 1; ?>
				<?php foreach($side['rs'] as $row):?>
					<?php if($row['perm'] == "블라인드"): ?>
						<a class = "news">
							<h5 class = "title_num"><b><?= $cnt++ ?></b></h5>
							<div >						
								<h5><b>제한된 게시물</b></h5>
								<p><?=$row['cat']?> | <?=$row['user']?> | <?=substr($row['created'], 2, 8)?> </p>						
							</div>					
						</a>
					<?php else: ?>
						<a class = "news" href = "/board/read/page/<?=$row['num']?>">
							<h5 class = "title_num"><b><?= $cnt++ ?></b></h5>
							<div>						
								<h5><?=$title = mb_strlen($row['title']) > 20 ? mb_substr($row['title'], 0,15)." ··" : $row['title'] ?></h5>
								<p><?=$row['cat']?> | <?=$row['user']?> | <?=substr($row['created'], 2, 8)?> </p>						
							</div>						
						</a>
					<?php endif; ?>
				<?php endforeach; ?>

			<!--최근 게시물 없을 경우-->
			<?php else: ?>
				<a class = "news">
					<h5 class = "title_num">0</h5>
					<div >						
						<h5><b>최근 게시물이 없습니다</b></h5>					
					</div>					
				</a>
			<?php endif; ?>
		</div>	
	</div>

	<!--float 제거 div-->	
	<div id = "bottom"></div>
</section>

<!--외부 스크립트 불러오기-->	
<script src="/static/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a5b25014628de860e329f4da35b7370e&libraries=services"></script>

<script src = "/js/board/crud/clock.js"></script>
<script src = "/js/board/crud/write.js"></script>
<script src = "/js/board/crud/update_api.js"></script>


