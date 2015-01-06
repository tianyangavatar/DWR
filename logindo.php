<?php
	 require_once("Node/system.class.php");
	 $username = $_POST['username'];
	 $password = $_POST['password'];
	 if($system->Login($username,$password))
	 {
	 	echo "sdfsdfsdfsdf";
	 	$staff_id = $_SESSION[$system->GetSessionVar()];
	 	
	 	if($system->IsDepartmentLeader($staff_id))
	 		header('Location:manage.php');
	 		//echo "9";
	 	else if($system->IsEnterpriseLeader($staff_id))
	 		header('Location:Ld/index.php');
	 	else if($system->IsAdmin($staff_id))
	 		header('Location:manage.php');
	 	else
	 		header('Location:user.php');
	 	
	 		//echo "8";
	 }
	 echo "sdfsdfsdf";
	 
?>
<!DOCTYPE html>
<html>
<head>
    <title> DWR管理系统</title>
        <meta charset="utf-8">
 <link href="dl/css/style.css" rel='stylesheet' type='text/css' />
        <LINK 
href="dl/images/Default.css" type=text/css rel=stylesheet><LINK 
href="dl/images/xtree.css" type=text/css rel=stylesheet><LINK 
href="dl/images/User_Login.css" type=text/css rel=stylesheet>
<BODY id=userlogin_body>
      <div class="main" style="background-img:url(images/userdr.jpg)">
        <div class="login-form">
        	<?php
        	if($system->error=="username is not exist"){
            	echo "用户名不存在!";
            	echo "<a href='index.php'>返回</a>";
            }
            else if($system->error=="password is not crrect")
            {
            	echo "用户名密码错误，请联系管理员！";
	 			echo "<a href='index.php'>返回</a>";
            }
        	?>
        </div>
       </div>
      </body>