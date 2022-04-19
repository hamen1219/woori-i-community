<!--board/list.php : 일반 게시물 리스트-->  

<!--외부 스타일 불러오기-->
<link rel="stylesheet" type="text/css" href="http://pr.hyundai.com/#/pages/main.aspx/css/font/ModernHMedium.eot">
<link rel="stylesheet" type="text/css" href="/css/board/list.css">

<!--부서별 CSS 적용-->
<?php if($title == "학부모 커뮤니티"): ?>
    <link rel="stylesheet" type="text/css" href="/css/board/list_parent.css">

<?php elseif($title == "교사 커뮤니티"): ?>
    <link rel="stylesheet" type="text/css" href="/css/board/list_teacher.css">
<?php endif; ?>


<!--리스트 제목 및 링크 그룹-->
<div id = "list_title">
     <a href="<?=$url?>">
         <h1><?= $title?></h1> 
     </a>

     <?php if(isset($cat_link)): ?>
         <?=$cat_link?>  
     <?php endif; ?>                      
</div>

<section>
    <!--로그인 유저 확인-->
    <?php if($user == ""): ?>
        <div id = "search_alert">
            <p><b>※ 로그인 후 게시물 상세보기가 가능합니다</b></p>
        </div>
    <?php endif; ?>

    <!--검색 관련 div-->
    <div id = "search_bar">
        <form action="<?=$url?>" method="post" id="f1">
            <label for = 'search'><p>검색 &nbsp; </p></label>
            <input type="text" id="search" name="search" placeholder="검색어를 입력하세요">
            <script>
                var search = "<?=$search?>";
            </script>
            <button type = "submit" id = "submit">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                </svg>
            </button>

            <div id = "select_group">
                <select id= "sort" name = "sort">
                    <option value="최신순" selected>최신순</option>
                    <option value="과거순">과거순</option>
                </select>   

                <select id ="type" name = "option">
                    <option value="작성자">작성자</option>
                    <option value="내용">내용</option>
                    <option value="제목">제목</option>
                    <option value="전체" selected>전체</option>
                </select>                      
            </div>
        </form>
    </div>
    
    <!--검색 결과-->
    <div id = "search_info">
        <div id = "search_msg">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
            </svg>
            <?php if($search == "") :?>
                <p>전체 검색결과</p>
            <?php elseif($search !== ""): ?>
                 <p>'<?=$search?>' 에 대한 검색결과</p>
            <?php endif; ?>                  
        </div>

        <!--검색 결과 count-->
        <div id = "search_count">
            <p>카테고리 전체</p><p><?=$total_board?></p> &nbsp;
            <p>검색된 게시물</p><p><?=$board?></p>
        </div>               
    </div>    

    <!--게시물 출력 테이블-->
    <table>
        <tr>
            <th>글번호</th>
            <th>내용</th>
            <th>제목</th>                    
            <th>작성자</th>
            <th>작성일</th>
            <th>좋아요</th>
            <th>조회수</th>
        </tr>

        <!--게시물 결과값 유효시-->
        <?php if($rs): ?>
             <!--rs(limit_board 값) 요소 전체 출력-->
             <?php foreach($rs as $row): ?>
                <?php $reply_cnt = $row['reply_cnt'] === '0' ? "" : "<p id = 'reply_cnt' class ='title_p'>&nbsp;(".$row['reply_cnt'].")</p>" ?>                                                 
                <tr>
                    <td><?= $row['num']?></td>
                     <td>
                        <!--사진 미리보기 되는 게시판-->
                        <?php if($title == "건의사항" || $title == "Q&A" || $title == "자유게시판" || $title == "공지사항") : ?>                        
                            <div class="board_img_cut">
                                <img class = "board_img" src="<?=$row['board_img']?>" onerror = "this.src='/img/error/no_img.png'">
                            </div>

                        <!--사진 유무만 보여주는 게시판-->
                        <?php else: ?>
                            <?php if($row['board_img'] != ""): ?>
                                <svg width="1.0625em" height="1em" viewBox="0 0 17 16" class="bi bi-image-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V13a1 1 0 0 1-1 1h-12a1 1 0 0 1-1-1v-1zm5-6.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            <?php else: ?>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-blockquote-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm5 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                  <path d="M3.734 6.352a6.586 6.586 0 0 0-.445.275 1.94 1.94 0 0 0-.346.299 1.38 1.38 0 0 0-.252.369c-.058.129-.1.295-.123.498h.282c.242 0 .431.06.568.182.14.117.21.29.21.521a.697.697 0 0 1-.187.463c-.12.14-.289.21-.503.21-.336 0-.577-.108-.721-.327C2.072 8.619 2 8.328 2 7.969c0-.254.055-.485.164-.692.11-.21.242-.398.398-.562.16-.168.33-.31.51-.428.18-.117.33-.213.451-.287l.211.352zm2.168 0a6.588 6.588 0 0 0-.445.275 1.94 1.94 0 0 0-.346.299c-.113.12-.199.246-.257.375a1.75 1.75 0 0 0-.118.492h.282c.242 0 .431.06.568.182.14.117.21.29.21.521a.697.697 0 0 1-.187.463c-.12.14-.289.21-.504.21-.335 0-.576-.108-.72-.327-.145-.223-.217-.514-.217-.873 0-.254.055-.485.164-.692.11-.21.242-.398.398-.562.16-.168.33-.31.51-.428.18-.117.33-.213.451-.287l.211.352z"/>
                                </svg>
                            <?php endif; ?>
                        <?php endif; ?>

                    </td>
                     <!--블라인드 처리 된 게시물일 경우 링크 막기-->
                    <?php if($row['perm'] == "블라인드"): ?>
                        <td><b>관리자에 의해 제한된 게시물입니다</b></td>
                    <?php else: ?>
                        <?php $title_b = strlen($row['title']) > 12 ? mb_substr($row['title'], 0, 12, 'UTF-8')." ··" : $row['title']?>
                         <td><a href="/board/read/page/<?=$row['num']?>"><?= "<p class = 'title_p'>".$title_b."</p>".$reply_cnt ?></a></td>
                    <?php endif; ?>
                    <td><a href="/user/myroom/<?=$row['user']?>"><?= $row['user']?></a></td>
                    <td><?= substr($row['created'], 0, 16)?></td>
                    <td><?= $row['good']?></td>
                    <td><?= $row['view']?></td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="7">검색된 결과가 없습니다</td>
            </tr>
        <?php endif; ?>
    </table>

     <!--페이징 링크-->
    <div id = "paging_link">
        <?= $paging_link?>                              
    </div> 
    <button id = "btn_write" onclick="location.href='/board/write/cat/<?=$cat?>'">글쓰기</button>
        <!--글쓰기 버튼-->
</section>

<!--외부 스크립트 불러오기-->

<script src = "/js/board/list.js"></script>
<script src = "/js/board/list_slide.js"></script>