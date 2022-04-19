<!DOCTYPE html>
<html>
<head>
	<title>	</title>
</head>
<body>
	<?php $this->session->set_userdata('aa' , '123aa'); ?>
	<script src="/static/lib/ckeditor/ckeditor.js"></script>
	<!-- ck에디터는 파일업로드에 필요한 multipart 필요 없음-->
	<form action = "/board_crud/upload" method="POST">
		<textarea name = "area" style="width: 100%; height: 300px;">	

		</textarea>
		<input type="submit" value="보내기">	
	</form>
	<script>
		CKEDITOR.replace('area', {
			'filebrowserUploadUrl' : '/board_crud/upload'
		});


	</script>

</body>
</html>