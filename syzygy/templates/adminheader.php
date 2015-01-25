<?php 	


	$file = $_SERVER["SCRIPT_NAME"];
	$break = Explode('/', $file);
	$curent_file_name = $break[count($break) - 1];
?>
<div class="wapper">
  <div class="topmenu">
  	<!--Welcome <?php echo $Logname; ?></span> | <a href="<?php echo $logoutAction ?>-->
    <ul>
      <li>Welcome <?php echo $_SESSION["LoggedInUserName"]; ?></li>
      <li>|</li>
      <li><a href="log-out.php">Log Out</a></li>
    </ul>
  </div>
  <div class="nav">
    <div class="logo"><a href="home.php"><img src="images/logo.png" width="151" height="76" border="0" /></a></div>
    <div class="menu">
      <ul>
	  
	  	<?php session_start();
		if ($IsLoggedIn == 'YES')
		{
			echo "<li ";
			if($curent_file_name=='index.php') 
			{ 
			 	echo "class='current'" ;
				$LoggedInUserID =  $_SESSION["LoggedInUserID"];
			} 
			
			echo "><a href='index.php'>Home</a></li>";
		}
		
		else
		{
			echo "<li ";
			if($curent_file_name=='home.php') 
			{ 
			 	echo "class='current'" ;
			} 
			
			echo "><a href='home.php'>Home</a></li>";
		}
		?>
       
        <li <?php if($curent_file_name=='about-us.php') { ?>class="current" <?php } ?>><a href="about-us.php">About Us</a></li>
        <li <?php if($curent_file_name=='rates-coverage.php') { ?>class="current" <?php } ?>><a href="rates-coverage.php">Rates & Coverage </a></li>
        <li <?php if($curent_file_name=='services.php') { ?>class="current" <?php } ?>><a href="services.php">Services</a></li>
        <li <?php if($curent_file_name=='api-demo.php') { ?>class="current" <?php } ?>><a href="api-demo.php">API & Demo </a></li>
        <li <?php if($curent_file_name=='contact.php') { ?>class="current" <?php } ?>><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
  <div class="shadwow"><img src="images/banner-top-shadow.png" width="960" height="27" /></div>
  <div class="cls"></div>
</div>
