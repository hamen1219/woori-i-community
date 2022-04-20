
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR&family=Open+Sans+Condensed:wght@300&display=swap&family=Do+Hyeon&display=swap&family=Anton" rel="stylesheet">
<style>

    /* 메인 페이지 슬라이드 및 이미지 */
    #main_slide, #main_slide>div{
    	width: 100%;
    	height: 560px;
    	background-color: ghostwhite;
    	overflow: hidden;    
    	z-index: 0;
	}
    #main_slide img{    
    	width: 100%;    
    	background-size: cover;    	
    }

    /* 슬라이드 앞,뒤 버튼 */
    #main_slide .slick-prev{
	    left:3%;    	
	    z-index: 1;    
    }
    #main_slide .slick-next{
    	right:3%;    	
	    z-index: 1;    
    } 

    /* 제목 및 h2, p태그 */
    .title_group{ 
    	position: absolute;
    	top:190px;
    	z-index: 1;
    	height: auto;
    	margin-top: 10px;
    	text-align: center;
 
    	
    	width: 100%;
    	background-color: rgba(255,255,255,0.5);    
    	padding-top: 40px;
    	padding-bottom: 40px;
    }
    .title_group h2{
    	margin-bottom: 10px;
    	font-family: 'Noto Serif KR', serif;	
    }
    .title_group p{
    	font-family: 'Open Sans Condensed', sans-serif;
    	font-size: 20px;
    }   
    /* section : 본 페이지 각종 컨텐츠 */
    section{
    	padding: 20px;
		height: auto;
		min-height: 600px;
		width: 80%;
		margin-left: 10%;
		padding-top: 50px;
		padding-bottom: 50px;
		border: 1px solid lightgray;
	}

	section hr{
		margin-bottom: 20px;
		margin-top: 10px;
	}
	/* 상단 intro : 관리자 인사 문구 및 유저/게시판 랭킹 */
	#notice{
		min-height: 130px;
		height: auto;
		width: 90%;
		margin-left: 5%;
		margin-bottom: 50px;
		background-color: ghostwhite;
		border: 2px solid gray;
		text-align: center;
		box-shadow: 1px 1px 10px 1px black;
		transition: all 0.4s; 
	}
	#notice h5{
		margin-top: 20px;
		margin-bottom: 10px;
	}
	#notice p{
		background-color: rgba(255,255,255, 1);
		width: 70%;
		display: inline-block;
		text-align: center;
		border: 1px solid gray;
	}
	#notice:hover{
		background-color: lightblue;		
		transition: all 0.5s
		border: 2px solid skyblue;
	}

	#rank{
		width: 100%;
		height: 110px;
		text-align: center;
		margin-bottom: 50px;
		padding-bottom: 20px;
		border-bottom: 1px solid gray;
	}
	#user_rank, #board_rank{
		height: 100%;
		width: 40%;		
		display: inline-block;
	
	}
	/* 중간 게시판 모음 관련 (ajax 게시판) */

	#board_group{
		height: auto;
	}
	#board_ajax{
		height: 400px;
		width: 49%;
		float: left;
	}
	#btn_group{
		height: 33px;
		width: 100%;
		border: 1px solid lightgray;
		text-align: center;
		overflow: hidden;
	}
	#btn_group button{
		width: 32%;
		height: 30px;
		display: inline-block;
		border: 0;
		background-color: transparent;
	}
	#btn_group button:hover{
		border-bottom: 5px solid gray;
		color: gray;
	}

	#mini_table{
		margin-top: 20px;
		width: 100%;
		text-align: center;
	}
	#mini_table_a{
		display: block;
	}
	#mini_table td:nth-child(2){
		width: 40%;
	}
	#mini_table th{
		background-color: lightgray;
	}
	#mini_table tr{
		height: 40px;
		border-bottom: 1px solid lightgray;
	}
	#mini_table tr:hover{
		background-color: rgba(20,20,20,0.05);
	}
	#mini_table tr:last-child{
		border: 2px solid silver;
		background-color: rgba(20,20,20,0.03);
		transition: all 0.3s;
	}
	#mini_table tr:last-child:hover{
		background-color: rgba(20,20,20,0.5);
		border: 0;
	}
	#mini_table tr:last-child:hover a{
		color: white;
		text-decoration-line: none;
	}



	/* 공지 슬라이드(board_alert) 및 슬라이드 버튼 관련 */
	#board_alert{
		height: 400px;
		width: 49%;
		display: inline-block;
		margin-bottom: 50px;
		float: right;
	}
	#board_alert .slick-prev{
		left: 42%;
		z-index: 1;
		top: 310px;
	}
	#board_alert .slick-next{
		right: 42%;
		z-index: 1;
		top: 310px;
	}
	#alert_slide{
		width: 350px;
		height: 330px;
		margin:auto;
		overflow: hidden;
		background-color: gray;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 20px;
	}
	#alert_slide>div{
		border: 2px solid white;
	}

	/* 포토갤러리 슬라이드 */
	#board_gallary{	
		clear: both;
		height: auto;
		width: 100%;				
		padding: 10px;
		padding-bottom: 20px;
		margin-bottom:200px;
		background-color: rgba(20,20,20,0.05);
	}

	#gallary_slide{
		width: 90%;
		height: auto;
		margin: auto;
	}

	#gallary_slide a{
		display:inline-block;
		height: auto;
		position: relative;	
		overflow: hidden;
	}
	#gallary_slide img{
		width: 100%;
		height: auto;
		margin: 5px;
		background-color: white;
		position: relative;
		bottom: 10px;
		right: 10px;
	}


	/* 학습 게시판 div 및 svg 아이콘 */
	#learn_div{
		position: relative;
		height: auto;
		width: 100%;		
		padding-top: 30px;
		padding-bottom: 30px;
		margin-bottom: 50px;
		background-color: beige;
	}

	#truck svg{
		width: 100px;
		height: 100px;
		margin-left: 46%;
		margin-bottom:120px;
		transition: all 0.5;
	}
	/* 학습 게시판 제목 div */
	#learn_title{
		height: 200px;
		width: 90%;
		margin: auto;
		background-color: lightblue;
		box-shadow: 1px 1px 8px black;
		text-align: center;
		padding-top: 50px;
		margin-bottom: 50px;
		font-family: 'Do Hyeon', sans-serif;
		transition: all 0.5s;
	}
	#learn_title h1{
		font-size: 50px;
	}
	#learn_title p{
		font-size: 20px;
	}
	/* 학습 게시판 동영상 및 설명 관련 */
	#mov{
		margin-top: 30px;
		width: 100%;
		height: 310px;
		display: inline-block;		
		margin-bottom: 30px;
		padding-top: 5px;
		transition: all 0.3s;

	}
	#mov iframe{
		width: 500px;
		height: 300px;
		display: inline-block;
		float: left;
	}
	#mov:hover{
		background-color: gray;
		color: white;
	}
	#text{
		width: 38%;
		height: 300px;
		display: inline-block;
		float: left;
		margin-left: 6%;

	}
	#text h1{
		font-family: 'Anton', sans-serif;
		font-style: italic;
		font-size: 50px;
		margin-top: 20px;
		margin-bottom: 10px;
		transition: all 0.3s;
	}
	#text h1:first-child{
		text-align: left;
	}
	#text h1:nth-child(2){
		text-align: center;
	}
	#text h1:last-child{
		text-align: right;		
		margin-top: 30px;
	}
	#text h1:hover{
		font-size: 65px;
		color: purple;
	}
	#mov_group{		
		width: 100%;
		height: auto;
		min-height: 200px;
		margin-bottom: 50px;
		display: inline-block;
		text-align: center;		
		padding-top: 12px;
		background-color: purple;
		box-shadow: 3px 3px 5px black;
		transition: all 0.3s;
	}
	#mov_group:hover{		
		background-color: brown;
	}
	#mov_group iframe{
		width: 20%;
		margin: 1%;
		border-radius: 2px;
		transition: all 0.2s;
	}

	#mov_group iframe:hover{
		border-bottom: 3px solid white;
	}


	/* 협력업체 슬라이드 */
	#company{
		width: 100%;
		height: 190px;
	}
	#company_slide{
		width: auto;
		height: 110px;	
		margin-bottom: 50px;
		margin-top: 30px;
		padding-top: 5px;
		border: 1px solid lightgray;
		overflow: hidden;

	}
	#company_slide a{
		height: 100px;
		width: 110%;
		overflow: hidden; 	
		text-align: center;
	}
	#company img{
		width: auto;
		height: 100px;
		display: inline-block;		
	}


    /* 반응형 */

    @media(min-width: 901px) and (max-width: 1250px){
    	#board_ajax table td:last-child, #board_ajax table th:last-child{
    		display: none;
    	}   
    	#board_ajax table th:first-child{
    		width: 30%;
    	}  
    }
    @media(min-width: 601px) and (max-width: 900px){
    	#board_ajax table td:last-child, #board_ajax table th:last-child, #board_ajax table td:first-child, #board_ajax table th:first-child{
    		display: none;
    	}   
    	#board_ajax table th:first-child{
    		width: 30%;
    	}  
    }




    @media(min-width: 1021px) and (max-width: 1300px){
    	section{
    		width: 90%;
    		margin-left: 5%;
    	}   
    }
    @media(max-width: 1020px){
    	section{
    		width: 100%;
    		margin-left: 0;
    	}
    }
    
    @media(min-width: 921px) and (max-width: 1080px){
    	#main_slide img{    
    		position: relative;
	    	width: 145%; 
	    	background-size: cover;	    	
	    }
	    #text{
    		margin: 3%;
    		width: 35%;
    		float:right;
    		margin-right: 10px;
    	}   
    }
     @media(min-width: 841px) and (max-width: 920px){

	    #text{    		
    		width: 28%;
    		float:right;
    		margin-right: 15px;
    	}   
    	#text h1{
    		font-size: 40px;
    	}
    	#text h1:hover{
    		font-size: 50px;
    	}
    
    }
     @media(min-width: 0px) and (max-width: 840px){

	    #text{
    		display: none;
    	}   
    	#mov{
    		margin-left: 15%;
    	}
    }
    @media(min-width: 601px) and (max-width: 699px){
    	#main_slide img{    
	    	height: 560px;    
	    	width: auto;
	    	background-size: cover;	    
	    }
	   #user_rank, #board_rank{
	   		background-color: yellow;
	   		width: 49%;
	    }
	   
    }    
    @media(max-width: 600px) 
	{
		#main_slide,#main_slide>div{
    		display: none;
    	}
    	.title_group{
	    	display: none;
	    }
	    #rank{
	    	height: auto;
	    	padding: 0;
	    }
	    #user_rank, #board_rank{
	   		display: block;
	   		width: 100%;
	   		height: 70px;
	    }
	    
	    #board_ajax, #board_alert, #mov iframe{
	    	display: block;
	    	width: 100%;
	    }
	    #board_alert{
	    	margin-top: 50px;
	    }
	    #truck{
	    	display: none;
	    }
	    #learn_title{
	    	margin-bottom: 30px;

	    }
	    #learn_title h1{
	    	font-size: 20px;
	    }
	    #text{
	    	display: none;
	    }
	    #mov_group{
	    	height: auto;
	    }
	    #mov_group iframe{
	    	float: left;
	    	width: 47%;
	    }

	}

  
