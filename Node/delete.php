<?php
	require_once("../Node/system.class.php");
	$czid = $_GET['czid'];
	if($system->DeleteDepartment($czid))
		header("Location:index.php");
	else
		echo "update department is false;"
?>