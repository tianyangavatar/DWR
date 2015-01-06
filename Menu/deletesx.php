<?php
    require_once("../Node/system.class.php");
    $work_matter_id = $_GET['work_matter_id'];
    if($system->DeleteWorkmatterByWMid($work_matter_id))
    {
    	header("Location:index1.php");
    }
    else
    {
    	echo "insert shixiang false;";
    }
?>