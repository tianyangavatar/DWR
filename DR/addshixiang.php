<?php
    require_once("../Node/system.class.php");
    $d = $_GET['date'];
    $staff_id = $_POST['staff_id'];
    $gzxm = $_POST['gzxm_'.$d];
    $xmnr = $_POST['gznr_'.$d];
    $szsj = $_POST['szsj_'.$d];
    //echo $szsj;
    $xmbz = $_POST['xmbz_'.$d];
    $xmid = $_POST['xmid_'.$d];
    $md_date = date("Y-m-d");
    if($system->AddworkMatters($staff_id,$gzxm,$xmnr,$szsj,$xmbz,$xmid,$d))
    {
    	header("Location:editri.php?md_date=$d&&staff_id=$staff_id");
    }
    else
    {
    	echo "insert shixiang false;";
    }
?>