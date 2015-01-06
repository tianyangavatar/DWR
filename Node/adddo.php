<?php
	require_once("system.class.php");
	$bmmc = $_POST['grouptitle'];
	$sjbm = $_POST['sjbm'];
	$fzr = $_POST['fuzeren'];
	$beizhu = $_POST['beizhu'];
	$function_des = $_POST['function_des'];
	//$bmmc,$higher_department_id,$fzr,$function_des
	if($system->AddDepartment($bmmc,$sjbm, $fzr,$function_des,$beizhu,$authority))
		header("Location:index.php");
	else
		echo "insert department is false;"
?>