<!--board/intro_list.php : 자기소개 게시물 리스트-->  

<!--외부 스타일 불러오기-->
<link rel="stylesheet" type="text/css" href="/css/board/intro_list.css">
    <div id = "list_title">
         <a href="<?=$url?>">
             <h1><?= $title?></h1> 
         </a>

        <?=$cat_link?>  
                       
    </div>
    <section>
        

        <?php if($user == ""): ?>
            <div id = "search_alert">
                <p><b>※ 로그인 후 게시물 상세보기가 가능합니다</b></p>
            </div>
        <?php endif; ?>

        <div id = "search_bar">
           <form action="<?=$url?>" method="post" id="f1">
                <label for = 'search'><p>검색 &nbsp; </p></label>
                <script>
                    var search = "<?=$search?>";
                </script>
                <input type="text" id="search" name="search" value="" placeholder="검색어를 입력하세요">
             
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
        <style type="text/css">
           

        </style>
        <div id = "flex_div">
       
            <?php if($rs): ?>
                <?php foreach($rs as $row): ?>
                    <a href = "/board/read/page/<?=$row['num']?>">
                        <div class = "item">
                            <div class = "item_img_cut">
                                <img src="<?=$row['board_img']?>" onerror="this.src='/img/error/no_img.png'">
                            </div>
                            <h4><?=$row['user']?></h4>         
                        </div>
                    </a>
                <?php endforeach; ?>

            <?php else: ?>
                <p>검색된 자료가 없습니다</p>               
            <?php endif; ?>
        </div>   

        <div id = "paging_link">
            <?= $paging_link?>                              
        </div> 
        <button id = "btn_write" onclick="location.href='/board/write/cat/<?=$cat?>'">글쓰기</button>

        <script>
            var search = "<?=$search?>";
        </script>
      
        
    </section>
    <script src = "/js/board/list.js"></script>
</body>
</html>