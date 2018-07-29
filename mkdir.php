<?php
	
	//接受上一个页面传过来的路径
	if (isset($_GET['path'])&&file_exists($_GET['path'])) {
		//显示创建目录信息
		include './addDir.html';
		// var_dump($_POST);
		if (isset($_POST['dir'])) {
			//创建目录
			$result=mkdir($_GET['path'].'/'.$_POST['dir'],0777,true);
			if ($result) {
				echo '<script>alert("创建成功");location="./in.php?path='.$_GET['path'].'/'.$_POST['dir'].'"</script>';
			}else{
				echo '<script>alert("创建失败");location="./in.php?path='.$_GET['path'].'"</script>';
			}
		}
	}else{
		// explode('/',$_GET['path'])
		echo '<script>alert("对不起，无权创建");location="./in.php?path=./pan"</script>';
	}