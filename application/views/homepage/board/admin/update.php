<style type="text/css">
	#s1{
		width: 10%;
		min-height: 500px;
		height: auto;

		float: left;
		background-color: white;
	}
	#s2{
		width: 65%;
		height: auto;
		background-color: rgba(20,20,20,0.1);
		margin-top: 30px;
		margin-bottom: 30px;
		display: inline-block;
	}
	#user{
		width: 90%;
		height: 70px;
		border-radius: 40px;
		margin-bottom: 30px;
		background-color: white;
		box-shadow: 5px 5px 5px gray;
	}
	#user div{
		display: inline-block;
		float: left;
	}
	#user p {
		display: inline-block;
		float: left;
		margin-top: 20px;
		font-size: 17px;
	}
	#img_cut{
		width: 60px;
		height: 60px;
		border-radius: 100px;
		overflow: hidden;
		margin-right: 10px;
		margin-left: 10px;
		margin-top: 5px;
		
	}
	#writer_img{
		height: 60px;
		width: 100%;
		background-size: cover;
	}
	#div_title{
		width: 100%;
		height: auto;
		margin: auto;
	}
	#div_title label{
		float: left;
		margin-top: 3px;
		margin-right: 10px;
		margin-bottom: 10px;
	}
	#title{
		width: 87%;
		float: left;
	}
	#check{
		width: 100%;
		height: 30px;
		clear: both;
		margin-bottom: 15px;

	}
	
	#cat{
		width: 50%;
		height: 25px;
	}
	#cat1, #cat2{
		float: left;
		width: 50%;
	}
	#cat select{
		width: 50%;
		height: 35px;
		display: inline-block;
	}
	
	#contents{
		width: 90%;
		height: auto;
		margin: auto;
		padding-top: 30px;
		padding-bottom: 30px;

	}
	/*textarea 부트스트랩은 height 설정 안먹음.*/

	#btn_group{
		width: 210px;
		height: 50px;
		margin : auto;	
	}
	#btn_group a{
		width: 100px;
	}
	#file{
		background-color: white;
		width: 100%;
		margin-top: 10px;
		margin-bottom: 10px;
		border: 1px solid lightgray;
		height:37px;
	}
	h2{
		border-left: 5px solid gray;	
		width: 120px;
		text-align: center;
	}
	#textarea{
		width: 95%;
		height: auto;
		margin-left: 10px;

	}
</style>



</style>
<script src="/static/lib/ckeditor/ckeditor.js"></script>
<section>
<div id = "s1">e</div>
	<div id = "s2">
		<div id = "contents">				
			<h2>글수정</h2><hr>	

			<form action="/board_crud/update" method="post">
				<div id = "div_title">
					<label class="form-check-label" for="title"></label>
					<input name = "title" id = "title" value = "<?= $title?>" class="form-control form-control-sm" type="text" placeholder="제목을 입력하세요">
				</div>
				<div id = "check">
					<div class="form-check form-check-inline">
					  <input name = 'mask' class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
					  <label class="form-check-label" for="inlineCheckbox1">익명</label>
					</div>
					<div class="form-check form-check-inline">
					  <input name = 'perm' class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
					  <label class="form-check-label" for="inlineCheckbox2">전체공개</label>
					</div>
				</div>
				
				<div id = "cat">
					<div id = "cat1" class="form-group">
					    <label class ="l1" for="exampleFormControlSelect1">게시판 종류</label>
					    <select name = 'cat' class="form-control" id="exampleFormControlSelect1">
					      <option>자유게시판</option>
					      <option>건의사항</option>
					      <option>일상모습</option>				
					      <option>등업게시판</option>
					      <option>가입인사</option>
					    </select>
					</div>
					<div id= "cat2" class="form-group">
					    <label class ="l1" for="exampleFormControlSelect2">태그</label>
					    <select name = 'dept' class="form-control" id="exampleFormControlSelect2">
					      <option>1</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					    </select>
					</div>
				</div><hr>	
			
				<textarea name = "contents" class="form-control" id="exampleFormControlTextarea1" rows="20" >
					<?= $contents?>
				</textarea>
				<hr>

				<div id = "btn_group">
					<input class="btn btn-primary" type="submit" value="등록">
					<a href="#" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">뒤로</a>
				</div>
			</form>
			<script>
				CKEDITOR.replace('exampleFormControlTextarea1',{'height' : 500,  'filebrowserUploadUrl' : '<?=base_url()?>Board_crud/upload'}); //board_crud 의 ck
				//ck 그리다 , textarea에 , file 업로드 하는 컨트롤러 url로 연결 
			</script>
		</div>
	</div>
</section>