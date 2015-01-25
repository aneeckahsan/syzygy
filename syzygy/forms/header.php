<?php
	$file = $_SERVER["SCRIPT_NAME"];
	$break = Explode('/', $file);
	$curent_file_name = $break[count($break) - 1];
	
?>
<div class="wapper">
  <div class="topmenu">
    <ul>
      <li><a href="sign-up.php">Sign Up</a></li>
      <li>|</li>
      <li><a href="log-in.php">Log In</a></li>
    </ul>
  </div>
  <div class="nav">
    <div class="logo"><a href=""><img src="../images/logo.png" width="151" height="76" border="0" /></a></div>

    </div>
  </div>
  <div class="shadwow"><img src="../images/banner-top-shadow.png" width="960" height="27" /></div>
  <div class="cls"></div>
</div>
