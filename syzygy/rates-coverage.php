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
  <div class="contentarea">
  <div class="bannerpic ratebg">
  
<h1>Rates Coverage</h1>
   <span>Order SMS Credits – Recharge Your Account online Or Sign up as a New User Now!</span></div>
   <div class="cls"></div>
   <div class="aboutbl">
  <div class="countyarea">
  <form action="" method="get">Views prices for
      <label for="country"></label>
      <select name="country" id="country">
        <option>Malaysia</option>
      </select>
      <label for="currency"></label>
      <select name="currency2" id="currency">
        <option>Malaysian Ringgit</option>
      </select>
    </form>
  </div>
  <div class="cls"></div>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ratetbl">
    <thead>
    
    
  <tr>
    <td width="30%">Package Name</td>
    <td width="19%">Price</td>
    <td colspan="2">Number of SMS</td>
    </tr></thead>
  <tr>
    <td>A</td>
    <td>RM 125</td>
    <td width="33%">1000</td>
    <td width="18%"><img src="images/btn-cart.png" width="121" height="37" /></td>
  </tr>
  <tr>
    <td>B</td>
    <td>RM 250</td>
    <td>2000</td>
    <td><img src="images/btn-cart.png" width="121" height="37" /></td>
  </tr>
  <tr>
    <td>C</td>
    <td>RM 375</td>
    <td>3000</td>
    <td><img src="images/btn-cart.png" width="121" height="37" /></td>
  </tr>
  <tr>
    <td>D</td>
    <td>RM 475</td>
    <td>5000</td>
    <td><img src="images/btn-cart.png" width="121" height="37" /></td>
  </tr>
</table>
<div class="othtxt">For bulk order please contact with our <a href="contact.php"><strong>sales team</strong></a>.
We will provide best price<br />
</div>
   <div class="cls"></div>
  </div>
 
</div>
<?php include("footer.php"); ?>
</body>
</html>
