<?php
    require_once("../Node/system.class.php");
    $d = (isset($_POST['date']))?$_POST['date']:"";
    $staff_id = $_POST['staff_id'];
    $work_matter_name = $_POST['work_matter_name_'.$d];
    $work_matter_content = $_POST['work_matter_content_'.$d];
    $work_matter_time = $_POST['work_matter_time_'.$d];
    //echo $work_matter_time;
    $work_matter_remark = $_POST['work_matter_remark_'.$d];
    $project_id = $_POST['project_id_'.$d];
    $work_date = ($d!="")?$d:date("Y-m-d");
    //AddworkMatters($staff_id,$work_matter_name,$work_matter_content,$work_matter_time
    //        ,$work_matter_remark,$project_id,$work_date)
    if($system->AddworkMatters($staff_id,$work_matter_name,$work_matter_content,$work_matter_time,$work_matter_remark,$project_id,$work_date))
    {
    	header("Location:index.php");
    }
    else
    {
    	echo "insert shixiang false;";
    }
?>