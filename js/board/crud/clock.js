var clock_arr=['Bai Jamjuree, sans-serif', 'Fjalla One, sans-serif', 'Fredericka the Great, cursive', 'Sansita Swashed, cursive', 'Shrikhand, cursive'];
var clock_num = 0;
//현재 시간을 출력해주는 함수
function printTime()
{
    //click을 통해 cnt 1씩 증가, cnt가 4가 되면 0으로 초기화 (다시 배열 처음부터)
    $('#clock').click(function(){       
        if(clock_num==4)
        {
            clock_num = 0;
        }
        else
        {
            clock_num += 1;
        }       
    });

	//현재시간 넣을 div
    var clock = document.getElementById("clock");
    //현재시간 객체 생성
    var now = new Date();

    //홀수자리일 경우 맨 앞자리 0을 붙여준다.
    hour = (String(now.getHours()).length  === 1) ? "0"+String(now.getHours())   : now.getHours();
    min = (String(now.getMinutes()).length === 1) ? "0"+String(now.getMinutes()) : now.getMinutes();
    sec = (String(now.getSeconds()).length === 1) ? "0"+String(now.getSeconds()) : now.getSeconds();

    //div 내 html print
    clock.innerHTML = "<p>클릭하면 테마변경</p> <h1 class ='clock_text'>"+hour+":"+min+"</h1><h5 class = 'clock_text'>"+sec+"</h5>";
    $('.clock_text').css({'font-family' : clock_arr[clock_num]});	       

    // setTimeout 함수를 통해 현재 함수(시간 출력 함수)를 1초 간격으로 실행
    setTimeout("printTime(clock_num)", 1000);
}  
//페이지 로드 이후 시간 출력 함수가 실행된다.
window.onload = printTime(clock_num);

