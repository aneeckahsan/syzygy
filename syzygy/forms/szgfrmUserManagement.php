<?php 
include_once "../config.php";
//checkPrivilegePermission($UserManagement);
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
?>

<form id="form1"><div class="cls"></div>
<div class="smsbox">
	<!--label>Account Name: </label>
	<select id="account" onchange="loadAccountSpecificUsers();">
		<?php 
		/*if($_SESSION["LoggedInAccountID"] == $SUPERADMIN_ACCOUNTID) {
			echo "<option value='0' selected='selected'>Select an account</option>";
			$query = 'select * from account';
		}
		else 
			$query = "select * from account where accountID = ".$_SESSION["LoggedInAccountID"];	
		
		buildDropDownFromMySQLQuery($cn, $query, 'accountID', 'accountName'); */
		?>
	</select>
	
	<div class="cls"></div>
	<div id="addNew" style="disply:inline-block;float:left; padding-right:20px;">
		<label>User: </label> 
		<select id="user" name="user" onchange="loadUserDetails();">
			<option value="0" selected="selected">Select an user</option>
			<?php 
			/*if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID) {
				$query = "select * from user where accountid = ".$_SESSION["LoggedInAccountID"];
				buildDropDownFromMySQLQuery($cn, $query, 'userid', 'username');
			}*/
			?>
		}
		</select>
	</div>	
	<input type="button" value="Add New" onclick="addNewUser();" /-->		
	
	<div class="cls"></div>
	<div id="usernamediv">
	<label id="lblUserID">User ID: </label>
	<input type="text" id="txtUserID" value="" name="txtUserID"/></div>
	
	<div class="cls"></div>
	<label>Parent ID: </label>
	<input type="text" id="txtParentID" name="txtParentID" value="Autofilled by loggedInUserID"/>
	
	<div class="cls"></div>
	<label>User Type: </label>
	<select id="usertype" name="usertype">
		<option value="1" selected="selected">Reseller</option>
		<option value="2">Client</option>
	</select>
	
	<div class="cls"></div>
	<label>E-mail: </label>
	<input type="text" id="txtEmail" name="txtEmail"/>
	
	<div class="cls"></div>
	<label>Mobile No: </label>
	<input type="text" id="txtMobileNo" value="" name="txtMobileNo"/>
	
	<div class="cls"></div>
	<label>District: </label>
	<select id="district" name="district">
		<option value="1" selected="selected">Colombo</option>
		<option value="2">Tamilia</option>
	</select>
	
	<div class="cls"></div>
	<label>Province: </label>
	<select id="province" name="province">
		<option value="1" selected="selected">Colombo1</option>
		<option value="2">Tamilia1</option>
	</select>
	
	<div class="cls"></div>
	<label>Country: </label>
	<select id="country" name="country">
		<option value="1" selected="selected">Colombo2</option>
		<option value="2">Tamilia2</option>
	</select>
	
	<div class="cls"></div>
	<label>Maximum Child: </label>
	<input type="text" id="txtMaxChildCount" name="txtMaxChildCount"/>
	
	<!--div class="cls"></div>
	<label>Role: </label>
	<select id="role" name="role">
		<option value="" selected="selected">Select a Role</option>
		<?php 
		/*if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID) {	
			$qry = "SELECT * FROM role where accountID = ".$_SESSION["LoggedInAccountID"];
			buildDropDownFromMySQLQuery($cn, $qry, 'roleid', 'rolename'); 
		}*/
		?>
	</select-->
	
	<div class="cls"></div>
	<input type="button" value="Save" class="sbtn" onclick="AddOrUpdateUser();"/>
	<input type="button" value="Remove" class="sbtn" onclick="DeleteUser();"/>
		
</div>
</form>

<script type="text/javascript">
var prefix=[];
$(document).ready(function() {
	getPrefix();
});
function DeleteUser(){
	var accountID = document.getElementById("account").value;
	var userID = document.getElementById("user").value;
	if(accountID<=0 || userID <=0){
		alert("No account and user id is chosen");
		return;
	}
	var columnsArray = TABLE_USER_COLUMNS.split(", ");
	var whereString = columnsArray[0] + " = " + userID;
	var query = "DELETE FROM " + TABLE_USER + " WHERE " + whereString;
	ajaxInsertUpdateDelete(query);
	NullifyFields();
}

