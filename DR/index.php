<?php 
    require_once("../Node/system.class.php");
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $staffs = array();
    $dt= date("Y-m-d",time());
    if(isset($_POST['setdate']))
    {
      $dt = $_POST['setdate'];
      //echo "dddddd";
    }
    $xqj = date('w',strtotime($dt));
    $xqj = ($xqj==0)?7:$xqj;

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

    <link rel="stylesheet" href="../Js/jquery-ui-1.11.2.custom/jquery-ui.css">
  <script src="../Js/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
  <script src="../Js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat:"yy-mm-dd"
    });
  });
  </script>

</head>
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

<form class="form-inline definewidth m20" action="index.php" method="post">
    选择周：
    <input type="text" name="setdate" id="datepicker" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
</form>
<table class="table table-bordered table-hover definewidth m10">
   
    <?php
    //$system->IsDepartmentLeader($staff_id)
      if($system->IsDepartmentLeader($staff_id))
      {
          $user = $system->GetStaffbystaff_id($staff_id);
          $department_id = $user['department_id'];
        
          while ( $xqj>0) {
            $staffs = $system->GetWorkloadofDepartment($department_id,$dt);
            //print_r($staffs);   
            ?>
            <thead>
                <tr>
                <th colspan=5>日期<?php 
                if($system->IsWorkday($dt))
                  echo $dt."【工作日】";
                else
                  echo $dt."【非工作日】";?></th>
                <th colspan=1 style='align:right'>确认人数:<?php echo count($staffs);?></th> 
                </tr>
            </thead>
        <?php
          $xqj= $xqj-1;
          $time = strtotime($dt)-86400;
          $dt = date("Y-m-d",intval($time));
          echo "<thead>
                <tr>
                <th>名字</th>
                <th>工作时间</th>  
                <th>项目名称</th>
                <th>项目内容</th>
                <th>所用时间</th>
                <th>上传文件</th>
                </tr>
          </thead>";
          foreach ($staffs as $key => $staff) {
           //print_r($staff);
           //echo "ddddddddddddddddddddddddd</br>"
           echo "<tr style='border-bottom:2px'>";
           $staffdi = $staff['id'];
           $name = $system->GetRealnamebystaff_id($staffdi);
           echo "<td style='vertical-align:middle;border-bottom:1px solid'><a href='../ld/ldchakan.php?staff_id=$staffdi&setdate=$dt'>$name</a></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:1px solid #DDD;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'><tr><td style='border:0px;'>".$staff['starttime']."</td></tr>
                            <tr><td>".$staff['endtime']."</td></tr></table></td>";
           $work_matters = $staff['work_matters'];
           $cs = count($work_matters);
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'>";
           foreach ($work_matters as $key => $value) {
               echo "<tr><td>".$value['work_matter_name']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;margin-left:0px'>";
           foreach ($work_matters as $key => $value) {
               echo "<tr><td>".$value['work_matter_content']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'>";
           foreach ($work_matters as $key => $value) {
               echo "<tr><td>".$value['work_matter_time']."小时</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'>";
           foreach ($work_matters as $key => $value) {
               if($value['work_matter_remark']!='')
                echo "<tr><td>".$value['work_matter_remark']."</td></tr>";
                else
                    echo "<tr><td>暂无</td></tr>";
           }
           echo "</table></td>";
       }
     }
   }
      else
      {
          echo "您不是负责人，不能查看";
      }
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
            </tr></table>

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
    
</script>