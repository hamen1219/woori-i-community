$(function(){
    var container = document.getElementById('container'), // 지도와 로드뷰를 감싸고 있는 div 입니다
    mapWrapper = document.getElementById('mapWrapper'), // 지도를 감싸고 있는 div 입니다
    btnRoadview = document.getElementById('btnRoadview'), // 지도 위의 로드뷰 버튼, 클릭하면 지도는 감춰지고 로드뷰가 보입니다 
    btnMap = document.getElementById('btnMap'), // 로드뷰 위의 지도 버튼, 클릭하면 로드뷰는 감춰지고 지도가 보입니다 

    mapContainer = document.getElementById('map'); // 지도를 표시할 div 입니다

    //$('#map_group').addClass('map_hide');

    $('.meeting_map_btn').stop().click(function(){

        //click시 해당 게시물 첨부 주소를 보여준다.
        var addr_api = $(this).closest('tr').children('input[name = addr_api]').val();
        var addr =  $(this).closest('tr').children('input[name = addr]').val();

        //주소 없을 경우 지도 제거
        var arr = addr_api.split(',');

        var addr1 = parseFloat(arr[0]);
        var addr2 = parseFloat(arr[1]); 

        $('.meeting_map_btn').stop().removeClass('push');
        $(this).stop().addClass('push');

        if(arr === undefined || arr == "")
        {
            $('#map_group').stop().addClass('hide');
            $('#btnRoadview').stop().addClass('hide');
            $('#map_title').stop().addClass('hide');
            $('#map_none').stop().removeClass('hide');
        }
        else
        {
            $('#map_group').stop().removeClass('hide');
            $('#btnRoadview').stop().removeClass('hide');
            $('#map_none').stop().addClass('hide');
            $('#map_title').stop().removeClass('hide').text("정모 : "+addr);
        }       
        

        var placePosition = new kakao.maps.LatLng(addr1, addr2);

        // 지도 옵션입니다 
        var mapOption = {
            center: placePosition, // 지도의 중심좌표 
            level: 2 // 지도의 확대 레벨
        };

        // 지도를 표시할 div와 지도 옵션으로 지도를 생성합니다
        var map = new kakao.maps.Map(mapContainer, mapOption);

        var rvContainer = document.getElementById('roadview'); // 로드뷰를 표시할 div
        var rv = new kakao.maps.Roadview(rvContainer); // 로드뷰 객체 생성
        var rc = new kakao.maps.RoadviewClient(); // 좌표를 통한 로드뷰의 panoid를 추출하기 위한 로드뷰 help객체 생성
        var rvResetValue = {} //로드뷰의 초기화 값을 저장할 변수
        rc.getNearestPanoId(placePosition, 50, function(panoId) {
            rv.setPanoId(panoId, placePosition);//좌표에 근접한 panoId를 통해 로드뷰를 실행합니다.
            rvResetValue.panoId = panoId;
        });



        //지도 이동 이벤트 핸들러
        function moveKakaoMap(self){
            
            var center = map.getCenter(), 
                lat = center.getLat(),
                lng = center.getLng();

            self.href = 'https://map.kakao.com/link/map/' + encodeURIComponent('스페이스 닷원') + ',' + lat + ',' + lng; //Kakao 지도로 보내는 링크
        }

        //지도 초기화 이벤트 핸들러
        function resetKakaoMap(){
            map.setCenter(mapCenter); //지도를 초기화 했던 값으로 다시 셋팅합니다.
            map.setLevel(mapOption.level);
        }

        //로드뷰 이동 이벤트 핸들러
        function moveKakaoRoadview(self){
            var panoId = rv.getPanoId(); //현 로드뷰의 panoId값을 가져옵니다.
            var viewpoint = rv.getViewpoint(); //현 로드뷰의 viewpoint(pan,tilt,zoom)값을 가져옵니다.
            self.href = 'https://map.kakao.com/?panoid='+panoId+'&pan='+viewpoint.pan+'&tilt='+viewpoint.tilt+'&zoom='+viewpoint.zoom; //Kakao 지도 로드뷰로 보내는 링크
        }

        //로드뷰 초기화 이벤트 핸들러
        function resetRoadview(){
            //초기화를 위해 저장해둔 변수를 통해 로드뷰를 초기상태로 돌립니다.
            rv.setViewpoint({
                pan: rvResetValue.pan, tilt: rvResetValue.tilt, zoom: rvResetValue.zoom
            });
            rv.setPanoId(rvResetValue.panoId);
        }


        // 로드뷰 객체를 생성합니다 
        var roadview = new kakao.maps.Roadview(rvContainer);

        // 로드뷰의 위치를 특정 장소를 포함하는 파노라마 ID로 설정합니다
        // 로드뷰의 파노라마 ID는 Wizard를 사용하면 쉽게 얻을수 있습니다 
        roadview.setPanoId(1023434522, placePosition);

        // 특정 장소가 잘보이도록 로드뷰의 적절한 시점(ViewPoint)을 설정합니다 
        // Wizard를 사용하면 적절한 로드뷰 시점(ViewPoint)값을 쉽게 확인할 수 있습니다
        roadview.setViewpoint({
            pan: 321,
            tilt: 0,
            zoom: 0
        });

        // 지도 중심을 표시할 마커를 생성하고 특정 장소 위에 표시합니다 
        var mapMarker = new kakao.maps.Marker({
            position: placePosition,
            map: map
        });

        // 로드뷰 초기화가 완료되면 
        kakao.maps.event.addListener(roadview, 'init', function() {

            // 로드뷰에 특정 장소를 표시할 마커를 생성하고 로드뷰 위에 표시합니다 
            var rvMarker = new kakao.maps.Marker({
                position: placePosition,
                map: roadview
            });
        });


    });

    // 지도와 로드뷰 위에 마커로 표시할 특정 장소의 좌표입니다 
   

});

// 지도와 로드뷰를 감싸고 있는 div의 class를 변경하여 지도를 숨기거나 보이게 하는 함수입니다 
function toggleMap(active) {
    if (active) {

        // 지도가 보이도록 지도와 로드뷰를 감싸고 있는 div의 class를 변경합니다
        container.className = "view_map"
    } else {

        // 지도가 숨겨지도록 지도와 로드뷰를 감싸고 있는 div의 class를 변경합니다
        container.className = "view_roadview"   
    }
}