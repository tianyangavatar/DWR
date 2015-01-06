<?php 
    require_once("../Node/system.class.php");
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $dt = $_GET['md_date'];
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../Css/style.css" />
    <script type="text/javascript" src="../Js/jquery.js"></script>
    <script type="text/javascript" src="../Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="../Js/bootstrap.js"></script>
    <script type="text/javascript" src="../Js/ckform.js"></script>
    <script type="text/javascript" src="../Js/common.js"></script>

    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>

<form class="form-inline definewidth m20" action="index.php" method="get">
    选择周：
    <input type="text" name="menuname" id="menuname"class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">新增周报</button>
</form>
<table class="table table-bordered table-hover definewidth m10">
    <?php
    $now = $dt;
             echo "<thead>
                <tr>
                <th>日期</th>
                <th>工作时间</th>  
                <th style='align:center'>本日工作项录入</th>
                <th style='align:center'><input id='$now' type='button' value='确认'
                onclick = 'subform(this);' /></th>
                </tr>
            </thead>";
            $work_daym = 1; 
            if($system->IsWorkday($now))
                echo "<tr><td style='vertical-align:middle'>$now</br>工作日</td>";
            else
                echo "<tr><td style='vertical-align:middle'>$now</br>非工作日</td>";
                
            echo "<td style='vertical-align:middle'>
            <form id='formid_$now' method='post' action='addri.php?date=$now'>
            <table style='width:10px'>
            <tr><td >开始时间<input type='text' id='starttime_$now' name='starttime_$now' style='width:100px' value='08:30'></td></tr>
            <tr><td style='width:10px'>结束时间<input type='text' id='endtime_$now' name='endtime_$now' style='width:100px' value='17:00'></td></tr></table>
            <input type='hidden' name='staff_id' value='$staffid'>
            <input type='hidden' name='work_day' value='$work_daym'>
            </form>
            </td>";
           
           // echo "<td>$work_daym</td>";
            echo "<td colspan='4'><table><tr>";
            echo "<th>工作项目</th>
                    <th>工作内容</th>
                    <th>项目所占时间</th>
                    <th>项目备注</th>
                    <th>操作</th></tr>";
            $shixiangtians = $system->GetWorkmattersbystaff_idonDate($staffid,$now);
            //print_r($shixiangtians);
            foreach ($shixiangtians as $key => $sx) {
                $work_matter_id = $sx['work_matter_id'];
                echo "<tr>";
                echo "<td>".$sx['work_matter_name']."</td><td>".$sx['work_matter_content']
                ."</td><td>".$sx['work_matter_time']."</td><td>".$sx['work_matter_remark']."</td>";
                echo "<td><a href='deletesx.php?work_matter_id=$work_matter_id'><button>删除</button></a></td></tr>";
            
            }
            if($now==$dt)
                $xh=false;
            $time = $time+86400;
            //echo $now;
            echo "<form id='formwork_matter_id_$now' method='post' action='addshixiang.php?date=$now'>";
            echo "<tr>
    <td style='vertical-align:middle'>
    <input type='text' name='gzxm_$now' id='gzxm_$now' style='width:160px'/>
    </td>
    <td style='vertical-align:middle'>
    <textarea rows=2 cols=80 name='gznr_$now' id='gznr_$now' style='width:500px'/></textarea>
    </td>
    <td style='vertical-align:middle'>
    <input type='text' name='szsj_$now' id='szsj_$now' style='width:100px'/> 小时
    </td>
    <td style='vertical-align:middle'>
    <input type='text' name='xmbz_$now' id='xmbz_$now' style='width:100px'/>
    </td>
    <td style='vertical-align:middle'>
        <input id='$now' type='button' 
                onclick = 'subrbform(this)' value='添加' />
    </td>
    </tr>";
     echo "<input type='hidden' name='staff_id' value='".$staffid."' />";
        $xmid = -1;
            echo "<input type='hidden' name='xmid' value='".$xmid."' />";
    echo "</form>";
    echo "</table></td></tr>";
   
?>
    <!--
	     <tr>
            <td colspan="5">系统管理</td>
            <td><a href="edit.html">编辑</a></td>
        </tr>
        <tr>
                <td>机构管理</td>
                <td>Admin</td>
                <td>Merchant</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>权限管理</td>
                <td>Admin</td>
                <td>Node</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>角色管理</td>
                <td>Admin</td>
                <td>Role</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>用户管理</td>
                <td>Admin</td>
                <td>User</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>菜单管理</td>
                <td>Admin</td>
                <td>Menu</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
            <td colspan="5">明信片管理</td>
            <td><a href="edit.html">编辑</a></td>
        </tr>
        <tr>
                <td>批次管理</td>
                <td>Admin</td>
                <td>LabelSet</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>明信片查询</td>
                <td>Admin</td>
                <td>Label</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>明信片生成</td>
                <td>Admin</td>
                <td>Label</td>
                <td>apply</td>
                <td>1</td>
                <td><a href="edit.html">编辑</a></td>
            </tr>
        -->
            </table>

</body>
</html>
<script>
    $(function () {
        

		$('#addnew').click(function(){

				window.location.href="add.html";
		 });


    });
	
</script>

<script>
   function subform(obj){
   // alert(obj.id);
   var result = document.getElementById("starttime_"+obj.id).value;
   var password = document.getElementById("endtime_"+obj.id).value;

   //alert(result);
   if(result == ""  ){
     alert("填写"+obj.id+"开始时间");
     return false;
   }
   if(password == ""  ){
    alert("填写结束时间");
     return false;
   }
  document.getElementById("formid_"+obj.id).submit()
}
 function subrbform(obj){
    //alert(obj.id);
   var result = document.getElementById("gzxm_"+obj.id).value;
   var password = document.getElementById("gznr_"+obj.id).value;
   var password2 = document.getElementById("szsj_"+obj.id).value;
       //alert(result);
   if(result == ""  ){
     alert("填写"+obj.id+"工作项目");
     return false;
   }
   if(password == ""  ){
    alert("填写"+obj.id+"工作内容");
     return false;
   }
   if(password2 == ""  ){
    alert("填写"+obj.id+"所占时间");
     return false;
   }
  document.getElementById("formwork_matter_id_"+obj.id).submit()
}   
</script>