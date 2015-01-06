<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../Css/style.css" />
    <script type="text/javascript" src="../Js/jquery.js"></script>
    <script type="text/javascript" src="../Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="../Js/bootstrap.js"></script>
    <script type="text/javascript" src="../Js/ckform.js"></script>
    <script type="text/javascript" src="../Js/common.js"></script>
</head>
<body>
<?php
	require_once("Node/system.class.php");
	echo "连接数据库...";
	$link = $system->LinkDB();
	echo "创建数据表...";
	if(!$system->Ensuretable($link))
		echo "创建错误!";
	echo "添加管理员";
	$mima = "";
	if($mima=$system->GenerateAdmin("tianyang@nscc-tj.gov.cn"))
	{
		echo "管理员名：admin<br>";
		echo "密码:$mima<br>";
		echo "请您现在记录密码以便于以后登录！";
	}
	echo "安装完毕";
	echo "<a href='index.php'>管理员登录</a>";
?>
</body>
</html>