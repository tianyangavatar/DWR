<?php
	require_once('../Node/system.class.php');
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $user = $system->GetStaffbystaff_id($staff_id);
    /*
        <td><select name="higherproject" id="higherproject">
        <td><select name="department_id" id="department_id">
        <td><select name="leader_id" id="leader_id">
        <td><input type="text" name="starttime" id="datepicker"></td>
        <td><input type="text" name="endtime" id="datepicker1"></td>
        <td><textarea name="project_des"></textarea></td>
        <td><textarea name="project_remark"></textarea></td>
    */
    $higherproject = $_POST['higherproject'];
    $project_tree_rank = -1;
    if($higherproject=='-1')
    	$project_tree_rank = 0;
    else
    {
    	$hproject = $system->GetProjectByid($higherproject);
    	print_r($hproject);
    	$project_tree_rank = $hproject[0]['project_tree_rank']+1;
    }
    $department_id = $_POST['department_id'];
    $project_name = $_POST['project_name'];
    $project_des = $_POST['project_des'];
    $leader_id = $_POST['leader_id'];
    $starttime = $_POST['starttime'];
    $endtime = $_POST['endtime'];
    $project_remark = $_POST['project_remark'];
    $sttime = strtotime($starttime);
    $edtime = strtotime($endtime);
    //假定每天8小时工作日
    $need_time = 8*($edtime-$sttime)/86400;
    $progress = 0;
    $flag = $system->AddNewProject($project_tree_rank,$department_id,$project_name,
    	$project_des,$leader_id,$need_time,$progress,$project_remark,$starttime,$endtime);
    $lproject = $system->GetProjectByname($project_name);
    print_r($lproject);
    $lproject_id = $lproject['project_id'];
    if($project_tree_rank>0)
    {
    	if(!$system->AddProjectRelation($lproject_id,$higherproject))
    		$flag = false;
    }
    if($flag)
    	header("Location:index.php");
    else
    	echo "add new project failed";
?>