<script src="/static/lib/ckeditor/ckeditor.js"></script>

<?php 
	$user = $this->session->userdata('user');
?>

<style type="text/css">
	body *{
		
	}
	section{
		padding: 10px;
		width: 70%;
		height: auto;
		margin-left: 15%;
		margin-top: 100px;
		background-color: lightgray;
	}	
	section h2{
		border-left: 5px solid white;
		margin-left: 10px;
		margin-bottom: 10px;
		margin-top: 10px;
		padding-left: 5px;
	}
	section label p{
		display: inline-block;
		margin-right: 5px;
	}
	form{
		padding: 10px;
	}
	#form_title{
		width: 100%;
		height: 80px;
		background-color: rgba(20,20,20,0.3);
	}
	section table{
		width: 100%;
		margin: 10px;
		height: 100px;
	}
	section td{
		border-bottom: 1px solid gray;
	}

	section td:nth-child(1){
		width: 15%;
	}
	section td:nth-child(2){
		width: 85%;
	}

	#title{
		width: 80%;
	}
	#btn_group{
		text-align: center;
		margin-top: 20px;
	}
	#btn_group button{
		width: 15%;
		margin : 5px;
	}




</style>

<section>
	<div id = "form_title">
		<h2>글쓰기</h2>
	</div>
	

	<form action = "/board_crud/write" method="post">
		<table>
			<tr>
				<td><p>제목</p></td>
				<td>
					<input type="text" id = "title" name="title">
				</td>
			</tr>

			<tr>
				<td><p>옵션</p></td>
				<td>
					<label><p>익명</p><input type="checkbox" name="mask" value="mask"></label> 	
					<label><p>전체공개</p><input type="checkbox" name="perm" value="perm"></label>
				</td>
			</tr>

			<tr>
				<td><p>카테고리</p></td>
				<td>
					<select name = "category" id = "category">
						<option>자유게시판</option>
					    <option>건의사항</option>
					    <option>일상모습</option>				
					    <option>등업게시판</option>
					    <option>가입인사</option>
					</select>
				</td>
			</tr>			
		</table>

		<div id = "contents">
			<textarea name = "contents" class="form-control" id="exampleFormControlTextarea1" rows="20" ></textarea>
		</div>
	
		<div id = "btn_group">
			<button class="btn btn-primary" type="submit">등록</a>
			<button class="btn btn-secondary" type="submit">등록</a>
		</div>

	</form>

		<script>
			CKEDITOR.replace('exampleFormControlTextarea1',{'height' : 500,  'filebrowserUploadUrl' : '<?=base_url()?>Board_crud/upload'}); //board_crud 의 ck
			//ck 그리다 , textarea에 , file 업로드 하는 컨트롤러 url로 연결 
		</script>
		
	</div>
</section>