<?php 
include("included/checkboxtreeandjpages.php");
checkPrivilegePermission($ContactGroup);
$action = (isset($_REQUEST['mode']) && !empty($_REQUEST['mode']))?$_REQUEST['mode']: NULL;
$urlgroupid = (isset($_REQUEST['groupid']) && !empty($_REQUEST['groupid']))?$_REQUEST['groupid']: NULL;
?>

<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
	<div class="cls"></div>
	<div class="smsbox">
		<label for="Contact Group">Contact Group</label>
		<div id="createContactGroup">
			<div id="addNew">
				<select id="contactGroup">
					<option value="">Please Select</option>
					<?php 
					$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
					$query = "select * from smsportal.group where userid = '$LoggedInUserID'";
					$value = 'groupid';
					$text = 'groupname';
					buildDropDownFromMySQLQuery($cn, $query, $value, $text); 
					?>
				</select>
				<input type="button" value="Add New" onclick="addNew();"/>
			</div>	
		</div>
		<div class="cls"></div>
		<?php
		include "contactimport.php";
		?>
		<div class="cls"></div>
		<div>
			<input type="button" value="Save" class="sbtn" onclick="submitContactgroup();"/>
			<input type="button" value="Remove" class="sbtn" onclick="DeleteGroup();"/>
		</div>
	</div>
</form>
<script type="text/javascript">
$("#contactGroup").change(function() {
	$('#txtNewContactGroupName').hide();
	var n = $("#contactGroup option:selected").text();
	destroyfinallist();
	fetchselectedgroupnumbers(n);
});

function addNew(){
	destroyfinallist();
	$('#contactGroup').val('');
	var parent = document.getElementById("addNew");
	var numberofchildren = parent.childNodes.length;

	if(numberofchildren <=5){
		var clear = document.createElement('div');
		clear.setAttribute('class','cls');
	
		var label = document.createElement('label');
		label.innerHTML = "New Name:";
	
		var input = document.createElement('input');
		input.setAttribute('type','text');	
		input.setAttribute('id','txtNewContactGroupName');
	
		parent.appendChild(clear);
		parent.appendChild(label);
		parent.appendChild(input);
	}
	$('#txtNewContactGroupName').show();
}

function submitContactgroup(){
	GroupName=$('#txtNewContactGroupName').val();
	if($("#contactGroup option:selected").val() === ''){
		if(!GroupName){ alert("Please enter group name"); return false;}
	}	
	var nosvalue = JSON.stringify(finalListnos);
	var namesvalue=JSON.stringify(finalListnames);
	var emailvalue=JSON.stringify(finalListemails);	

	if(finalListid == 0){alert("Please enter numbers");return false;}
	$("#loader").fadeIn('slow');	
	$.ajax({
		type: "POST",
              url: "<?php echo $ROOTURL ?>" + "forms/ajaxContactGroup.php",
	       data: {userid:"<?php echo $LoggedInUserID;?>",GroupName:$('#txtNewContactGroupName').val(),GroupId:$("#contactGroup option:selected").val(),nosajax:nosvalue,namesajax:namesvalue,emailsajax:emailvalue},
              async:false,
	       success: function(value){
			$("#loader").fadeOut('slow');
			alert("Operation Successful");
	       },
	       error: function(value) {
			$("#loader").fadeOut('slow');alert("Error occured");
	       }
	});
	location.reload(true);
}

function DeleteGroup(){
	$("#loader").fadeIn('slow');
	var groupID = $("#contactGroup option:selected").val();
	var userID = <?php echo $_SESSION["LoggedInUserID"];?>;
	if(!groupID){
		alert("No group is chosen");
		return;
	}
	var columnsArray = TABLE_GROUP_COLUMNS.split(", ");
	var whereString = columnsArray[2] + " = " + userID +" and "+ columnsArray[0] + " = " + groupID;
	var query = "DELETE FROM " + TABLE_GROUP + " WHERE " + whereString;
	if(ajaxInsertUpdateDeleteFromContactGroup(query) == 1);{
		var columnsArray = TABLE_CONTACTLIST_COLUMNS.split(", ");
		var whereString = columnsArray[4] + " = " + groupID;
		var query = "DELETE FROM " + TABLE_CONTACTLIST + " WHERE " + whereString;
		if(ajaxInsertUpdateDeleteFromContactGroup(query) == 1) {$("#loader").fadeOut('slow');alert("Group has been removed");}
	}
	location.reload(true);
}
</script>



