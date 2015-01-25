<?php
session_start();
include_once 'inc/php/config.php';
include_once 'inc/php/functions.php';

?>

<?php
$respon = "";
$confirm = "";
//setup some variables
$action = array();
$action['result'] = null;

/*if (isset($_POST['confirm'])
{
	$confirm = $_POST['confirm'];
}*/

//check if the $_GET variables are present
	
//quick/simple validation
if(empty($_GET['email']) || empty($_GET['key'])){
	$action['result'] = 'error';
	$action['text'] = 'We are missing variables. Please double check your email.';			
}
		
if($action['result'] != 'error'){

	//cleanup the variables
	$email = mysql_real_escape_string($_GET['email']);
	$key = mysql_real_escape_string($_GET['key']);
	
	//check if the key is in the database
	$check_key = mysql_query("SELECT * FROM confirm WHERE email = '$email' AND `key` = '$key' LIMIT 1") or die(mysql_error());
	
	if(mysql_num_rows($check_key) != 0){
				
		//get the confirm info
		$confirm_info = mysql_fetch_assoc($check_key);
		
		//confirm the email and update the users database
		$update_users = mysql_query("UPDATE user SET active = 1 WHERE email = '$confirm_info[email]' LIMIT 1") or die(mysql_error());
		
		//delete the confirm row
		$delete = mysql_query("DELETE FROM confirm WHERE email = '$confirm_info[email]' LIMIT 1") or die(mysql_error());
		
		if($update_users){
						
			$action['result'] = 'success';
			$action['text'] = 'User has been confirmed. Thank-You!';
		
		}else{

			$action['result'] = 'error';
			$action['text'] = 'The user could not be updated Reason: '.mysql_error();;
		
		}
	
	}else{
	
		$action['result'] = 'error';
		$action['text'] = 'The key and email is not in our database.';
	
	}
	
	if ($action['result'] == 'error')
	{
		$AccessDenied = $action['text'];
	}
	
	else
	{
		$confirm = $action['text'];
	}
}


?>



<?php

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

	$qry="select username,Password, UserID, Active from $TBL_USER where UserID='$uid'";
	$rs=Sql_exec($cn, $qry);
	$dt=Sql_fetch_array($rs);
	if($pwd==$dt["Password"] && $pwd!="" && $dt["Active"] == 1) {
		$dt=Sql_fetch_array($rs);
		$_SESSION["IsLoggedIn"]="YES";
		$_SESSION["LoggedInUserID"]=Sql_GetField($rs, "UserID");
		$_SESSION["LoggedInUserName"]=Sql_GetField($rs, "username");
		ClosedDBConnection($cn);
		header("Location: index.php");
	}
	else if($dt["Active"] == 0)
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

<?php 
	
	$error = "<div style='padding-left:50px;font-weight:bold;font-size:16px;color:#FF0000;'>$AccessDenied</div>";
	$success = "<div style='padding-left:50px;font-weight:bold;font-size:16px;color:#009900;'>$confirm</div>";
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
	<?php echo $error; ?><?php echo $success; ?>
   
   <div class="logincon">
  
   <input type="text" value="User Name" name="uid" id="LoginID" onblur="if(this.value == '') { this.value='User Name'}" onfocus="if (this.value == 'User Name') {this.value=''}" />
   
   
   
   
   <div class="cls"></div>
   <input type="password" value="Password" name="pwd" id="password" onblur="if(this.value == '') { this.value='Password'}" onfocus="if (this.value == 'Password') {this.value=''}" />
   
   </div>
   <div class="loginfooter">
   <ul class="fl">
   <li><a href="#">Sign-Up</a></li>
     <li><a href="#">Forget Password</a></li></ul>
	 <button type="submit" name="submit" id="btnLogin" value="btnLogin" class="subtn fr">login</button>
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
<?
mysql_close();
?>