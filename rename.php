<?php
	var_dump($_GET);

	if (isset($_GET['path'])&&file_exists($_GET['path'])) {
		//显示移动位置的表单
		include 'rename.html';
		//判断用户是否提交新路径
		if (isset($_POST['srcto'])&&!empty($_POST['srcto'])) {
			// var_dump($_POST);
			// var_dump($_GET);
			// 移动的是文件还是目录
			if (is_file($_GET['path'])) {
				$result=rename($_GET['path'],$_POST['srcto']);
			}else{
				include './func_global.php';
				$result=myrename($_GET['path'],$_POST['srcto']);
			}
			//删除路径最后的文件名 或者 最后的目录部分
			$arr=explode('/',$_POST['srcto']);
			array_pop($arr);
			$_POST['srcto']=implode('/',$arr);

			//解决get的问题
			$arr=explode('/',$_GET['path']);
			array_pop($getArr);
			$_GET['path']=implode('/',$getArr);

			if ($result) {
				echo '<script>alert("移动成功");location="./in.php?path='.$_POST['srcto'].'"</script>';
			}else{
				echo '<script>alert("移动失败");location="./in.php?path='.$_GET['srcto'].'"</script>';
			}
		}
	}else{
			echo '<script>alert("移动失败");location="./in.php?path='.$_GET['srcto'].'"</script>';	
	}