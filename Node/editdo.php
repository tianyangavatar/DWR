<?php
	require_once("../Node/system.class.php");
	$bmmc = $_POST['grouptitle'];
	$sjbm = $_POST['sjbm'];
	$fzr = $_POST['fuzeren'];
	$beizhu = $_POST['beizhu'];
	$function_des = $_POST['function_des'];
	$czid = $_GET['czid'];
	if($system->UpdateDepartment($bmmc,$sjbm, $fzr,$function_des,$beizhu,$czid))
		header("Location:index.php");
	else
		echo "update department is false;"
?>