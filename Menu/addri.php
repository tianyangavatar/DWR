<?php 
    require_once("../Node/system.class.php");
    // 如果一次确认的时候是点击的最后或者中间一个则确认所有，所有的
    //工作量为0，开始时间=结束时间=17：00 进度为0，日期为当前到最近确认的一天
    $staff_id = $_POST['staff_id'];
    $date = $_GET['date'];
    $dates = strtotime($date);
    $st = $_POST['starttime_'.$date];
    $et = $_POST['endtime_'.$date];

    echo $st;
    echo $et;
    //$work_day = $_POST['work_day'];
    $startarr = array();
    $endarr = array();
    //echo "et=$et";
    //echo "</br>st=$st";
    $startarr = analysestime($st,$dates);
    $endarr = analysestime($et,$dates);

    print_r($startarr);
    print_r($endarr);

    $sst = getnumtime($st);
    $set = getnumtime($et);

    function analysestime($time,$timedate)
    {
        $arr = explode("-", $time);
        $res = array();
        $tt = $timedate-86400*(count($arr)-1);
        foreach ($arr as $key => $value) {
            $t = date("Y-m-d",$tt);
            $res[$t] = $value;
            $tt = $tt+86400;
        }
        return $res;
    }

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
    $work_load = $set-$sst-1.5;
    $lastconfirmeddate = $system->GetnotConfirmedLast($staff_id);
    $time = strtotime($lastconfirmeddate); 
    $gzshijian=0.0;
    $shixiangs = $system->GetWorkmattersbystaff_idonDate($staff_id,$date);
  
    foreach ($shixiangs as $key => $value) {
        $io = $value['work_matter_time'];
        $gzshijian = $gzshijian+floatval($io);
    }

    $prg = intval($gzshijian*100/$work_load);

    $flag = 1;

    while ($time<=strtotime($date)) {
    	$qrd = date("Y-m-d",intval($time));
        $tempst = getnumtime($startarr[$qrd]);
        $tempet = getnumtime($endarr[$qrd]);
        $tempwork_load = $tempet-$tempst-1.5;
        //echo "tempwork_load =$tempwork_load";
        $iswork_day = ($system->IsWorkday($qrd))?1:0;
         
        $tempgzshijian=0.0;
        $tempshixiangs = $system->GetWorkmattersbystaff_idonDate($staff_id,$qrd);
        foreach ($tempshixiangs as $key => $value) {
            $io = $value['work_matter_time'];
            $tempgzshijian = $tempgzshijian+floatval($io);
        }
        $tempprg = ($tempwork_load==0)?0:intval($tempgzshijian*100/$tempwork_load);
     //   echo "staff_id=$staff_id,qrd=$qrd,tempgzshijian=$tempgzshijian,
     //   startarr[$qrd]=".$startarr[$qrd].",endarr[$qrd]=".$endarr[$qrd].",$tempprg,$iswork_day)";   
    	if(!$system->ConfirmDayWork($staff_id,$qrd,$tempgzshijian,$startarr[$qrd],$endarr[$qrd],$tempprg,$iswork_day))
    	{
    		echo "确认$qrd 工作失败";
            $flag = 0;
    		break;
    	}
    	$time = $time + 86400;
    }
    if($flag==1)
       header("Location:index.php");
    else
       echo "确认工作失败，请点击<a href='index.php'>返回</a>";
   // if(!$system->ConfirmDayWork($staff_id,$date,$gzshijian,$st,$et,$prg,$work_day))
  //      echo "确认当前工作量失败";
  //  else
   //     header("Location:index1.php");
?>