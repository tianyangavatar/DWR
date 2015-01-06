<?php 
    require_once("system.class.php");
    $departments = $system->Getdepartment();
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
    部门名称：
    <input type="text" name="rolename" id="rolename"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">新增部门</button>
</form>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>部门编号</th>
        <th>部门名称</th>
        <th>人员</th>
        <th>负责人</th>
        <th>管理</th>
        <th>操作</th>
    </tr>
    </thead>
	    <?php
        //print_r($departments);
            if(!empty($departments))
            {
             foreach ($departments as $key => $department) {
                 echo "<tr>";
                 echo "<td>".$department['id']."</td>";
                 echo "<td>".$department['name']."</td>";
                 $staffshu = $system->GetStaffCountinDepartment($department['id']);
                 echo "<td>".$staffshu."</td>";
                 $fzrid = $department['leader_id'];
                 $name = $system->GetRealnamebystaff_id($fzrid);
                 echo "<td>".$name."</td>";
                 $czid = $department['id'];
                 echo "<td>"."<a href='edit.php?czid=$czid'>编辑</a></td>";
                 echo "<td>"."<a href='delete.php?czid=$czid'>删除</a></td></tr>";
             }
         }
        ?></table>

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