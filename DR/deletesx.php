<?php
    require_once("../Node/system.class.php");
    $work_matter_id = $_GET['work_matter_id'];
    if($system->DeleteWorkmatterByWMid($work_matter_id))
    {
    	header("Location:editri.php");
    }
    else
    {
    	echo "insert shixiang false;";
    }
?>