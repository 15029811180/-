<?php
		// var_dump($_GET['path']);
		if (!isset($_GET['path'])) {
			echo'<script>alert("路径信息有误");location="./in.php"</script>';
			die();
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style type="text/css">
	</style>
</head>
<body>
	<form action="do_upload.php" method="post" enctype="multipart/form-data">
	<input type="file" name="pic[]" multiple/>
	<!--通过隐藏域将上传图片后 保存的路径 提交到 处理上传的页面中-->
	<input type="hidden" name="path" value="<?=$_GET['path']?>">
	<input type="submit" name="" value="上传"/>
	</form>
</body>
</html>