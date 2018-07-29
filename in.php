<?php
   //引入函数库文件
   include './func_global.php';
   //判断是否传入指定路径
   if (isset($_GET['path'])&&!empty($_GET['path'])) {
   	if ($_GET['path']!='.'&&$_GET['path']!='./') {
   	//指定的目录
   		$path=$_GET['path'];
   		}else{
   			$path='./pan';
  		}	
   	}else{
   	//根目录
   		$path='./pan';
   }

   //判断如果是根目录 只显示创建目录  如果是目录中的某一个子目录下 则显示 上传文件 和 创建目录
   if ($path=='./pan') {
   		//创建目录
   		$mkdir='<a href="./mkdir.php?path='.$path.'"><button>创建目录</button></a>';
   		//不允许上传文件
   		$form='';
   }else{
   		//允许上传文件 创建目录
   		$mkdir='<a href="./mkdir.php?path='.$path.'"><button>创建目录</button></a>';
   		//允许上传文件
   		$form='&nbsp;&nbsp;&nbsp;<a href="./upload.php?path='.$path.'"><button>上传文件</button></a>';
   }
   // var_dump($path);exit;
   //调用函数
   $result=mydir($path);
   // var_dump($result);
   //$result[12]=iconv('utf-8','gbk',$result[12]);
   //$a=is_dir($result[12]);
   //var_dump($a);
   //var_dump($result[12]);
   ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>网盘首页</title>
		<style type="text/css">
		a{
			text-decoration: none;
			color:#000;
		}
		td{
			border-bottom: 1px solid #ccc;
		}
		</style>
	</head>
	<body>
	<center>
	     <h1>网盘</h1>
	     <hr width="80%">
	     <table border="0" width="900">
	     <tr>
	          	<td colspan="3">
					<a href="./in.php">网盘首页></a>
				<?php
				//分割路径
					$arr=explode('/', $path);
					$value=array_pop($arr);
					// var_dump($arr);
					if(is_array($arr)){
						$newUrl=implode('/', $arr);
					}else{
						$newUrl='./pan';
						$value='';
					}

				?>
					<a href="?path=<?=$newUrl?>"><?=$path?>></a>
					<a href="?path=<?=$newUrl?>">返回上一级</a>
	          	</td>
	          	<td colspan="2">
	          		<?=$mkdir?>
	          		<?=$form?>
	          	</td>
	          </tr>
	          <tr>
	            <th></th>
	            <th>文件名</th>
	            <th>操作</th>
	            <th>文件大小</th>
	            <th>修改时间</th>
	          </tr>
	          
	          <!---将获取到的数据 遍历到表格中显示-->
	          <?php
	          foreach ($result as $k => $v) {
	          	//获取文件的名称
	          	$filename=strrchr($v,'/');
	          	$filename=ltrim($filename,'/');
	          	$v=iconv('utf-8','gbk',$v);
	          	//判断当前循环的是文件还是目录
	          		echo '<tr align="center">';
	          	if (is_dir($v)) {
	          		//是目录
	          			echo '<td align="right"><img src="1.jpg" width="50"/></td>';
	          			echo '<td><a href="?path='.$v.'">'.$filename.'</a></td>';
	          			echo '<td><a href="./rename.php?path='.$v.'">移动或重命名</a>|<a href="./del.php?path='.$v.'">删除</a>|<a href="">复制目录</a></td>';
	          			echo '<td>'.tosize(size($v)).'</td>';
	          			echo '<td>'.date('Y-m-s H:i:s').'</td>';
	          	} else {
	          		//判断是图片还是文件，获取文件的后缀
	          		$suffix=strrchr($v,'.');
	          		//定义图片后缀的数组
	          		$suffixs=array('.jpeg','.jpg','.png','.gif');
	          		if (in_array($suffix,$suffixs)) {
	          			//是图片
	          			$v=iconv('gbk','utf-8',$v);
	          			echo '<td align="right"><img src="'.$v.'" width="50"/></td>';
	          		}else{
	          			//是文件
	          			$v=iconv('gbk','utf-8',$v);
	          			echo '<td align="right"><img src="./1.jpg" width="50"/></td>';
	          		}
	          		//是文件
	          			
	          			echo '<td>'.$filename.'</td>';
	          			echo '<td><a href="./download.php?path='.$v.'">下载</a>|<a href="./rename.php?path='.$v.'">移动或重命名</a>|<a href="./del.php?path='.$v.'">删除</a>|<a href="">复制文件</a></td>';
	          			//注意涉及到中文需要转换编码
	          			$v=iconv('utf-8','gbk',$v);
	          			echo '<td>'.tosize(filesize($v)).'</td>';
	          			echo '<td>'.date('Y-m-d H:i:s',filemtime($v)).'</td>';
	          	}
	          	
	          		echo '</tr>';
	          }
	          ?>
	     </table>
	</center>
	</body>
</html>