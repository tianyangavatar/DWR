<?php
    require_once("system.class.php");
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
<form action="adddo.php" method="post">
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="10%" class="tableleft">部门名称</td>
        <td><input type="text" name="grouptitle"/></td>
    </tr>
     <tr>
        <td width="10%" class="tableleft">上级部门</td>
        <td>
            <?php
                $staffs = $system->Getdepartment();
                echo "<select name='sjbm'>";
                //echo "<option value='0'>中心</option>";
                //echo "<option value='-1'>中心领导</option>";
                foreach ($staffs as $key => $staff) {
                    $id = $staff['id'];
                    $name = $staff['name'];
                    echo "<option value='$id'>$name</option>";
                }
                echo "</select>";
        ?>
        </td>
    </tr>
    <tr>
        <td class="tableleft">部门负责人</td>
        <td><?php
                $staffs = $system->Getstaffs();
                echo "<select name='fuzeren'>";
                foreach ($staffs as $key => $staff) {
                    $id = $staff['id'];
                    $name = $system->GetRealnamebystaff_id($id);
                    echo "<option value='$id'>$name</option>";
                }
                echo "</select>";
        ?></td>
    </tr>  
     
    <tr>
        <td class="tableleft">部门职能描述</td>
        <td width="500px" ><textarea name="function_des" rows="3" cols="2000"></textarea>
       <!-- 
        <td>
            <input type="radio" name="status" value="1" checked/> 启用
            <input type="radio" name="status" value="0"/> 禁用
        </td>
    -->
    </tr>
     <tr>
        <td class="tableleft">备注</td>
        <td width="500px" ><textarea name="beizhu" rows="3" cols="2000"></textarea>
     </tr>
    <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" class="btn btn-primary" type="button">保存</button>&nbsp;&nbsp;<button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button>
        </td>
    </tr>
</table>
</form>
</body>
</html>
<script>
    $(function () {       
		$('#backid').click(function(){
				window.location.href="index.php";
		 });

    });
</script>