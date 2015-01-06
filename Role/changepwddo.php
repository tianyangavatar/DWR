<?php
	 require_once("../Node/system.class.php");
	 if(!$system->CheckSessionLogin())
	 {
	 	header('Location:../index.php');
	 }
	 else
	 {
	 	$old = $_POST['oldpass'];
	 	$new = $_POST['newpass'];
	 	$staff_id = $_SESSION[$system->GetSessionVar()];
	 	if($system->IsOldpassRight($staff_id,$old))
	 	{
	 		if($system->ChangePassword($staff_id,$new))
	 			header('Location:center.php');
	 		else
	 			echo "密码修改失败";
	 	}
	 	else
	 		echo "原密码错误";		
	 }
?>