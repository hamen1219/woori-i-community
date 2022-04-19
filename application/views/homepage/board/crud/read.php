<!--board/crud/read.php : 게시물 상세보기 페이지-->

<!--외부 css 가져오기-->
<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&family=Fjalla+One&family=Fredericka+the+Great&family=Sansita+Swashed&family=Shrikhand&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/board/crud/read.css">
<link rel="stylesheet" type="text/css" href="/css/board/crud/right.css">
<link rel="stylesheet" type="text/css" href="/css/board/crud/read_api.css">

<section>
	<!--왼쪽 div : 게시물 데이터-->
	<div id = "left">
		<div id = "board">
			<script>
				var board_num = <?=$board['num']?>;
				var addr_api = "<?=$board['addr_api']?>";
				var addr = "<?=$board['addr']?>";
				var user_id = "<?=$user?>";
				var reply = "<?=$board['reply']?>";
			</script>

			<!--블라인드 게시물일 경우 표시 (관리자 및 부관리자만 접근 가능)-->
			<?php if($board['perm'] == "블라인드"): ?>
				<div id = "blind">
					<h5><b>WARNING : 관리자가 제한한 게시물입니다</b></h5>
				</div>
			<?php endif; ?>
			
			<!--게시물 제목 페이지-->
			<div id = "title" class="<?=$board['class']?>">
				<h1><?=$board['title']?></h1>				
				<p>
					<label class="info_label">카테고리</label>| <a href="/board/list/<?=$board['cat'] ?>"><?=$board['cat'] ?></a> <br>
					<label class="info_label">작성일</label>| <?=$board['created']?>
					<?php if($board['updated'] !== null): ?>
						&nbsp; / 최종수정일 : <?=$board['updated']?>
					<?php endif; ?>

					<?php if($user == $board['user']): ?>
						<div id = "board_ctrl_group">
							<button id = "btn_board_update" onclick="ctrl_board(<?=$board['num']?>, 'update')">게시물 수정</button>
							<button id = "btn_board_delete" onclick="ctrl_board(<?=$board['num']?>, 'delete')">게시물 삭제</button>
						</div>
					<?php endif;?>
				</p>
			</div>	

			<!--게시물 정보-->
			<div id = "board_info">
				<!--작성자 프로필 : 클릭시 상세정보-->
				<div id = "img_cut">
					<img src="/img/users/<?=$board['user']?>/profile/<?=$board['user_img']?>" onerror = "this.src = '/img/error/no_img.png'">		
				</div>
				<ul class = "writer_info writer_info_hidden">
					<li><a href="/user/myroom/<?=$board['user']?>">유저상세보기</a></li>
					<li><a href="/board/list/작성자/<?=$board['user']?>">작성글보기</a></li>
					<!-- <li><a href="">쪽지보내기</a></li> -->
				</ul>			

				<!--작성자 정보-->
				<div id = "info_text">
					<p><label for="" class="info_label sm">작성 ID</label> | <?=$board['user']?></p>
					<p><label for="" class="info_label sm">작성자</label> |  <?="{$board['name']} ({$board['dept']}) "?></p>
					<p><label for="" class="info_label sm">가입일</label> |  <?=substr($board['user_created'], 0, 10)?></p>							
				</div>					
				
				<!--게시물 보관하기-->				
				<div onclick = "board_ajax('save')" id = "save" class="like_btn">
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bookmark-star" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
					  <path d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.178.178 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.178.178 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.178.178 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.178.178 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.178.178 0 0 0 .134-.098L7.84 4.1z"/>
					</svg>
					<h5><?=$board['save']?></h5>
				</div>								
				
				<!--게시물 싫어요-->	
				<div onclick = "board_ajax('poor')" id = "poor" class="like_btn">
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-hand-thumbs-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28v1c.563 0 .901.272 1.066.56.086.15.121.3.121.416 0 .12-.035.165-.04.17l-.354.353.353.354c.202.202.407.512.505.805.104.312.043.44-.005.488l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.415-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.353.352.373.714.267 1.021-.122.35-.396.593-.571.651-.653.218-1.447.224-2.11.164a8.907 8.907 0 0 1-1.094-.17l-.014-.004H9.62a.5.5 0 0 0-.595.643 8.34 8.34 0 0 1 .145 4.725c-.03.112-.128.215-.288.255l-.262.066c-.306.076-.642-.156-.667-.519-.075-1.081-.239-2.15-.482-2.85-.174-.502-.603-1.267-1.238-1.977C5.597 8.926 4.715 8.23 3.62 7.93 3.226 7.823 3 7.534 3 7.28V3.279c0-.26.22-.515.553-.55 1.293-.138 1.936-.53 2.491-.869l.04-.024c.27-.165.495-.296.776-.393.277-.096.63-.163 1.14-.163h3.5v-1H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
					</svg>
					<h5> <?=$board['poor']?></h5>
				</div>				

				<!--게시물 좋아요-->	
				<div onclick = "board_ajax('good')"  id = "good" class="like_btn">
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-hand-thumbs-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16v-1c.563 0 .901-.272 1.066-.56a.865.865 0 0 0 .121-.416c0-.12-.035-.165-.04-.17l-.354-.354.353-.354c.202-.201.407-.511.505-.804.104-.312.043-.441-.005-.488l-.353-.354.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315L12.793 9l.353-.354c.353-.352.373-.713.267-1.02-.122-.35-.396-.593-.571-.652-.653-.217-1.447-.224-2.11-.164a8.907 8.907 0 0 0-1.094.171l-.014.003-.003.001a.5.5 0 0 1-.595-.643 8.34 8.34 0 0 0 .145-4.726c-.03-.111-.128-.215-.288-.255l-.262-.065c-.306-.077-.642.156-.667.518-.075 1.082-.239 2.15-.482 2.85-.174.502-.603 1.268-1.238 1.977-.637.712-1.519 1.41-2.614 1.708-.394.108-.62.396-.62.65v4.002c0 .26.22.515.553.55 1.293.137 1.936.53 2.491.868l.04.025c.27.164.495.296.776.393.277.095.63.163 1.14.163h3.5v1H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
					</svg>
					<h5><?=$board['good']?></h5> 
				</div>					
				<script type="text/javascript">
					<?php if($board['mygood']): ?>
						$('#good').css('background-color','lightblue').css('border-bottom','5px solid purple');
					<?php elseif($board['mypoor']): ?>
						$('#poor').css('background-color', 'red').css('border-bottom','5px solid black');
					<?php endif; ?>
					<?php if($board['mysave']): ?>
						$('#save').css('background-color', 'lightgreen').css('border-bottom','5px solid green');
					<?php endif; ?>		
				</script>							
			</div>

			<!--첨부된 파일 있을 경우 보여주기-->
			<?php if($board['file'] != ""): ?>
				<div id = "board_file">
					<p>
						첨부파일 : <a href="/temp/file/<?=$board['file']?>"><?=$board['file']?></a>
					</p>
				</div>		
			<?php endif; ?>

			<!--게시물 contents -->
			<div id = "area">
				<?= $board['contents'] ?>
			</div>  	

			<!--지정한 장소 있을 경우 보여주기-->
			<?php if($board['addr'] != null && $board['addr_api'] != null): ?>	
				<!--맵 버튼-->
				<div id  = "map_btn">
					<h4>
						<svg id = "map_icon" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-map" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98l4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z"/>
						</svg>
						사용자가 지정한 장소 보기
					</h4>
				</div>

				<!--맵 슬라이드-->
				<div id = "map_wrap">
					<div id="container" class="view_map">
					    <div id="mapWrapper" style="width:100%;height:100%;position:relative;">
					        <div id="map" style="width:100%;height:100%"></div> <!-- 지도를 표시할 div 입니다 -->
					        <input type="button" id="btnRoadview" onclick="toggleMap(false)" title="로드뷰 보기" value="로드뷰">
					    </div>
					    <div id="rvWrapper" style="width:100%;height:100%;position:absolute;top:0;left:0;">
					        <div id="roadview" style="height:100%"></div> <!-- 로드뷰를 표시할 div 입니다 -->
					        <input type="button" id="btnMap" onclick="toggleMap(true)" title="지도 보기" value="지도">
					    </div>
					</div>					
				</div>
			<?php endif; ?>
			


			<!--게시물 댓글 ---------------------------------------------------------------------------->
			<!--댓글 쓰기 창 (부모 댓글)-->	
			<div id  = "reply_write">
				<p id = "reply_title">댓글쓰기</p>
				<textarea id = "reply_area" placeholder="댓글을 입력하세요"></textarea>								
				<button id = "reply_btn" onclick = "reply_ajax('write')">확인</button>
			</div>						

			<!--게시물 댓글 (하단 내용 Ajax로 갱신됨) ---------------------------------------------------->			
			<!--전체 댓글을 감싸는 reply div-->	
			<div id = "reply">				
				<!--댓글 없을 시 -->				
				<?php if(!$reply_cnt) :?>
				<div id = "reply_cnt">					
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
					  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
					</svg>
					<h6>댓글 없음</h6>
				</div>
				
				<!--댓글 존재할 때 -->	
				<?php else: ?>		
				<!--댓글 수 -->	
				<div id = "reply_cnt">					
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-square-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
					  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
					</svg>
					<!--댓글 수 가져오기-->
					<h6>댓글(<?=$reply_cnt?>)</h6>
					<svg id = "dd" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-border-width" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-2zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
					</svg>		
				</div>			
			
				<!--댓글 슬라이더 -->
				<div id = "reply_slide">
					<?php foreach($reply as $row): ?>							
					<ul class = "writer_info writer_info_hidden reply_writer_info">;
					    <li><a href="/user/myroom/<?=$row['user']?>">유저상세보기</a></li>;
						<li><a href="/board/list/작성자/<?=$row['user']?>">게시물보기</a></li>;
						<!-- <li><a href="#">쪽지보내기</a></li> -->
					</ul>

					<!--부모 댓글 div 시작-->
					<?php if($row['parent_num'] === null) : ?>					
					<div class = "reply_parent replys">			
					<!--자녀 댓글 div 시작-->
					<?php else: ?>						
					<div class = "reply_child replys">									
					<?php endif; ?>		

					<!--각 댓글의 정보 hidden에 넣어주기-->
					<input type="hidden" name ="reply_num" value = "<?=$row['num']?>">
					<input type="hidden" name ="parent_num" value = "<?=$row['parent_num']?>">
					<input type="hidden" name ="reply_group" value = "<?=$row['reply_group']?>">
		
					<!--로그인 한 사용자가 있고 댓글 작성자 정보와 동일하면 수정 및 삭제 표시-->

					<?php if($row['user'] === $user): ?>
						<div class = "reply_modify">
						<a onclick="reply_ajax('update', this)">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
							</svg>
						</a>
						<a onclick="reply_ajax('delete', this)">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
							</svg>								
						</a>	
						</div>		
					<?php endif; ?>

					<!--댓글 작성자 이미지-->							
					<div class = "reply_img_cut">
					<?php if($row['user_img'] !== "") : ?>
						<img src="/img/users/<?=$row['user']?>/profile/<?=$row['user_img']?>" onerror = "this.src='/img/error/no_img.png'">		
					<?php else: ?>
						<img src="/img/error/no_img.png">		
					<?php endif; ?>						
					</div>	
					<ul class = "writer_info writer_info_hidden reply_writer_info">
						<li><a href="/user/myroom/<?=$row['user']?>">유저상세보기</a></li>
						<li><a href="/board/list/작성자/<?=$row['user']?>">게시물보기</a></li>
						<!-- <li><a href="">쪽지보내기</a></li> -->
					</ul>
					<h5><?=$row['user']?></h5>		

					<!--댓글 작성 내용 (삭제된 댓글이면 삭제되었음을 표시)-->	
					<div class = "reply_contents">					
						<?php if($row['contents'] === ""): ?>
							<b><p style="color: blue;">작성자가 삭제한 댓글입니다</p></b>
						<?php else: ?>
							<p><?=$row['contents']?></p>							 
						<?php endif; ?>														
					</div>				

					<!--댓글에 대한 좋아요, 싫어요 div-->
					<div class = "reply_like">
						<p><?=$row['reply_created']?>
							<!--부모 댓글인 동시에 삭제되지 않은 댓글이라면 답글 버튼 표시-->
							<?php if($row['parent_num'] === null && $row['contents'] !== ''): ?>
								<a class = "re_reply_btn" onclick="re_reply(this, <?=$row['num']?>, <?=$row['reply_group']?>)">답글</a>
							<?php endif; ?>								
						</p>
						<div>
							<!--공감, 비공감 (내가 누른 공감, 비공감 있을 경우 표시)-->	
							<?php if($row['contents'] !== ""): ?>
								<?php if($row['mygood'] == "1"): ?>
									<button class = "reply_btn_good" style = "background-color: rgba(20,20,120,0.2);" onclick="reply_ajax('good', this)">공감   <?=$row['good'] ?></button> |
									<button class = "reply_btn_poor" onclick="reply_ajax('poor', this)"> 비공감 <?=$row['poor'] ?></button>

								<?php elseif($row['mypoor'] == "1"): ?>
									<button class = "reply_btn_good" onclick="reply_ajax('good', this)">공감   <?=$row['good'] ?></button> |
									<button class = "reply_btn_poor" style = "background-color: rgba(20,20,120,0.2);" onclick="reply_ajax('poor', this)"> 비공감 <?=$row['poor'] ?></button>

								<?php else: ?>
									<button class = "reply_btn_good" onclick="reply_ajax('good', this)">공감   <?=$row['good'] ?></button> |
									<button class = "reply_btn_poor" onclick="reply_ajax('poor', this)"> 비공감 <?=$row['poor'] ?></button>
								<?php endif; ?>

							<?php else: ?>
								<button style = "cursor:default;" class = "reply_btn_good" >공감   <?=$row['good'] ?></button> | 
								<button style = "cursor:default;" class = "reply_btn_poor" > 비공감 <?=$row['poor'] ?></button>								
							<?php endif; ?>										
						</div>						
					</div>
					<!--부모 및 자녀 댓글 마무리-->
				</div>
			<!--댓글 출력 foreach 마무리-->		
			<?php endforeach; ?>
			</div>
		<!--댓글 유무 파악 if문 마무리-->
		<?php endif; ?>
		</div>	
		</div>
	</div>

	<!--오른쪽 div : 현재시간 및 최근게시물-->
	<div id = "right">
		<!--시계-->
		<div id = "clock">			
			<div class="clock_inner">

			</div>
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
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a5b25014628de860e329f4da35b7370e&libraries=services"></script>
<script src = "/js/board/crud/read.js"></script>
<script src = "/js/board/crud/clock.js"></script>
<?php if($board['addr_api'] != ""):?>
	<script src = "/js/board/crud/read_api.js"></script>
<?php endif; ?>




