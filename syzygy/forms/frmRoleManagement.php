<?php 
if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID) {echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://192.168.241.153/smsportal/index.php">';exit;}
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
?>
<head>
<style type="text/css">
	select.center_pull {
	    background:#FFFFFF none repeat scroll 0 0;
	    border:2px solid #7E7E7E;
	    color:#333333;
	    font-size:12px;
	    margin-bottom:4px;
	    margin-right:4px;
	    margin-top:4px;
	    width:150px;
	}
</style>

<script type="text/javascript" src="../js/constants.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript" src="../js/picklist.js"></script>
<script type="text/javascript">
	function loadRoleSpecificPrivileges(){
		if(document.getElementById("role").value){	
			$.ajax({		
				type: "POST",
				url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetRoleSpecificPrivileges.php",
				data: {roleid:document.getElementById("role").value},
				success: function(value){
					if(value!="0") document.getElementById("PickList").innerHTML = value;			
					else alert("No data found in the table");
					
				},
				error: function(value) {
					alert("Error occurred: "+value);
				}
			});
		}
		else document.getElementById("PickList").innerHTML = "";
	}	
		
function AddOrUpdateRole(){

	var roleid = document.getElementById("role").value;
	var accid = document.getElementById("account").value;
	if(accid == 0){alert("Please choose an account and try again"); return;}
	
	var arrprivilegeIDs = document.getElementById('PickList').options;
	if(arrprivilegeIDs.length>0){
		var strPrivilegeIDs = arrprivilegeIDs[0].value;
		for(var i=1; i<arrprivilegeIDs.length; i++)
			strPrivilegeIDs = strPrivilegeIDs + "," + arrprivilegeIDs[i].value;
	}
	else{
		alert("Please choose some privilege and then try again.");
		return;
	}
	
	if(roleid > 0){
		var columnsArray = TABLE_ROLE_COLUMNS.split(", ");
		var setString = columnsArray[2] + " = " + accid + ", " + columnsArray[3] + " = '" + strPrivilegeIDs + "'";
		var whereString = columnsArray[0] + "=" + roleid; 
		var query = "UPDATE " + TABLE_ROLE + " SET " + setString + " WHERE " + whereString + ";";
		ajaxInsertUpdateDelete(query);
		location.reload(true);
	}
	else {
		var newRoleName = $('#txtNewName').val();
		if(!newRoleName){alert("Please give the new role name and try again"); return;}
		var valuesString = "'" + newRoleName + "', " + accid + ", '" + strPrivilegeIDs + "', '" + new Date().toISOString().slice(0, 19).replace('T', ' ') + "'";
		var firstCommaIndex = TABLE_ROLE_COLUMNS.indexOf(",");
		var nonPKCols = TABLE_ROLE_COLUMNS.substr(firstCommaIndex + 1);
		var query = "INSERT INTO " + TABLE_ROLE + "(" + nonPKCols + ") VALUES ( " + valuesString + " )"; 
		ajaxInsertUpdateDelete(query);
		location.reload(true);
	}
}

function addNewRole() {
	document.getElementById("account").value = 0;
    	document.getElementById("PickList").innerHTML = "";
    	document.getElementById("role").innerHTML = "<option value='' selected='selected'>Select a role</option>";
    
	var parent = document.getElementById("addNew");
	var numberofchildren = parent.childNodes.length;

	if(numberofchildren <= 11) {
       	var clear = document.createElement('div');
       	clear.setAttribute('class', 'cls');

       	var label = document.createElement('label');
       	label.innerHTML = "New Name:";

       	var input = document.createElement('input');
       	input.setAttribute('type', 'text');
       	input.setAttribute('id', 'txtNewName');
		input.setAttribute('size', '15');

       	parent.appendChild(clear);
       	parent.appendChild(label);
       	parent.appendChild(input);
    	}
}

function DeleteRole(){
	var roleid = document.getElementById("role").value;
	if(!roleid){
		alert("No role is chosen");
		return;
	}
	if(roleid==CONST_SUPERADMIN_ROLE || roleid==CONST_ACCOUNTADMIN_ROLE){
		alert("Super-Admin and Account-Admin roles can not be removed");
		return;
	}
	if(confirm("Do you really want to delete this role?")){
       	var x = document.getElementById("role");
		x.remove(x.selectedIndex);
		var columnsArray = TABLE_ROLE_COLUMNS.split(", ");
		var whereString = columnsArray[0] + " = " + roleid;
		var query = "DELETE FROM " + TABLE_ROLE + " WHERE " + whereString;
		ajaxInsertUpdateDelete(query);
		location.reload(true);
	}
}

function loadAccountSpecificRoles(){
	document.getElementById("role").innerHTML = "<option value='' selected='selected'>Select a role</option>";
	document.getElementById("PickList").innerHTML = "";
	if(document.getElementById("account").value > 0){
		$.ajax({		
			type: "POST",
			url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetAccountSpecificRoles.php",
			data: {accountID:document.getElementById("account").value},
			success: function(value){
				if(value!="0") document.getElementById("role").innerHTML += value;			
				else alert("This account has no predefined role.");
			},
			error: function(value) {
				alert("Error occurred: "+value);
			}
		});
	}
}

</script>
</head>
<body><div class="cls"></div>
<div class="smsbox">
	<form name="theform" id="theform" action="whatever" onSubmit="return selIt();">
		<input type="hidden" name="accountid" id="accountid" value="<?php echo $_SESSION["LoggedInAccountID"] ?>">
		<div id="addNew" style="float:left; width:300px;">
			<label style="width:120px;">Account Name: </label>
			<select id="account" onchange="loadAccountSpecificRoles();">
				<?php 
				if($_SESSION["LoggedInAccountID"] == $SUPERADMIN_ACCOUNTID) {
					echo "<option value='0' selected='selected'>Select an account</option>";
					$query = 'select * from account';
				}
				else 
					$query = "select * from account where accountID = ".$_SESSION["LoggedInAccountID"];		
				buildDropDownFromMySQLQuery($cn, $query, 'accountID', 'accountName'); 
				?>
			</select>

			<div class="cls"></div>
			<label style="width:120px;">Role:</label>
			<select id="role" onchange="loadRoleSpecificPrivileges();">
				<option value="" selected="selected">Select a Role</option>
				<?php
				if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID){
					$qry = "SELECT * FROM role where accountID = ".$_SESSION["LoggedInAccountID"];
					buildDropDownFromMySQLQuery($cn, $qry, 'roleid', 'rolename'); 
				}
				?>
			</select>
		</div>
		<input type="button" value="Add New" onclick="addNewRole();" />

	<div class="cls"></div>

<table style="width:50%;">
	<thead>
		<tr>
			<th width="40%"></th>
			<th width="10%"></th>
			<th width="40%"></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<select class="center_pull" NAME="SelectList" ID="SelectList" SIZE="5" multiple="multiple">
					<?php buildDropDownFromMySQLQuery($cn,'select * from privilege order by privilege', 'id', 'privilege'); ?>
				</select>
			</td>
			
			<td style="vertical-align:middle;">
				<input type="button" value=">>" onclick="addIt();sortPickList();"></input><br />
				<input type="button" value="<<" onclick="delIt();"></input>
			</td>
			
			<td style="padding-left:40px;">
				<select class="center_pull" name="PickList" id="PickList" size="5" multiple="multiple" style="width: 150px"></select>
			</td>
		</tr>
	</tbody>
</table>

<div class="cls"></div>
<input type="button" value="Save" class="sbtn" onclick="AddOrUpdateRole();"/>
<input type="button" value="Remove" class="sbtn" onclick="DeleteRole();"/>

</form>
</div>
</body>	


