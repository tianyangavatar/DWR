<?php
	require_once("../Node/system.class.php");
	$dlname = $_POST['dlname'];
	$dlpass = $_POST['dlpass'];
	$department_id = $_POST['departmentid'];
	$rname = $_POST['realname'];
	$email = $_POST['email'];
	$authority = $_POST['authority'];
	if($system->AddStaff($dlname,$dlpass,$department_id,$rname,$email,$authority))
	{
		 $qrd = date("Y-m-d",time()-86400*2);
		 $staff_id = $system->Getstaff_idbydLoginname($dlname);
         if($system->ConfirmDayWork($staff_id,$qrd,0,"17:00:00","17:00:00",0))
			header("Location:index.php");
	}
	else
		echo "insert staff false";
?>