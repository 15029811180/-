<?php

    // var_dump($_GET);
    if (isset($_GET['path'])&&file_exists($_GET['path'])) {
    	//实现下载
    	include './func_global.php';
    	download($_GET['path']);
    }