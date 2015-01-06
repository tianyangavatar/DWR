<?php
	 require_once("../Node/system.class.php");
	 if(!$system->CheckSessionLogin())
	 {
	 	header('Location:../index.php');
	 }
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
<form class="form-inline definewidth m20" action="changepwddo.php" method="post">
    <table class="table table-bordered table-hover definewidth m10">
    <thead>
                <tr>
                <th colspan=2>修改密码</th> 
            </tr>
        </thead>
    <tr><td>原密码</td><td><input type="text" name="oldpass" id="oldpass" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    </td></tr>
    <tr><td>新密码</td><td><input type="password" name="newpass" id="oldpass" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    </tr><tr><td colspan=2><button type="submit" class="btn btn-primary">提交</button>&nbsp;&nbsp; 
    </td></tr></table>
</form>
