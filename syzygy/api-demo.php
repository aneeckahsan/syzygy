<?php
session_start(); 
include_once "commonlib.php";

scatterVars($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMS Doze</title>
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="ie8.css" />
<![endif]-->

</head>

<body>
<?php include("header.php"); ?>
<div class="conarea">
  <div class="contentarea api">
   <div class="bannerpic apiheader">
<h1>API</h1>
<span>Doze’s  application programming interface (API) provides the communication link between  your application and Doze’s SMS Gateway, allowing you to send and receive text  messages and to check the delivery status of text messages you’ve already sent.</span>
</div>
<div class="exmple">
<h3>Example Code</h3>
<strong>Command:</strong><span class="code">http://202.22.194.65/smsgw/SendSMS/SendSingleSMS.php?UserName=SSDTTest&Password=MyPass567&Sender=60166XXXXXX&text=Your+Message+Here&Operator=CTSSDT</span>
<div class="cls"></div>
  <strong>Response:</strong>&nbsp;<br />
  Single Message: ID: apimsgid  <br />
  Multiple Messages: ID: apimsgid To: xxxxxx ID: apimsgid To: xxxxxx </div>
  <h2>HTTP/S  API Quick Start Guide</h2>

<ul class="steplist">
  <li><div class="step">Step 1</div><div class="stepcon">When you&nbsp;<a href="https://www.clickatell.com/register/?product=1" title="Sign up for an HTTP/S API account now">sign up for an HTTP/S account</a>, you will be given  a username, password and api_id: keep these at hand!</div>
  </li>
  <li><div class="step">Step 2</div><div class="stepcon">Once your registration has been  activated you will receive 10 free credits with which to test our service.</div>
  </li>

  <li><div class="step">Step 3</div><div class="stepcon">Have the number you wish to send to  ready in international format e.g. 448311234567.</div>
  </li>
  <li><div class="step">Step 4</div>
  <div class="stepcon">Open your browser (e.g. Internet  Explorer), and type in your info in the address bar in the following sequence: <a href="http://202.22.194.65/smsgw/SendSMS/SendSingleSMS.php?UserName=TestSSDT&Password=MyPass567&Sender=60166XXXXXX&text=Your+Message+Here&Operator=SSDTTest">http://202.22.194.65/smsgw/SendSMS/SendSingleSMS.php?UserName=TestSSDT&Password=MyPass567&Sender=60166XXXXXX&text=Your+Message+Here&Operator=SSDTTest</a></div>

  </li>

  <li><div class="step">Step 5</div><div class="stepcon">The text of your message must be  formatted so that '+' signs replace spaces between words as above. Press  'Enter' on your keyboard and your message will be sent.</div>

  </li>
</ul>
<div class="cls"></div>
  </div>
 
</div>
<?php include("footer.php"); ?>
</body>
</html>
