<?php
session_start();
include_once "commonlib.php";

$mode=$_GET["mode"];

$cn=connectDB();
if(!$cn) {
	echo("Cannot connect to server ($server) with error: ".Sql_error());
	die();
}

if($mode=="LOGIN") {
	$uid=$_POST["uid"];
	$pwd=$_POST["pwd"];

	$qry="select * from $TBL_USER where email='$uid'";
	$rs=Sql_exec($cn, $qry);
	$dt=Sql_fetch_array($rs);

	if($pwd == 'Password' && $uid == 'User Name')
	{
		$AccessDenied = "User Name and Password are required";	
	}
	
	//else if($pwd==decrypt($dt["password"]) && $pwd!="" && $dt["active"] == 1) {
        else if($pwd==$dt["password"] && $pwd!="" && $dt["active"] == 1) { 
            
            
		$dt=Sql_fetch_array($rs);
		$_SESSION["IsLoggedIn"]="YES";
		$_SESSION["LoggedInUserID"]=Sql_GetField($rs, "userid");
		$_SESSION["LoggedInUserName"]=Sql_GetField($rs, "username");
		$_SESSION["LoggedInAccountID"]=Sql_GetField($rs, "accountid"); 
		
		$qry="select privilegeids from role where roleid = (select roleid from user where userid = ".$_SESSION['LoggedInUserID'].")";
		$rs=Sql_exec($cn, $qry);
		if(mysql_affected_rows()>0){
			$dt=Sql_fetch_array($rs);
			$_SESSION["PrivilegeIDs"] = ",".$dt[0].",";
		}

		ClosedDBConnection($cn);
		header("Location: index.php");
	}
	
	else if($dt["Active"] == '0')
	{
		$AccessDenied = "You have not confirm your account yet";	
	}
	//echo("Access Denied..!");
	else 
		$AccessDenied = "Username or Password is incorrect";
} 

else if($mode=="LOGOUT") {
	$_SESSION["IsLoggedIn"]="NO";
	$_SESSION["LoggedInUserID"]="";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMS Doze</title>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
<script type="text/javascript"> 
$(document).ready(function(){
	$(".btn-slide").click(function(){
		$(this).parents('.hbox').find('.panbox').slideToggle("slow");
		$(this).toggleClass("active");
        return false;
	});
});
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="ie8.css" />
<![endif]-->

</head>

<body>
<?php include("header.php"); ?>
<div class="conarea">
  <div class="contentarea loginbg">
  <form name="user" method="post" action="log-in.php?mode=LOGIN" >
   <div class="loginarea">
   <div class="loginheader">User Login</div>
   <div>
	<span class="succes"><?php echo $_GET['confirm']; ?></span>
   <span class="loginerror"><?php echo $AccessDenied; ?></span>
   </div>
   <div class="logincon">
  
   <input type="text" value="Email Address" name="uid" id="username" onblur="if(this.value == '') { this.value='Email Address'}" onfocus="if (this.value == 'Email Address') {this.value=''}" />
   <input type="password" value="Password" name="pwd" id="password" onblur="if(this.value == '') { this.value='Password'}" onfocus="if (this.value == 'Password') {this.value=''}" />
   
   </div>
   <div class="loginfooter">
   <ul class="fl">
   <li><a href="sign-up.php">Sign-Up</a></li>
     <li><a href="forgot_password.php">Forgot Password</a></li></ul>
	 <button type="submit" name="submit" id="btnLogin" value="btnLogin" class="subtn fr">Login</button>
     </div>
     <div class="clr"></div>
   </div>
   </form>
  </div>
 <div class="cls"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>