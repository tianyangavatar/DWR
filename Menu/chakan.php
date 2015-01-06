<?php 
    require_once("../Node/system.class.php");
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $staffs = array();
    $dt = date("Y-m-j");
    $xqj = date('w',strtotime($dt));   
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

<form class="form-inline definewidth m20" action="index.html" method="get">
    选择周：
    <input type="text" name="menuname" id="menuname"class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">新增周报</button>
</form>
<table class="table table-bordered table-hover definewidth m10">
   
    <?php
        $lastzhouyi = date("Y-m-d");
        //print_r($staffs);
        $dt = date("Y-m-d",time());
      if($system->IsLeader($staff_id))
      {
          $department_id = $system->GetDepartmentofLeader($staff_id);
          
          //print_r($staffs);
          while ( $xqj>0) {
            $staffs = $system->GetWorkloadofDepartment($department_id,$dt);
           
            ?>
            <thead>
                <tr>
                <th colspan=5>日期<?php echo $dt;?></th>
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
          foreach ($staffs as $key => $renayun) {
           //print_r($renayun);
           //echo "ddddddddddddddddddddddddd</br>";
           echo "<tr>";
           $staffdi = $renayun['id'];
           $name = $system->GetRealnamebystaff_id($staffdi);
           echo "<td style='vertical-align:middle'>$name</td>";
           echo "<td style='vertical-align:middle'><table><tr><td>".$renayun['starttime']."</td></tr>
                            <tr><td>".$renayun['endtime']."</td></tr></table></td>";
           $shixiangs = $renayun['shixiang'];
           echo "<td style='vertical-align:middle'><table>";
           foreach ($shixiangs as $key => $value) {
               echo "<tr><td>".$value['work_matter_name']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle'><table>";
           foreach ($shixiangs as $key => $value) {
               echo "<tr><td>".$value['work_matter_content']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle'><table>";
           foreach ($shixiangs as $key => $value) {
               echo "<tr><td>".$value['work_matter_time']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle'><table>";
           foreach ($shixiangs as $key => $value) {
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