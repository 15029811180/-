<?php
	
	var_dump($_GET);
	//判断是否设置path
	if (isset($_GET['path'])&&!empty($_GET['path'])) {
		//判断path是文件还是目录
		if (is_file($_GET['path'])) {
			unlink($_GET['path']);
			$arr=explode('/',$_GET['path']);
			array_pop($arr);
			$_GET['path']=implode('/',$arr);
			//跳转到删除文件的上一级目录中
			echo '<script>alert("删除文件成功");location="./in.php?path='.$_GET['path'].'"</script>';
		}else{
			//是目录 调用删除目录的函数
			include './func_global.php';
			deldir($_GET['path']);
			$arr=explode('/',$_GET['path']);
			array_pop($arr);
			$_GET['path']=implode('/',$arr);
			echo '<script>alert("删除目录成功");location="./in.php?path='.$_GET['path'].'"</script>';
		}
	}else{
		echo '<script>alert("条件不符合，不能删除")</script>';
	}