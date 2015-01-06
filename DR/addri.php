<?php 
    require_once("../Node/system.class.php");
    // 如果一次确认的时候是点击的最后或者中间一个则确认所有，所有的
    //工作量为0，开始时间=结束时间=17：00 进度为0，日期为当前到最近确认的一天
    $staff_id = $_POST['staff_id'];
    $date = $_GET['date'];
    $st = $_POST['starttime_'.$date];
    $et = $_POST['endtime_'.$date];
    $work_day = $_POST['work_day'];
    echo "et=$et";
    echo "</br>st=$st";
    $sst = getnumtime($st);
    $set = getnumtime($et);
    function getnumtime($time)
    {
        $mh = ":";
        $hour = substr($time, 0, stripos($time, $mh));
        //return $hour;
        $mi = substr($time, stripos($time, $mh)+1);
        $hour = intval($hour);
        $mi = intval($mi);
        $fmi = $mi/60;
        return $hour+$fmi;
        # code...
    }
    $work_load = $set-$sst;
    $prg = intval($work_load*100/8.5);
    //echo "prg=$prg";
    $lastconfirmeddate = $system->GetnotConfirmedLast($staff_id);
    //echo "lastconfirmeddate=$lastconfirmeddate";
    //echo "work_load=$work_load";
    $time = strtotime($lastconfirmeddate);
    
    $gzshijian=0.0;
    //echo "staff_id=$staff_id";
    //echo "date=$date";
    $shixiangs = $system->$date,$staff_id);
    //print_r($shixiangs);
    foreach ($shixiangs as $key => $value) {
        $io = $value['work_matter_time'];
        $gzshijian = $gzshijian+floatval($io);
    }

   // echo "gzshijian=$gzshijian";

    while ($time<strtotime($date)) {
    	$qrd = date("Y-m-d",intval($time));
    	if(!$system->ConfirmDayWork($staff_id,$qrd,0,'17:00:00','17:00:00',0,1))
    	{
    		echo "确认$qrd 工作失败";
    		break;
    	}
    	$time = $time + 86400;
    }
    if(!$system->ConfirmDayWork($staff_id,$date,$work_load,$st,$et,$prg,$work_day))
        echo "确认当前工作量失败";
    else
        header("Location:../Menu/index1.php");
?>