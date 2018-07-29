<?php
   // $result=mydir('./16fileDownload');
   // var_dump($result);
      //1.遍历目录(没有实现递归 只是遍历当前的目录)
function mydir($dirname){
	//定义要返回的数组
	$files=array();
	//1.打开目录
	$dir=opendir($dirname);
	//2.读取文件
	while ($filename=readdir($dir)) {
		//过滤点点滴滴
		if($filename!='.'&&$filename!='..'){
			//拼接完整的路径
			$path=$dirname.'/'.$filename;
			//实现转码
			$path=iconv('gbk','utf-8',$path);
			//将读取到的内容 放到数组中保存
			$files[]=$path;

		}
	}
	//3.关闭目录
	closedir($dir);
	//4.返回读取到的目录或者文件组成的数据
	return $files;
}
//2.创建目录函数


// download('./16fileDownload/01.action.php');
//3.下载文件函数
 function download($path){
 	 //声明文件的类型
     // header('Content-type:application/pdf');
     // 获取要下载文件的名称
     $newName= strrchr($path,'/');//exit;
     //删除最左边的斜线
     $newName=ltrim($newName,'/');
     //转码
     $newName=iconv('utf-8','gbk',$newName);
     //对下载文件进行描述
     header('Content-Disposition:attachment;filename='.$newName);
     //读取需要下载的文件
     $result=readfile($path);
     // return $result;
 }
 // myrename('./A','./A');
//4.移动目录或者文件  //5.重命名目录或者文件
function myrename($dirsrc,$dirto){
	if (is_file($dirto)) {
		return false;
	}
	if (!file_exists($dirto)) {
		mkdir($dirto);
	}
	//打开原路径
	$dir=opendir($dirsrc);
	//读取目录
	while ($filename=readdir($dir)) {
		if ($filename!='.'&&$filename!='..') {
			//拼接路径
			$path1=$dirsrc.'/'.$filename;
			$path2=$dirto.'/'.$filename;
			//判断
			if (is_dir($path1)) {
				myrename($path1,$path2);
			} else {
				rename($path1, $path2);
			}
			
		}
	}
	//关闭目录
	closedir($dir);

	//删除目录
	$result=rmdir($dirsrc);
	return $result;

}
// mycopy('A','B');
//6.复制目录或者文件
function mycopy($dirsrc,$dirto){
	if (is_file($dirto)) {
		return false;
	}
	if (!file_exists($dirto)) {
		mkdir($dirto);
	}
	$dir=opendir($dirsrc);
    while ($filename=readdir($dir)) {
	if ($filename!='.'&&$filename!='..') {
		//拼接路径
		$path1=$dirsrc.'/'.$filename;
			$path2=$dirto.'/'.$filename;
			//判断
			if (is_dir($path1)) {
				mycopy($path1,$path2);
			} else {
				copy($path1, $path2);
			}
		}
	}
	//关闭目录
	closedir($dir);
}
// deldir('./B');
//8.删除文件或者目录
function deldir($dirname){
	//打开目录
	$dir=opendir($dirname);
	//2.读取
	while ($filename=readdir($dir)) {
	if ($filename!='.'&&$filename!='..'){
		$path=$dirname.'/'.$filename;
		if (is_dir($path)) {
			deldir($path);
		} else {
			unlink($path);
		}
		
	  }
   }
	//关闭目录
	closedir($dir);
	//删除目录
	rmdir($dirname);
}
// $size=size('./16fileDownload');
// var_dump(tosize($size));
//9.统计目录大小
function size($dirname){
	//定义一个返回文件大小的变量
	$dirsize=0;
	$dir=opendir($dirname);
	while ($filename=readdir($dir)) {
	if ($filename!='.'&&$filename!='..'){
		$path=$dirname.'/'.$filename;
		if (is_dir($path)) {
			$dirsize+=size($path);
		} else {
			$dirsize+=filesize($path);
		}
		
	  }
   }
	//关闭目录
	closedir($dir);
   return $dirsize;
}
//10.目录大小转换函数
function tosize($size){
	if ($size>pow(1024,3)) {
		$dw='GB';
		$newSize=round($size/pow(1024,3),2);
	}elseif($size>pow(1024,2)){
		$dw='MB';
		$newSize=round($size/pow(1024,2),2);
	}elseif($size>1024){
		$dw='KB';
		$newSize=round($size/1024,2);
	}else{
		$newSize=$size;
		$dw='byte';
	}
	return $newSize.$dw;
}
//7.文件上传函数

// $result=upload('pic');
// var_dump($result);
function upload($pic,$path='./upload',$size=100000000,array $type=array('image/jpeg','image/gif','image/png')){
	// var_dump($_FILES[$pic]);
	$file=$_FILES[$pic];
	// 1.判断所有上传文件的错误号
	foreach ($file['error'] as $k => $v) {
		if ($v>0) {
				continue;
			}
		}
		//判断上传文件的类型
		foreach ($file['type'] as $k => $v) {
			if (!in_array($v,$type)) {
				continue;
			}
		}
	
	//3.判断上传文件的大小
	foreach ($file['size'] as $k => $v) {
		 if ($v>$size) {
				continue;
			}
			// var_dump($v);
		}
		//4.判断上传文件的路径
	if (!file_exists($path)) {
		mkdir($path);
	}
	//过滤路径中最后的斜线
	$path=rtrim($path,'/');

	//5.制作新的文件名称
		//获取图片的后缀
	foreach ($file['name'] as $k => $v) {
		$suffix=strrchr($v,'.');
		// echo $suffix.'<br/>';
		do {
			$newName=md5(uniqid().mt_rand(1,1000).time()).$suffix;
			$newNames[$k]=$newName;
		} while (file_exists($path.'/'.$newName));
	}
	// var_dump($newNames);
	
	//6.移动文件
	foreach ($file['tmp_name'] as $k => $v) {
		if (move_uploaded_file($v,$path.'/'.$newNames[$k])) {
			//返回数组
			$info['name'][$k]=$newNames[$k];
			$info['path'][$k]=$path.'/'.$newNames[$k];
		}else{
			continue;
		}
	}
	return $info;
}