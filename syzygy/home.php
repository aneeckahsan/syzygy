<?php

include_once 'inc/php/functions.php';
include "commonlib.php";
//setup some variables/arrays

$cn = connectDB();
$action = array();
$action['result'] = null;

$text = array();

if(isset($_POST['sendtestsms']))
{
	$name=$_POST['name'];
	$email=$_POST['email'];
	$srcno=$_POST['srcno'];
	$destno=$_POST['destno'];
	$msg=$_POST['msg'];
	
	$response='|';
	
	$url=$ROOTURL."sendsms.php?name=$name&email=$email&srcno=$srcno&destno=$destno&msg=$msg";
	$url=str_replace(" ","%20",$url);
	$url=str_replace("__","%20",$url);
	$resultsmsurl=file_get_contents($url) or die("Can't open URL");

	
	if(!$resultsmsurl)
			$response='';
	else
		$response="FAILED|$resultsmsurl";
	
	//echo $resultsmsurl;
	//echo $url;
}

//check if the SIGN UP form has been submitted
if(isset($_POST['signup'])){

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
					array_push($text,'Thanks for signing up. Please check your email for confirmation!');
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
<script type="text/javascript"> 
$(document).ready(function(){
	$(".btn-slide").click(function(){
		$(this).parents('.hbox').find('.panbox').slideToggle("slow");
		$(this).toggleClass("active");
        return false;
	});
	
	$('#country').change(function() {
		var $countryinfo = $("#country option:selected").text();		
		var $info = $("#"+$countryinfo).val();
		var splitinfo = $info.split('||');
		//var flag = splitinfo[0];
		var operators = splitinfo[1];
		var rate = splitinfo[2];
		//alert(rate);
		var splitoperators = operators.split('|');
		
		var i;
		var changeoperators = '';
		for (i = 0; i < splitoperators.length; i++) 
		{
			changeoperators = changeoperators + '<li>' + splitoperators[i] + '</li>';			
		}
		
		$('#operators').html(changeoperators);
		$('#rate').html("RM "+ rate);
		$('#coverage').html("Coverage of "+ $countryinfo);
	});
});

	function charCount(){
		var length = document.getElementById("msg").value.length;
		var smsCount = 0;
		if(document.getElementById("msg").value==null){
			document.getElementById("SMSCharCount").innerHTML = "";
			smsCount = 0;
		}
		else if(length>=0 && length<640){
			smsCount = parseInt(length/160);
			document.getElementById("SMSCharCount").innerHTML = (length) + " (" + smsCount + "/4)";
		}
		else if(length==640){
			document.getElementById("SMSCharCount").innerHTML = "SMS length reached limit !!!";
		}
		else{}
	}
	
	function showContactGroups(){
		
	}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="ie8.css" />
<![endif]-->

</head>

<body>

 <div class="wapper">
  <div class="topmenu">
    <ul>
      <li><a href="sign-up.php">Sign Up</a></li>
      <li>|</li>
      <li><a href="log-in.php">Log In</a></li>
    </ul>
  </div>
  <div class="nav">
    <div class="logo"><a href="home.php"><img src="images/logo.png" width="151" height="76" border="0" /></a></div>
    <div class="menu">
      <ul>
        <li class="current"><a href="home.php">Home</a></li>
        <li><a href="about-us.php">About Us</a></li>
        <li><a href="rates-coverage.php">Rates & Coverage </a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="api-demo.php">API & Demo </a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
  <div class="header">
    <div class="hbox">
      <div class="hicon"><img src="images/icon-1.png" width="70" height="83" /></div>
      <h2>Rates & Coverage</h2>
      Unlock access to billions of mobile phones around the world. Send SMS to over 200 countries and 800 carriers. Besides, now you can have your own short code for selected counties. <a href="#" class="btn-slide">Details</a>
      <div class="panbox">
    <div class="clsbtn"><a href="#" class="btn-slide"><img src="images/icon-top-arrow.gif" alt="Close" width="25" height="22" /></a></div>
      <div class="shadwow"><img src="images/banner-top-shadow.png" width="960" height="27" /></div>
      <h2>The table below contains pricing for sending an <strong>SMS</strong> to the selected country.<br />
        <strong>The price is for text messages only; it does not include special features. </strong></h2>
      <div class="ratebox">
       
        <div class="othtxt">for bulk order please contact with our <a href="#"><strong>sales team</strong></a>.
we will provide best price<br />
<br />
<span>.volume &amp; network dependent subject to change without notice.</span></div>
      </div>
      <div class="coverage">
      <div class="netbg">
        <h3 id="coverage">Coverage of Malaysia</h3>
        <ul id="operators">
			<li>Celcome</li>
          	<li>Maxis</li>
          	<li>Digi</li>
          	<li>U-Mobile</li>
          	<li>XOX Com</li>
        </ul>
        </div>
      </div>
      
    </div>
    </div>
    <div class="hbox">
      <div class="hicon"><img src="images/icon-2.png" width="84" height="71" /></div>
      <h2>Send Test SMS</h2>
      Sending SMS is just one click away. Just click the link bellow and send SMS to any number for free. Please note you will able to send only 1 SMS from your IP. Need to send more? Signup now!!  <a href="#" class="btn-slide">Send Now</a>
      <div class="panbox">
      <div class="clsbtn"><a href="#" class="btn-slide"><img src="images/icon-top-arrow.gif" alt="Close" width="25" height="22" /></a></div>
      <div class="shadwow"><img src="images/banner-top-shadow.png" width="960" height="27" /></div>
      <h2>Send Text Message<strong></strong></h2>
      <form action="home.php" method="post">
      <div class="smsbox">
        <div class="frmarea">
          <input type="text" value="Your Name" id="name" name="name" onblur="if(this.value == '') { this.value='Your Name'}" onfocus="if (this.value == 'Your Name') {this.value=''}" />
          <input type="text" value="Your Email" id="email" name="email" onblur="if(this.value == '') { this.value='Your Email'}" onfocus="if (this.value == 'Your Email') {this.value=''}" />
          <input type="text" value="Your Phone Number" id="srcno" name="srcno" onblur="if(this.value == '') { this.value='Your Phone Number'}" onfocus="if (this.value == 'Your Phone Number') {this.value=''}" />
          <input type="text" value="Destination Number" id="destno" name="destno" onblur="if(this.value == '') { this.value='Destination Number'}" onfocus="if (this.value == 'Destination Number') {this.value=''}" />
          <input type="button" class="subtn smsbtn" value="Import Contacts" onclick="showContactGroups();"/>
		</div>
        <div class="smstxtbox">
			<label for="smstxt">SMS Text</label>
			<label for="smscount" id="SMSCharCount"></label>
			<textarea name="msg" id="msg" rows="" maxlength="640"  oninput="charCount();" ></textarea>
            <input name="sendtestsms" type="submit" value="SEND" class="btn-slide" />
        </div>
      
        <div class="cls"></div>
      </div>
      </form>
    </div>
    </div>
    <div class="hbox">
      <div class="hicon"><img src="images/icon-3.png" width="84" height="70" /></div>
      <h2>Signup /Login</h2>
      Test our different services & coverage just by signing up to our website. It's free and will take few minutes only. We will give you free credits to test first.  
	  
	  <a href="#" class="btn-slide">Signup now</a>
      <div class="panbox">
      <div class="clsbtn"><a href="#" class="btn-slide"><img src="images/icon-top-arrow.gif" alt="Close" width="25" height="22" /></a></div>
      <div class="shadwow"><img src="images/banner-top-shadow.png" width="960" height="27" /></div>
      <h2>Sign Up Form<strong></strong></h2>
      <form action="home.php" method="post">
      
      <div class="smsbox">
	  <!--<div style="font-weight:bold;color:#FF0000;"><?= show_errors($action); ?></div>-->
        <div class="frmarea">
          <input type="text" value="First Name" name="firstname" id="firstname" onblur="if(this.value == '') { this.value='First Name'}" onfocus="if (this.value == 'First Name') {this.value=''}" />
          <input type="text" value="Mobile No" name="mobileno" id="mobileno" onblur="if(this.value == '') { this.value='Mobile No'}" onfocus="if (this.value == 'Mobile No') {this.value=''}" />
          <input type="text" value="Username" name="username" id="username" onblur="if(this.value == '') { this.value='Username'}" onfocus="if (this.value == 'Username') {this.value=''}" />
          <input type="password" value="Password" name="password" id="password" onblur="if(this.value == '') { this.value='Password'}" onfocus="if (this.value == 'Password') {this.value=''}" />
        </div>
        <div class="smstxtbox">
		<span style="font-weight:bold;color:#FF0000;"><?= show_errors($action); ?></span>
        <label>verification email</label>
       <input type="text" name="email" value="" id="email"  />
         <div class="cls"></div>
        <input type="submit" value="Signup Now" class="subtn smsbtn" name="signup" />
          <div class="smtxt">by clicking the button you agree to the <a href="#">Terms fo Use</a> and <a href="#">Privacy Policy</a></div>
        </div>
       
        <div class="cls"></div>
      </div>
      </form>
    </div>
    </div>
  </div>
    <div class="cls"></div>
 
  </div>

<div id="ContactGroups">
	
</div>

   <div class="cls"></div>
<div class="conarea">
  <div class="contentarea">
    <div class="rbox rboxsp">
      <div class="roundbox"><img src="images/icon-sms.png" width="80" height="61" /></div>
      <h2>SMS Scheduling</h2>
      <div class="boxcon">Stop sending SMS as a Spammer! Send unique, personalized SMS each time and make yourself, your business or organisation more valuable. For example, when your recipients receive your SMS, it will display their names individually i.e. 'Dear John' instead of just Hello - they will think you took time to send it personally and not some bulk SMS software like everyone else is doing today! To know more click here.</div>
    </div>
    <div class="rbox">
      <div class="roundbox"><img src="images/icon-sms2.png" width="80" height="61" /></div>
      <h2>Personalized SMS</h2>
      <div class="boxcon">Now you can offer a more interactive way to your customer, to interact with you, any time, any where, just by sending a SMS. And, our unique Information on demand (IOD) service will response them with in a minute. Using this service, the user will get a warm feelings that somebody is always for them to help when they need. To know more visit our API & Demo page.</div>
    </div>
    <div class="cls"></div>
    <div class="rbox rboxsp">
      <div class="roundbox"><img src="images/icon-code.png" width="69" height="60" /></div>
      <h2>Sample Codes & Demo</h2>
      <div class="boxcon">Want to remind your client to pay a bill, or about an event at a specific date and time or Queue up birthday reminders months in advance for your clients Or you want your to–do items sent to you throughout the day ? To cover all these, you do not need a personal assistant, all you need to subscribe to our easy one click SMS scheduling. To check more, click here to visit our APIs & Demo page.</div>
    </div>
    <div class="rbox">
      <div class="roundbox"><img src="images/icon-push.png" width="61" height="53" /></div>
      <h2>Push Pull Service</h2>
      <div class="boxcon">We believe every client is unique, as well as their needs. To meet all of your unique needs,  we offer all our APIs and Demos ready to use format. And you will not need to do any coding at your own ( yes, we mean that!).  We have more than 10 code sample and demo applications. Click here to know more about our APIs & Demo.</div>
    </div>
  </div>
  <div class="cls"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
