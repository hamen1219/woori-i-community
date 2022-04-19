<!--board/meeting.php : 정모 게시판 리스트-->  

<!--외부 스타일 불러오기-->
<link rel="stylesheet" type="text/css" href="/css/board/list.css">
<link rel="stylesheet" type="text/css" href="/css/board/meeting.css">
    
<!--리스트 제목-->
<div id = "list_title">
     <a href="<?=$url?>">
         <h1><?= $title?></h1> 
     </a>    
     <?=$cat_link?>                              
</div>

<section>
    <!--비로그인 시-->
    <?php if(!$user): ?>
        <div id = "search_alert">
            <p><b>※ 로그인 후 게시물 상세보기가 가능합니다</b></p>
        </div>
    <?php endif; ?>

    <!--검색 div-->
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

                <select id ="type" name = "type">
                    <option value="작성자">작성자</option>
                    <option value="내용">내용</option>
                    <option value="제목">제목</option>
                    <option value="전체" selected>전체</option>
                </select>                      
            </div>
        </form>
    </div>


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

        <div id = "search_count">
            <p>카테고리 전체</p><p><?=$total_board?></p> &nbsp;
            <p>검색된 게시물</p><p><?=$board?></p>
        </div>               
    </div>    

 
    <table>
        <tr>
            <th>글번호</th>
            <th>정모장소</th>
            <th>정모제목</th>                    
            <th>작성자</th>
            <th>작성일</th>
            <th>좋아요</th>
            <th>조회수</th>
        </tr>

        <!--검색결과가 있을 경우-->
        <?php if($rs):?>
            <?php foreach($rs as $row): ?>
                <?php $reply_cnt = $row['reply_cnt'] === '0' ? "" : "<p id = 'reply_cnt' class ='title_p'>&nbsp;(".$row['reply_cnt'].")</p>" ?>    
                                             
                <tr>
                    <td><?= $row['num']?></td>

                     <td><?= mb_substr($row['addr'], 0,strpos($row['addr'], ' '), 'UTF-8' )?></td></td>
                    <?php if($row['perm'] == "블라인드"): ?>
                        <td><b>관리자에 의해 제한된 게시물입니다</b></td>
                    <?php else: ?>
                         <td><a href="/board/read/page/<?=$row['num']?>"><?= "<p class = 'title_p'>".$row['title']."</p>".$reply_cnt ?></a></td>
                    <?php endif; ?>

                    <td><a href="/user/myroom/<?=$row['user']?>"><?= $row['user']?></a></td>
                    <td><?= substr($row['created'], 0, 16)?></td>
                    <td><?= $row['good']?></td>
                    <td><?= $row['view']?></td>
                </tr>
            <?php endforeach; ?>

        <!--검색결과가 없을 경우-->
        <?php else: ?>
            <tr>
                <td colspan="7">검색된 자료가 없습니다</td>
            </tr>
        <?php endif; ?>                              
    </table>  

    <!--페이징 링크-->        
    <div id = "paging_link">
        <?= $paging_link?>                              
    </div> 

    <!--글쓰기 버튼-->
    <button id = "btn_write" onclick="location.href='/board/write/cat/<?=$cat?>'">글쓰기</button>
</section>

<!--외부 스크립트 불러오기-->
<script src = "/js/board/list.js"></script>