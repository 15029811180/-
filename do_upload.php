<?php
	//实现文件上传
	
	// var_dump($_POST);
	// var_dump($_FILES);

	if (isset($_POST['path'])&&!empty($_POST['path'])) {
		//用户设置了路径可以实现文件上传
		include'./func_global.php';
		$result=upload('pic',$_POST['path']);
		if (is_array($result)) {
			echo '<script>alert("上传成功");location="./in.php?path'.$_POST['path'].'"</script>';
		}else{
			echo '<script>alert("上传失败");location="./in.php?path'.$_POST['path'].'"</script>';
		}
	}else{
		echo '<script>alert("条件不符合，不能上传");location="./in.php"</script>';
	}