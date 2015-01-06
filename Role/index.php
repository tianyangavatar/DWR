<?php
    define('MYENTERPRISE', "My Company");
    require_once("../Node/system.class.php");
    $staffs = $system->Getstaffs();
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
    人员名字：
    <input type="text" name="rolename" id="rolename"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">添加人员</button>
</form>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>人员编号</th>
        <th>人员名称</th>
        <th>真实姓名</th>
        <th>所属部门</th>
        <th>联系邮箱</th>
        <th>管理</th>
        <th>操作</th>
    </tr>
    </thead>
    <?php
        foreach ($staffs as $key => $staff) {
            echo "<tr>";
            echo "<td>".$staff['id']."</td>";
            echo "<td>".$staff['name']."</td>";
            echo "<td>".$staff['realname']."</td>";
            $bm = "";
            if($staff['department_id']==-1)
                $bm = "暂无";
            elseif ($staff['department_id']==0) {
                $bm = MYENTERPRISE;
            }
            else 
                $bm = $system->GetDepartmentNamebydepartment_id($staff['department_id']);
            echo "<td>".$bm."</td>";
            echo "<td>".$staff['email']."</td>";
            $rid = $staff['id'];
            echo "<td><a href='opr.php?czid=$rid'>编辑</a></td>";
            echo "<td><a href='del.php?czid=$rid'>删除</a></td>";
            echo "</tr>";
        }
    ?>
	     <!--<tr>
            <td>5</td>
            <td>管理员</td>
            <td>1</td>
            <td>
                  <a href="edit.html">编辑</a>
                  
            </td>
        </tr>--></table>
		</body>
		</html>

<script>
    $(function () {
        
		$('#addnew').click(function(){

				window.location.href="add.php";
		 });


    });

	function del(id)
	{
		
		
		if(confirm("确定要删除吗？"))
		{
		
			var url = "index.html";
			
			window.location.href=url;		
		
		}
	
	
	
	
	}
</script>