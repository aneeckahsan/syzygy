<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
<!--<label for="User ID">User ID</label>
<label for="User ID"><?php $LoggedInUserID;?></label>
<div class="cls"></div>
<label for="ID">ID</label>-->
<input type="hidden" name="txtID" value="<?php echo($txtID);?>">
<div class="cls"></div>
<label for="First Name">First Name</label>
<input type="text" id="txtFirstName" name="txtFirstName" value="<?php echo($txtFirstName);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Last Name">Last Name</label>
<input type="text" id="txtLastName" name="txtLastName" value="<?php echo($txtLastName);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Mobile No">Mobile No</label>
<input type="text" name="txtMobileNo" value="<?php echo($txtMobileNo);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Email">Email</label>
<input type="text" name="txtEmail" value="<?php echo($txtEmail);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Contact Group">Contact Group</label>
<div>
	<select id="contactGroup" onchange="addNewContactGroupInputBox();">
		<option value="0">Create New Group</option>
		<option value="1" selected="selected">Group 1</option>
		<option value="2">Group 2</option>
		<option value="3">Group 3</option>
	</select>
	<div id="NewContactGroupName" style="visibility:hidden;">
		<label for="Contact Group" id="lblNewContactGroupName">New Group Name: </label>
		<input type="text" id="txtNewContactGroupName" />
	</div>	
</div>

<label>Import Contact:</label>
<textarea name="txtContactList" id="txtContactList" cols="45" rows="5"></textarea>
<div class="cls"></div>
<input type="file" id="fileinput" name="files"/>

<span class="error"></span>
<div class="cls"></div>
<input type="submit" name="button" id="button" value="Save" class="sbtn" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
<tr>
<td>ID</td>
<td>First Name</td>
<td>Last Name</td>
<td>Mobile No</td>
<td>Email</td>
<td>Contact Group</td>
<td>Edit</td>
<td>Delete</td>
</tr></thead>
<?php 
showEntryList($cn, "select ID, FirstName, LastName, MobileNo, Email, ContactGroup from contactlist where UserID ='$LoggedInUserID'","ID");
?>
</table>
</form>
<script type="text/javascript">
$(function() {
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			txtFirstName: { required:true },
			txtLastName: { required:true },
			txtMobileNo: { required:true },
			txtEmail: { required:true , email:true },
			txtContactGroup: { required:true }
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});
});

function addNewContactGroupInputBox(){ 
	if(document.getElementById("contactGroup").value == 0)
		document.getElementById("NewContactGroupName").style.visibility = 'visible';
	else
		document.getElementById("NewContactGroupName").style.visibility = 'hidden';	
}

function readSingleFile(evt){
	var f = evt.target.files[0]; 
    if (f) {
		var r = new FileReader();
        r.onload = function(e){         
			document.getElementById("txtContactList").innerHTML = e.target.result;  
		}
		r.readAsText(f);
    }
	else{ 
		alert("Failed to load file");
    }
}
document.getElementById('fileinput').addEventListener('change', readSingleFile, false);	
</script>