</style>
<!--메인페이지 슬라이드-->
<!-- 
<div id = "main_slide">	
	<div>	
		<img id = "slide_img1" src="/img/3.png">
		<div class  ="title_group">
			<h2>다양한 사람들과 함께하는 이데아입니다</h2>
			<p>Too many people with IDEA Community</p>
		</div>		
	</div>

	<div>	
		<img id = "slide_img2" src="/img/1.png">
		<div class  ="title_group">
			<h2>이데아는 IT 기술에 대한 다양한 정보를 제공합니다</h2>
			<p>We have Newest IT Technology and Variable Information</p>
		</div>		
	</div>

	<div>	
		<img id = "slide_img3" src="/img/2.png">
		<div class  ="title_group">
			<h2>지금, 이데아를 시작해보세요</h2>
			<p>Welcome to IDEA Community Site</p>
		</div>		
	</div>
</div>


 -->

<div id = "aa">
	<div>1</div>
</div>

<section>
	<div id = "notice">
		<?php if(isset($contents)): ?>
			<h5><?= $contents?></h5>
			<p><?= $created." 관리자 작성"?></p>
		<?php else: ?>
			<style type="text/css">
				#notice h5{
					margin-top: 50px;
				}
			</style>
			<h5><b>현재 등록된 대문글이 없습니다 :)</b></h5>
		<?php endif; ?>
		
	</div>

	<div id = "rank">
		
		<div id = "user_rank">
			<h1 id = "counter">	</h1>
		</div>
		<div id = "board_rank">	
			순위
		</div>
	</div>


	<div id = "board_group">
		<div id = "board_ajax">
			<h3>게시판</h3><hr>
			<div id = "btn_group">
				<button onclick="get_ajax('공지사항')">공지사항</button>
				<button onclick="get_ajax('자유게시판')">자유게시판</button>
				<button onclick="get_ajax('건의사항')">건의사항</button>
				<div class="bottom"></div>
			</div>
				

			<div id = "mini_board">
				<!--내부에 ajax를 통한 테이블 생성 예정-->
			</div>	
		</div>
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


		<div id = "board_gallary">
			<h3>포토갤러리</h3><hr>
			<div id = "gallary_slide">

				<?php for($i=0; $i<5; $i++): ?>

					<a href="">
						<img src="/img/error/no_img.png">
					</a>
						
				
					
				<?php endfor; ?>			
			</div>
		</div>
	</div>

	<div id = "truck">
		
		<svg id = "truck_svg" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-truck" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5v7h-1v-7a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5v1A1.5 1.5 0 0 1 0 10.5v-7zM4.5 11h6v1h-6v-1z"/>
		  <path fill-rule="evenodd" d="M11 5h2.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5h-1v-1h1a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4.5h-1V5zm-8 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
		  <path fill-rule="evenodd" d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
		</svg>
	</div>

	<!-- learning contents -->
	<div id = "learn_div">	
		<div id = "learn_title"> <h1>실전 프로그래밍!!</h1><br><p>	MVC패턴 및 IT 지식을 학습해봅시다 :)</p></div>

		<div id = "mov">
			<iframe title="YouTube video player" class="youtube-player" type="text/html"    src="//www.youtube.com/embed/dy9yQIx38u8?autoplay=1&showinfo=1&fs=1" frameborder="0" allowfullscreen></iframe>
			<div id = "text">
				<h1>Front-End</h1>
				<h1>Back-End</h1>
				<h1>Full-Stack</h1>
			</div>
		</div>
		<h5><b>관련동영상 모음</b></h5>		
 		<div id = "mov_group">
			<iframe src="https://www.youtube.com/embed/JlwUoHeICvw?list=PLrCCNh6y7w2hh4UxxzFJYTqAP01SQdB7T" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			<iframe src="https://www.youtube.com/embed/LYTaNX7-m2E" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			<iframe src="https://www.youtube.com/embed/AERY1ZGoYc8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			<iframe src="https://www.youtube.com/embed/AERY1ZGoYc8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div> 
	</div>

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

