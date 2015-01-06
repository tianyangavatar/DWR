<?php 
    require_once("../Node/system.class.php");
    // 如果一次确认的时候是点击的最后或者中间一个则确认所有，所有的
    //工作量为0，开始时间=结束时间=17：00 进度为0，日期为当前到最近确认的一天
    $staff_id = $_POST['staff_id'];
    $date = $_GET['date'];
    $st = $_POST['starttime_'.$date];
    $et = $_POST['endtime_'.$date];
    $work_day = ($system->IsWorkday($date))?1:0;
    //echo "et=$et";
    //echo "</br>st=$st";
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
    
    $work_load = $set-$sst-1.5;

    $gzshijian=0.0;
    $shixiangs = $system->GetWorkmattersbystaff_idonDate($staff_id,$date);
  
    foreach ($shixiangs as $key => $value) {
        $io = $value['work_matter_time'];
        $gzshijian = $gzshijian+floatval($io);
    }

    $prg = intval($gzshijian*100/$work_load);
    //echo "prg=$prg";
    $lastconfirmeddate = $system->GetnotConfirmedLast($staff_id);
    $deleteriend = $lastconfirmeddate; 
    $jiange = 0;
    if(strtotime($lastconfirmeddate)>strtotime($date))
    {
        $dangqiandate = $date;
        $xxx = date("w",$dangqiandate);
        $jange = $xxx;
    }
    if($jange==0)
        $jange=7;
    $lastconfirmeddate = date("Y-m-d",(strtotime($date)-$jange*86400));
    $deleteristart = $date;
    while(strtotime($deleteristart)<strtotime($deleteriend))
    {
        $deleteristart = date("Y-m-d",strtotime($deleteristart)+86400);
        $system->DeleteDayWork($staff_id,$deleteristart);
    }
    $system->DeleteDayWork($staff_id,$date);
    if(!$system->ConfirmDayWork($staff_id,$date,$gzshijian,$st,$et,$prg,$work_day))
        echo "确认当前工作量失败";
    else
        header("Location:../Menu/index1.php");
?>