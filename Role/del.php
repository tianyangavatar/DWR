<?php
	require_once("../Node/system.class.php");
	$czid = $_GET['czid'];
	if($system->DeleteStaff($czid))
		header("Location:index.php");
	else
		echo "update department is false;"
?>