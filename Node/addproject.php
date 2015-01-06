<?php 
    require_once('../Node/system.class.php');
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $user = $system->GetStaffbystaff_id($staff_id);
    $department_id = $user['departmentid'];
    $pid = $_GET['id'];
    $projects = $system->GetAllProjects(); 
    print_r($projects);
    
    $depth = $system->GetProjectTreeDepth(0);
    $treeprojects = treepro($depth,$projects);
    echo "depth=$depth";
    function treepro($depth,$projects)
    {
    	$res = array();
    	$curdep = 0;
    	while ( $curdep <= $depth) {
    		$curprojects = array();
    		foreach ($projects as $key => $project) {
    			if($project['project_tree_rank']==$curdep)
    				$curprojects[$project['project_id']]=$project;
    		}
    		$res[$curdep] = $curprojects;
    		$curdep = $curdep + 1;
    	}
    	return $res; 
    }
    print_r($treeprojects);

    //递归函数
    function gennertreeselect($project_id,&$str,&$sys)
    {
        $treeprojects = array();
    	$treeprojects = $sys->GetLowerProjects_sel($project_id);
        $pro = $sys->GetProjectByid($project_id);

        if(empty($treeprojects))
        {
            $pro = $sys->GetProjectByid($project_id);
            $str.="<option value='".$pro[0]['project_id']."'>".$pro[0]['project_name']."</option>";
        }
        else
        {
            $pro = $sys->GetProjectByid($project_id);
            $rr="";
            if($project_id!=0)
                $str .="<optgroup label='".$pro[0]['project_name']."'>";
            foreach ($treeprojects as $key => $value) {
                $rr = gennertreeselect($value['project_id'],$str,$sys).$rr;
            }
            if($project_id!=0)
                $str .=$rr."</optgroup>";
        }
    }

    $str = "";
    gennertreeselect(0,$str,$system);
    $str1 = "<select name='project'>".$str;
    $str1 .= "</select>";
    echo $str1;

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
    用户名称：
    <input type="text" name="username" id="username"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">返回上级项目</button>
</form>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>项目id</th>
        <th>项目名</th>
        <th>所属部门</th>
        <th>负责人</th>
        <th>项目描述</th>
        <th>项目起始</th>
        <th>项目结束</th>
        <th>当前进度</th>
        <th>备注说明</th>
        <th>操作</th>
    </tr>
    </thead>
    <?php
        /*project_id int not null auto_increment,
                project_tree_rank int not null,
                department_id INT NOT NULL ,
                project_name varchar(128) not null,
                project_des  varchar(1024),
                leader_id varchar(64),
                need_time varchar(64) not null,
                progress varchar(64) not null,
                project_remark varchar(256),
                starttime varchar(128) not null,
                endtime varchar(128) not null,
                primary key(project_id))";
                */
	 if(!empty($projects))
     {
        foreach ($projects as $key => $project) {
            //print_r($project);
            echo "<tr>";
            $departmentname = $system->GetDepartmentNamebydepartment_id($project['department_id']);
            $leadername = $system->GetRealnamebystaff_id($project['leader_id']);
            echo "<td>".$project['project_id']."</td>";
            echo "<td>".$project['project_name']."</td>";
            echo "<td>".$departmentname."</td>";
            echo "<td>".$leadername."</td>";
            echo "<td>".$project['project_des']."</td>";
            echo "<td>".$project['starttime']."</td>";
            echo "<td>".$project['endtime']."</td>";
            echo "<td>".$project['progress']."</td>";
            echo "<td>".$project['project_remark']."</td>";
            $lowerprojects = $system->GetLowerProjects($project['project_id']);
            if($project['project_tree_rank']=='0'&&!empty($lowerprojects))
                echo "<td><a href='editproject.php?id='".$project['project_id']."'>编辑</a>||<a href='lowerprojects.php?id=".$project['project_id']."'</a>子项</a></td>";
            else
                echo "<td><a href='editproject.php?id='".$project['project_id']."'>编辑</a>||<a href='delproject.php?id=".$project['project_id']."'</a>删除</a></td>";
            echo "</tr>";
        }
     }
        ?>
</table>
</body>
</html>
<script>
    $(function () {
        

		$('#addnew').click(function(){

				window.location.href="index.php";
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