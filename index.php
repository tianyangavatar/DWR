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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
</head>
<BODY id=userlogin_body>
      <div class="main" style="background-img:url(images/userdr.jpg)">
        <div class="login-form" style='height:400px'>
            <h1>用户登录</h1>
                    <div class="head">
                        <img src="dl/images/user.png" alt=""/>
                    </div>
                <form method='post' action='logindo.php' id='fid'>
                        <input type="text" id='username' name="username" class="text"  onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'USERNAME';}" >
                        <div id="un"></div>
                        <input type="password"  id='password' name="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
                        <div id="papppp"></div>
                        <div class="submit">
                            <input type="button" class='btdl' id="fm" onclick="return myFunction()" value="登录" >
                    </div>  
                    <p><a href="#">忘记密码 ?</a></p>
                </form>
            </div>
            <!--//End-login-form-->
             <!-----start-copyright---->
                    <div class="copy-right">
                        <p>Copyright Kaydy &copy; 2014. All rights reserved.</p> 
                    </div>
                <!-----//end-copyright---->
        </div>
             <!-----//end-main---->
                
<div style="display:none"></div>
</body>
</html>
<script>
function myFunction(){
    var u = document.getElementById('un');
    var p = document.getElementById('papppp');
    var up = document.getElementById('username');
    var pa = document.getElementById('password');
    //alert(u);
    if(up.value==''||up.value=='USERNAME')
    {
        u.innerHTML='请填写用户名'
        return false
    }
    else if(pa.value ==''||pa.value=='PASSWORD')
    {
        p.innerHTML='请填写密码'
        return false
    }
    else
    {
        var fm = document.getElementById('fid')
        fm.submit()
    }
}
</script>