<?php
session_start(); 
include_once "commonlib.php";
scatterVars($_SESSION);
include_once 'inc/php/config.php';
include_once 'inc/php/functions.php';

$action = array();
$action['result'] = null;

$text = array();


if(isset($_POST['button'])){

	//cleanup the variables
	//prevent mysql injection
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$mobileno = mysql_real_escape_string($_POST['mobileno']);
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$email = mysql_real_escape_string($_POST['email']);
	
	//quick/simple validation
	if((empty($firstname)) || $firstname == 'Name'){ $action['result'] = 'error'; array_push($text,'You forgot your Name'); }
	if((empty($mobileno)) || $mobileno == 'Mobile No'){ $action['result'] = 'error'; array_push($text,'You forgot your Mobile No'); }
	if((empty($username)) || $username == 'Username'){ $action['result'] = 'error'; array_push($text,'You forgot your Username'); }
	if((empty($password)) || $password == 'Password'){ $action['result'] = 'error'; array_push($text,'You forgot your Password'); }
	if((empty($email)) || $email == 'Verification Email'){ $action['result'] = 'error'; array_push($text,'You forgot your Email'); }
	
	if($action['result'] != 'error'){
				
		//$password = md5($password);	
			
		//add to the database
		$add = mysql_query("INSERT INTO user (UserID,UserName,FirstName,MobileNo,Password,Email,Active) VALUES ('$username','$username','$firstname','$mobileno','$password','$email',0)");
		$add = mysql_query("INSERT INTO smsgw_2_0.user (UserID,UserName,Password,MobileNo,SMSBalance,CreatedBy,CreateDate,LastUpdate) VALUES ('','$username','$password','$mobileno',0,'SMSPORTAL',now(),now())");
		
		if($add){
			
			//get the new user id
			//$userid = mysql_insert_id();
			
			//create a random key
			$key = $username . $email . date('mY');
			$key = md5($key);
			
			//add confirm row
			$confirm = mysql_query("INSERT INTO confirm VALUES(NULL,'$username','$key','$email')");	
			//$confirm = mysql_query("INSERT INTO smsgw_2_0.user (UserID,UserName,Password,MobileNo) VALUES('$userid','$key','$email')");	
			if($confirm){
			
				//include the swift class
				include_once 'inc/php/swift/swift_required.php';
			
				//put info into an array to send to the function
				$info = array(
					'username' => $username,
					'email' => $email,
					'key' => $key);
			
				//send the email
				if(send_email($info)){
								
					//email sent
					$action['result'] = 'success';
					//array_push($text,'Thanks for signing up. Please check your email for confirmation!');
					header("Location: log-in.php?confirm=Thanks for signing up. Please check your email for confirmation!");
				
				}else{
					
					$action['result'] = 'error';
					array_push($text,'Could not send confirm email');
					
				}
			
			}else{
				
				$action['result'] = 'error';
				array_push($text,'Confirm row was not added to the database. Reason: ' . mysql_error());
				
			}
			
		}else{
		
			$action['result'] = 'error';
			array_push($text,'User could not be added to the database. Reason: ' . mysql_error());
		
		}
	
	}
	
	$action['text'] = $text;

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMS Doze</title>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
<script type="text/javascript" src="js/ajax-validation.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
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
<script type="text/javascript" src="js/ajax-validation.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="ie8.css" />
<![endif]-->

</head>

<body>
<?php include("header.php"); ?>
<div class="conarea">
  <div class="contentarea loginbg">
  <form id="forgotpasswordform" action="sign-up.php" method="post">
   <div class="loginarea">
   <div class="loginheader">Forgot Password</div>
   <div class="loginerror"><?= show_errors($action); ?></div>
   <div class="logincon">
	<label> Enter your E-mail address: </label><br /><br />
	<input type="text" name="email" value="Verification Email" id="email" onblur="if(this.value == '') { this.value='Verification Email'}" onfocus="if (this.value == 'Verification Email') {this.value=''}"/>
    </div>
   <div class="loginfooter">
   <ul class="fl">
   <li><a href="log-in.php">Log in</a></li></ul>
   <input type="submit" id="button" value="Send Code" class="subtn fr" name="button" />
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
