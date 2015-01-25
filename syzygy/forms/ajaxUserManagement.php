<?php
include_once "../commonlib.php";
include_once '../inc/php/functions.php';
// decode JSON string to PHP object, 2nd param sets to associative array
$decoded = json_decode($_POST['data']); 
$encrypted_password = encrypt($decoded->txtPassword);
$operation = $_POST['operation'];

/*foreach ($decoded as $k=>$value) // notice NO reference here!
	$val[$k] = $value;*/

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);
if($decoded->user == 0 ){
	$query="insert into user (username,password,email,mobileno,accountid,roleid,active,lastupdate) 
		values ('$decoded->txtUserName','$encrypted_password','$decoded->txtEmail','$decoded->txtMobileNo',$decoded->accountid,$decoded->role,$decoded->status,now())";

	/////////////////////////
	//create a random key
	$key = $decoded->txtUserName . $decoded->txtEmail . date('mY');
	$key = md5($key);
	//add confirm row
	$confirm = mysql_query("INSERT INTO confirm VALUES(NULL,'$decoded->txtUserName','$key','$decoded->txtEmail')");	
	if($confirm){
			echo 'inside confirm';
			//include the swift class
			include_once '../inc/php/swift/swift_required.php';
			$info = array(
				'username' => $decoded->txtUserName,
				'password' => $decoded->txtPassword,
				'email' => $decoded->txtEmail,
				'key' => $key
			);
			if(send_email($info)){
				echo "Thanks for signing up. Please check email for confirmation!";						
						
			}else{
											
			}
	}
	else{
	echo "Confirm row was not added to the database. Reason: " . mysql_error();
	}
	/////////////////////////
}
else{
	$query="update user set username='$decoded->txtUserName',password='$encrypted_password',email='$decoded->txtEmail',".
	"mobileno='$decoded->txtMobileNo',accountid=$decoded->accountid,roleid=$decoded->role,active=$decoded->status,".
	"lastupdate=now() where userid=$decoded->user";
}

$result = mysql_query($query,$cn);
if(mysql_affected_rows()==1){
	echo "true";
}
else 
	echo mysql_error();
?>