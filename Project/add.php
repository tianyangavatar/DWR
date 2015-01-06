<?php 
    require_once('../Node/system.class.php');
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $user = $system->GetStaffbystaff_id($staff_id);
    $department_id = $user['department_id'];
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
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat:"yy-mm-dd"
    });
  });

   $(function() {
    $( "#datepicker1" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat:"yy-mm-dd"
    });
  });
</script>
    <?php
    $allprojects = $system->GetAllProjects();
    ?>
<form action="addprojectdo.php" method="post" class="definewidth m20">
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="10%" class="tableleft">项目名称</td>
        <td><input type="text" name="project_name"/></td>
    </tr>
    <tr>
        <td class="tableleft">上级项目</td>
        <td><select name="higherproject" id="higherproject">
            <option value='-1'>顶级项目</option>
            <?php
                if(!empty($allprojects))
                {
                    foreach ($allprojects as $key => $project) {
                        echo "<option value='".$project['project_id']."'>".$project['project_name']."</option>";
                    }
                }
            ?>
        </select></td>
    </tr>
    <tr>
        <td class="tableleft">所属部门</td>
        <td><select name="department_id" id="department_id">
            <?php
                $departments = $system->Getdepartment();
                if(!empty($departments))
                {
                    foreach ($departments as $key => $department) {
                        echo "<option value='".$department['id']."'>".$department['name']."</option>";
                    }
                }
            ?>
        </select>
         </td>
    </tr>
     <tr>
        <td class="tableleft">负责人</td>
        <td><select name="leader_id" id="leader_id">
            <?php
                $staffs = $system->Getstaffs();
                if(!empty($staffs))
                {
                    foreach ($staffs as $key => $staff) {
                        if($staff['realname']!=ADMINREALNAME)
                            echo "<option value='".$staff['id']."'>".$staff['realname']."</option>";
                    }
                }
            ?>
        </select>
        </td>
    </tr>
     <tr>
        <td class="tableleft">起始时间</td>
        <td><input type="text" name="starttime" id="datepicker"></td>
    </tr>
     <tr>
        <td class="tableleft">结束时间</td>
        <td><input type="text" name="endtime" id="datepicker1"></td>
    </tr>
    <tr>
        <td class="tableleft">项目描述</td>
        <td><textarea name="project_des"></textarea></td>
    </tr>
    <tr>
        <td class="tableleft">项目备注</td>
        <td><textarea name="project_remark"></textarea></td>
    </tr>
    <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" class="btn btn-primary" type="button">保存</button> &nbsp;&nbsp;<button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button>
        </td>
    </tr>
</table>
</form>
</body>
</html>
<script>
    $(function () {       
		$('#backid').click(function(){
				window.location.href="addprojectdo.php";
		 });

    });
</script>