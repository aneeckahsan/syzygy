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

	$qry="select Password, UserID from $TBL_USER where UserID='$uid'";
	$rs=Sql_exec($cn, $qry);
	$dt=Sql_fetch_array($rs);
	if($pwd==$dt["Password"] && $pwd!="") {
		$dt=Sql_fetch_array($rs);
		$_SESSION["IsLoggedIn"]="YES";
		$_SESSION["LoggedInUserID"]=Sql_GetField($rs, "UserID");
		$_SESSION["LoggedInUserName"]=Sql_GetField($rs, "username");

		ClosedDBConnection($cn);
		header("Location: index.php");
	}
	echo("Access Denied..!");
} else if($mode=="LOGOUT") {
	$_SESSION["IsLoggedIn"]="NO";
	$_SESSION["LoggedInUserID"]="";
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- end meta -->
<title>DIGICON : CQ Audit System</title>
<!-- script -->


<link href="css/style.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link href="css/admin.css" rel="stylesheet" type="text/css" media="all,handheld" />
<!-- end_script -->
</head>
<body class="bg">
<div id="overall" class="admin">
    <div id="header" style="padding-top:0;height:105px;">
        <div class="clear" id="hm_menu">
            <a href="/"><img src="img/logo.jpg" width="133" height="60" alt="logo" class="left" style="margin:24px 0 0 30px;" /></a>
            <div class="right" style="margin:30px 30px 0 0;">
            </div>      
        </div>
        <div style="background-color:#003300;height:5px;"></div>
        <div style="background:url(img/share_shadow.png) repeat-x #FFF;height:5px;"></div>
    </div>
    
    <div id="mid_container" class="clear">
        <div class="top_info">
            <div id="breakcrumb">home</div>
        </div>
        <div id="mid_info" class="clear" style="padding-bottom:50px;overflow:auto;">
			<form name="user" method="post" action="login.php?mode=LOGIN" >
            <div style="width:356px;">
                <div class="tm"><div class="tl"></div><div class="tr"></div></div>
    			<div class="lm"><div class="rm">
                    <div class="cm">
                        <div style="width:332px;margin:0 auto;padding:10px 0;">
                            <h4 class="sel_chg">agent login</h4>
                            <div style="padding:0 10px;">
                                <ul class="sign_form2">
                                    <li>
                                        <span class="txt_bold txt_darkgrey">User Name</span>
                                        <input type="text" name="uid" id="LoginID" class="txtform"  style="width:100%;"/>
                                    </li>
                                    <li>
                                        <span class="txt_bold txt_darkgrey">Password</span>
                                        <input type="password" name="pwd" id="password" class="txtform" style="width:100%;" />
                                    </li>
                                    <li>
									</li>
                                </ul>
                               <button type="submit" name="submit" id="btnLogin" value="btnLogin">login</button>
                            </div>
                        </div>
                    </div>
    			</div></div>
                <div class="bm"><div class="bl"></div><div class="br"></div></div>
 			</div>
			</form>
        </div>
    </div>
    
    <div id="footer" class="clear">
        <img src="img/f_left.png" alt="" width="4" height="72" class="left" />
        <div class="left fm_info">
            <div style="height:20px;"></div>
            <div class="copyright clear">© 2012 Digicon Technologies Ltd. All rights reserved.</div>
        </div>
        <img src="img/f_right.png" alt="" width="4" height="72" class="right" />
    </div>
</div>
<script type="text/javascript">
</script>
</body>
</html>
<?
mysql_close();
?>


