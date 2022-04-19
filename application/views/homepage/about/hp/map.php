<link rel="stylesheet" type="text/css" href="/css/about/hp/map.css">

<section>
	<div id = "title">
		<h2>오시는 길</h2>
		<p>Site map</p>
	</div>

	<div id = "contents">		

		<h2 id = "word_title"><b>본사는 도봉산역 도보 5분 거리입니다</b></h2>				

		<p>자세한 사항은 관리자에게 개별적으로 문의하시기 바랍니다.</p>
		<hr><br>


		<div id = "map_wrap">		
			<div id="map" style="width:100%;height:350px;"></div>
		</div>

		

		
		
	</div>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a5b25014628de860e329f4da35b7370e&libraries=services"></script>
<script type="text/javascript">
	var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = {
        center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
        level: 2 // 지도의 확대 레벨
    };  

// 지도를 생성합니다    
var map = new kakao.maps.Map(mapContainer, mapOption); 

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new kakao.maps.services.Geocoder();

// 주소로 좌표를 검색합니다
geocoder.addressSearch('도봉동 30-1', function(result, status) {

    // 정상적으로 검색이 완료됐으면 
     if (status === kakao.maps.services.Status.OK) {

        var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

        // 결과값으로 받은 위치를 마커로 표시합니다
        var marker = new kakao.maps.Marker({
            map: map,
            position: coords
        });
        var arr_str  = "37.68668380372864, 127.04759376340415";
        // 인포윈도우로 장소에 대한 설명을 표시합니다
        var infowindow = new kakao.maps.InfoWindow({
            content: '<div style="width:150px;text-align:center;padding:6px 0;"><a href= "http://map.daum.net/link/to/본사,'+arr_str+'">본사 길찾기</a></div>'
        });
        infowindow.open(map, marker);

        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map.setCenter(coords);
    } 
});   
</script>
</section>

