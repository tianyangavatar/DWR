<?php
	require_once("../Node/system.class.php");
	$dlname = $_POST['dlname'];
	$dlpass = $_POST['dlpass'];
	$department_id = $_POST['departmentid'];
	$rname = $_POST['realname'];
	$email = $_POST['email'];
	$czid = $_GET['czid'];
	$authority = $_POST['authority'];
	if($system->UpdateStaff($dlname,$dlpass,$department_id,$rname,$email,$czid,$authority))
	{
		//echo "kk";
		 header("Location:index.php");
	}
	else
		echo "insert staff false";
?>