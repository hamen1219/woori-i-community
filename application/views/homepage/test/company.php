

<style type="text/css">
	section{
		width: 80%;
		min-height: 500px;
		margin-left: 10%;

	}
	#company_title{
		margin-top: 100px;
		width: 100%;
		height: 180px;
		border: 1px solid lightgray;
		box-shadow: 0 8px 38px rgba(133, 133, 133, 0.3), 0 5px 12px rgba(133, 133, 133, 0.22);
	}	
	#company_img_cut{
		background-color: white;
		position: relative;
		bottom: 50px;
		display: inline-block;
		width: 100px;
		height: 100px;
		left: 30px;
		border-radius: 100px;
		overflow: hidden;
		box-shadow: 0 8px 38px rgba(133, 133, 133, 0.3), 0 5px 12px rgba(133, 133, 133, 0.22);
		text-align: center;
	}
	#company_img_cut img{
		height: 100%;
		width: auto;
		display: inline-block;
	}
	#word{
		position: relative;
		bottom: 100px;
		left: 150px;
	}
	#word h3{
		margin-top: 10px;
		margin-bottom: 10px;
		font-size: 35;
		font-weight: 600;
	}
	#word p #word a{
		margin-left: 20px;
	}
	#company_map{
		width: 100%;
		height: 500px;
		overflow: hidden;
		margin-top: 30px;
		padding-left: 5%;
		padding-right: 5%;
	}
	#company_map h3{
		margin: 10px;
	}

	/* api style */
	#container {overflow:hidden;height:400px; position:relative; }
	#btnRoadview,  #btnMap {position:absolute;top:5px;left:5px;padding:7px 12px;font-size:14px;border: 1px solid #dbdbdb;background-color: #fff;border-radius: 2px;box-shadow: 0 1px 1px rgba(0,0,0,.04);z-index:1;cursor:pointer;}
	#btnRoadview:hover,  #btnMap:hover{background-color: #fcfcfc;border: 1px solid #c1c1c1;}
	#container.view_map #mapWrapper {z-index:3;}
	#container.view_map #btnMap {display: none;}
	#container.view_roadview #mapWrapper {z-index: 0;}
	#container.view_roadview #btnRoadview {display: none;}

	#mapWrapper, #rvWrapper{
		width: 100%;
		height: 450px !important;
	}
</style>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=f8f356e5f51fd9166b0fc4b453f121b8&libraries=services"></script>

<section>
	<div id = "company_title">
		<div id = "company_img_cut">
			<img src="/" onerror = "this.src = 'https://mblogthumb-phinf.pstatic.net/20150403_86/e2voo_14280514283502gas9_JPEG/kakako-00.jpg?type=w800'">
		</div>
		<div id = "word">
			<h3>EG Company</h3>
			<p>은경컴퍼니</p>

			<p>은경소프트는 21세기를 선도하는 게임 종합 커뮤니티 사이트입니다</p>
			<p>2020년 설립되었으며 직원수 3명의 신생 기업입니다.</p>

			<a href="">회사 소개서 다운로드</a>			
		</div>		
	</div>

	<div id = "company_map">
		<h3>오시는 길</h3>

		<div id="container" class="view_map">
		    <div id="mapWrapper" style="width:100%;height:300px;position:relative;">
		        <div id="map" style="width:100%;height:100%"></div> <!-- 지도를 표시할 div 입니다 -->
		        <input type="button" id="btnRoadview" onclick="toggleMap(false)" title="로드뷰 보기" value="로드뷰">
		    </div>
		    <div id="rvWrapper" style="width:100%;height:300px;position:absolute;top:0;left:0;">
		        <div id="roadview" style="height:100%"></div> <!-- 로드뷰를 표시할 div 입니다 -->
		        <input type="button" id="btnMap" onclick="toggleMap(true)" title="지도 보기" value="지도">
		    </div>
		</div>


	</div>	
</section>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=발급받은 APP KEY를 사용하세요"></script>
<script>
	var container = document.getElementById('container'), // 지도와 로드뷰를 감싸고 있는 div 입니다
	    mapWrapper = document.getElementById('mapWrapper'), // 지도를 감싸고 있는 div 입니다
	    btnRoadview = document.getElementById('btnRoadview'), // 지도 위의 로드뷰 버튼, 클릭하면 지도는 감춰지고 로드뷰가 보입니다 
	    btnMap = document.getElementById('btnMap'), // 로드뷰 위의 지도 버튼, 클릭하면 로드뷰는 감춰지고 지도가 보입니다 
	    rvContainer = document.getElementById('roadview'), // 로드뷰를 표시할 div 입니다
	    mapContainer = document.getElementById('map'); // 지도를 표시할 div 입니다

	// 지도와 로드뷰 위에 마커로 표시할 특정 장소의 좌표입니다 
	var placePosition = new kakao.maps.LatLng(37.64890138553994, 127.06428515498332);

	// 지도 옵션입니다 
	var mapOption = {
	    center: placePosition, // 지도의 중심좌표 
	    level: 3 // 지도의 확대 레벨
	};

	// 지도를 표시할 div와 지도 옵션으로 지도를 생성합니다
	var map = new kakao.maps.Map(mapContainer, mapOption);

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
</script>