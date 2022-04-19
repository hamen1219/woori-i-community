$("#main_slide").slick({					
	slidesToShow: 1,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 3000,
	arrows: false,
	verticalSwiping: true,
	pauseOnHover:false,
	dots: true,
	fade: true
});

//
$('#rank').slick({
  	slidesToShow: 1,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 2000,
	vertical: true
	//arrows: true
});


//게시판 슬라이더
$('#alert_slide').slick({
  	slidesToShow: 1,
	slidesToScroll: 1,
	dots: true
});

$('#gallary_slide').slick({
    slidesToShow: 4,
	slidesToScroll: 4,
	arrows: true,
	dots: true,
    responsive: [
    {
        breakpoint: 1250,
        settings: {
	    slidesToShow: 3,
		slidesToScroll: 3			
     }
  	},
    {
        breakpoint: 1000,
        settings: {
	    slidesToShow: 2,
		slidesToScroll: 2			
     }
  },
    {
      breakpoint: 700,
      settings: {
        slidesToShow: 1,
		slidesToScroll: 1
	
      }
    }
  ]
});

//하단 회사 소개 슬라이더
$('#company_slide').slick({
  slidesToShow: 3,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 2000,
    responsive: [

    {
        breakpoint: 1550,
        settings: {
	    slidesToShow: 2,
		slidesToScroll: 1			
     }},
    {
        breakpoint: 900,
        settings: {
	    slidesToShow: 1,
		slidesToScroll: 1			
     }
 }]
 
});

$('#m_slide').slick({
  slidesToShow: 3,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 2000,
    responsive: [
    {
        breakpoint: 901,
        settings: {
	    slidesToShow: 1,
		slidesToScroll: 1			
     }}]
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
	$('#btn_group button').eq(1).addClass('ajax_button');
	$('#btn_group button').click(function(){
		$('#btn_group button').removeClass();
		$(this).addClass('ajax_button');
	});
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
	const color = ['lightgreen', 'lightblue', 'ivory', 'brown'];
	//7가지의 숫자 돌리기
	const r = Math.floor(Math.random()*4); 
	$('#learn_title').css({'background-color': color[r]});		
}
function animateTitle()
{	
	randomColor();
	setInterval(randomColor, 1500);
}


function numberCounter(target_frame, target_number, object_id) {
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
var v_total = $('#v_total').val(); 
var v_today = $('#v_today').val();
new numberCounter("total_counter", v_total);
new numberCounter("today_counter", v_today);