function loadUserDetails(){
	document.getElementById("lblUserName").innerHTML = "Username: ";
	if(document.getElementById("user").value>0){	
		$.ajax({		
			type: "POST",
			url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetUserDetails.php",
			data: {userID:document.getElementById("user").value},
			success: function(value){
				if(value!="0"){
					obj = JSON && JSON.parse(value) || $.parseJSON(value);
					$('#txtUserName').val(obj.username);
					$('#txtPassword').val(obj.password);					
					$('#txtMobileNo').val(obj.mobileno);
					$('#txtEmail').val(obj.email);
					$('#status').val(obj.active);
					$('#role').val(obj.roleid);												
				}
				else{
					alert("This account has no user.");
				}
			},
			error: function(value) {
				alert("Error occurred: "+value);
			}
		});
	}
	else {
		$('#txtUserName').val("");
		$('#txtPassword').val("");					
		$('#txtMobileNo').val("");
		$('#txtEmail').val("");					
		$('#role').val(3);
		document.getElementById("user").value = 0;
	}
}

function NullifyFields(){
	document.getElementById("user").innerHTML = '<option value="0" selected="selected">Select an user</option>';
	//document.getElementById("role").innerHTML = '<option value="0" selected="selected">Select a role</option>';
	$('#txtUserName').val("");
	$('#txtPassword').val("");					
	$('#txtMobileNo').val("");
	$('#txtEmail').val("");					
	$('#role').val(3);
}

function loadAccountSpecificUsers(){ 
	document.getElementById("lblUserName").innerHTML = "Username: ";
	if(document.getElementById("account").value>0){
		var accid = document.getElementById("account").value;
		if(document.getElementById("account").length > 1) NullifyFields();	
		$.ajax({		
			type: "POST",
			url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetAccountSpecificUsers.php",
			data: {accountID:accid},
			success: function(value){
				if(value!="0"){						
					document.getElementById("user").innerHTML += value;
					//////////////////////
					/*$.ajax({		
						type: "POST",
						url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetAccountSpecificRoles.php",
						data: {accountID:accid},
						success: function(value){
							if(value!="0") document.getElementById("role").innerHTML += value;
							else alert("This account has no predefined role.");
						},
						error: function(value) {alert("Error occurred: "+value);}
					});*/					
				}
					//////////////////////
				else alert("This account has no user.");
			},
			error: function(value) {alert("Error occurred: "+value);}
		});
	}
	else document.getElementById("user").innerHTML = '<option value="0" selected="selected">Select a user</option>';
}

function AddOrUpdateUser(){
	$("#loader").fadeIn('slow');
	var isuserexisted = 0;
	if($('#txtUserName').val()==''){alert("Please input user name");return false;}
	if($('#txtPassword').val()==''){alert("Please input password");return false;}
	if($('#txtMobileNo').val()==''){alert("Please input mobile number");return false;}
	else if(!isValidDestNo($('#txtMobileNo').val())){alert("Mobile number is not correct, please put a valid mobile number and try again.");return false;}
	if(!ValidateEmail($('#txtEmail').val())){alert("Email format is not correct, please put a valid email and try again.");return false;}
	
		$.ajax({
		type: "POST",
		url: "<?php echo $ROOTURL; ?>" + "forms/checkisuserinserted.php",
		data: {email:$('#txtEmail').val(),user:$('#user').val()},
		async: false,
		success: function(data){//alert(data);
			if(data=="1") {
				alert("Email already exists");
				isuserexisted = 1;
				return false;
			}
			else{
				var formVals = $('#form1').serializeArray();
				var jsonObj = {};
				for (i in formVals){
					jsonObj[formVals[i].name] = formVals[i].value;
				}

				jsonObj['accountid'] = document.getElementById("account").value;
				var submitVals = JSON.stringify(jsonObj);
				//alert(submitVals);
				$.ajax({
					type: "POST",
					url: "<?php echo $ROOTURL; ?>" + "forms/ajaxUserManagement.php",
					data: {data:submitVals},
					success: function(data){
						$("#loader").fadeOut('slow'); 
						alert("User successfully updated");},
					error: function(value) {alert("Error occurred: "+value);}
				});
			}
		},
		error: function(value) {alert("Error occurred");}
		});
	
	if(isuserexisted == 1) return false;
	
}

function addNewUser() {
	document.getElementById("lblUserName").innerHTML = "New Name";
	document.getElementById("user").value = 0;
		$('#txtUserName').val("");
		$('#txtPassword').val("");					
		$('#txtMobileNo').val("");
		$('#txtEmail').val("");					
		$('#role').val(3);
	
}
	
</script>