<script>
	//메인페이지 상단 소개 slide
	$("#main_slide").slick({					
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000,
		arrows: true,
		verticalSwiping: true,
		pauseOnHover:false,
		dots: true,
		fade: true
	});

	//게시판 슬라이더
	$('#alert_slide').slick({
	  	slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000,
		arrows: true
	});

	$('#gallary_slide').slick({
	    slidesToShow: 4,
		slidesToScroll: 4,
		arrows: true,
	    responsive: [
	    {
	        breakpoint: 1000,
	        settings: {
		    slidesToShow: 3,
			slidesToScroll: 3			
	     }
	  },
	    {
	      breakpoint: 700,
	      settings: {
	        slidesToShow: 2,
			slidesToScroll: 2
		
	      }
	    }
	  ]
	});

	//하단 회사 소개 슬라이더
	$('#company_slide').slick({
	  slidesToShow: 2,
	  slidesToScroll: 1,
	  mobileFirst: true,
	  autoplay: true,
	  autoplaySpeed: 2000,
	  responsive: [
	  {
	  		breakpoint: 700,
	        settings: {
	        slidesToShow: 3,
			slidesToScroll: 1,
			autoplay: true,
	  		autoplaySpeed: 1500
	   		}
	   	}
	   ]
	});

	////

	$('#learn_title').hover(function(){
		$(this).stop().animate({'background-color': 'lightgreen'}, 500);
	}, function(){
		$(this).stop().animate({'background-color': 'lightblue'}, 500);
	});


	$('#truck').hover(function(){
		$('svg',this).stop().animate({'margin-left': '86%'}, 1000);
	}, function(){
		$('svg',this).stop().animate({'margin-left': '46%'}, 1000);
	});

	
	////

	//ajax 게시판 보여주기
	$(document).ready(function(){
		get_ajax('자유게시판');
		animateTitle();

	});

	//ajax 서버와 연동하는 함수
	//게시판 정보를 html 코드로 받아온다.
	function get_ajax(board)
	{
		$.ajax({
			type : 'post',
			url : '/ajax/mini_board',
			data : { board : board},
			dataType : 'text',
			success: function(result){
				$('#mini_board').html(result);
			}, error:function(request,status,error){
				document.write("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	}

	function randomColor(option)
	{
		const color = ['rgba(0,20,100,0.5)','rgba(150,220,150,0.5)','rgba(211,0,111,0.5)','rgba(150,150,150,0.5)','rgba(0,200,10,0.5)','rgba(100,120,100,0.5)','rgba(200,100,100,0.5)'];
		//7가지의 숫자 돌리기
		const r = Math.floor(Math.random()*7); 
		$('#learn_title').css({'background-color': color[r]});		
	}
	function animateTitle()
	{	
		randomColor();
		setInterval(randomColor, 2000);
	}


	function numberCounter(target_frame, target_number) {
    this.count = 0; this.diff = 0;
    this.target_count = parseInt(target_number);
    this.target_frame = document.getElementById(target_frame);
    this.timer = null;
    this.counter();
};
	numberCounter.prototype.counter = function() {
	    var self = this;
	    this.diff = this.target_count - this.count;
	     
	    if(this.diff > 0) {
	        self.count += Math.ceil(this.diff / 5);
	    }
	     
	    this.target_frame.innerHTML = this.count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	     
	    if(this.count < this.target_count) {
	        this.timer = setTimeout(function() { self.counter(); }, 20);
	    } else {
	        clearTimeout(this.timer);
	    }
	};

	new numberCounter("counter", 300);
</script>
