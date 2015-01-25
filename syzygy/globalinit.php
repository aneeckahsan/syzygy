<?php
session_start();
include_once "commonlib.php";


scatterVars($_SESSION);
scatterVars($_GET);
scatterVars($_POST);

$FORM=stripslashes($FORM);
$INITFILE=stripslashes($INITFILE);

if($FORM=="") $FORM="defaultbody.php";

if($IsLoggedIn!="YES" && $CHECK_LOGIN=="YES") header("Location: $LOGIN_URL");
if($CONNECT_DB=="YES") {
	$cn=ConnectDB();
	if(!$cn) {
		echo("Cannot connect to server (($MYSERVER) with error: ".Sql_Error());
		die();
	}
}
$MYNAME = "index.php"; 

if($INITFILE!="")
	include $INITFILE;

if($CMD!="") {
	$qryvar=$CMD."_QRY";
	Sql_exec($cn, $$qryvar);
	echo(Sql_error());
}


if($MODE=="LOAD") {
	$rs=Sql_exec($cn, $LOAD_QRY);
	scatterFields($rs, "txt");
}

$tmpvar="txt".$KEYFIELD;
$tmpval=$$tmpvar;
$LOAD_ACTION="$MYNAME?CMD=UPDATE&MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$KEYFIELD=$tmpval";
$_ACTION="$MYNAME?CMD=INSERT&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD";

$actionvar=$MODE."_ACTION";
$ACTION=$$actionvar;
//echo $ACTION;
?>
