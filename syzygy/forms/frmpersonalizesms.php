<span class="txtsuccess"><?php echo $res; ?></span>
<br /><br />
<form id="sampleform" method="post" action="forms/qrypersonalizesms.php">
<div class="cls"></div>
<label for="Contact Group">Message</label>
<textarea name="txtMsg" id="txtMsg" cols="45" rows="5" ><?php echo($txtMsg);?></textarea>
<span class="error"></span>
<div class="cls"></div>
<label for="test">&nbsp;</label>
<span><?php echo "Put {FirstName} or {LastName} to insert the recipent First Name or Last Name in the SMS"; ?></span>
<div class="cls"></div>
<label for="Contact Group">Recipient</label>
<div class="contactdiv"> 

<?php
$qry ="select distinct(ContactGroup) as ContactGroup from contactlist where UserID = '$LoggedInUserID'";
$rs=Sql_exec($cn,$qry);
while ($row=Sql_fetch_array($rs))
{
	$ContactGroup=$row["ContactGroup"];
	echo "<input name='$ContactGroup' id='$ContactGroup' class='title' type='checkbox' value='$ContactGroup' />";
	echo "<span> $ContactGroup </span>";
	echo " <br />";
	$qry2 ="select FirstName, LastName, MobileNo from contactlist where UserID = '$LoggedInUserID' And ContactGroup = '$ContactGroup'";
	$rs2=Sql_exec($cn,$qry2);
	
	while ($row2=Sql_fetch_array($rs2))
	{
		$FirstName = $row2["FirstName"];
		$LastName = $row2["LastName"];
		$MobileNo = $row2["MobileNo"];
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='recipient[]' class='$ContactGroup' type='checkbox' value='$LastName|$FirstName|$MobileNo' />";
		echo "<span> $FirstName $LastName  </span>";
		echo " <br />";		
	}
}

?>
</div>
<div class="cls"></div>
<input type="submit" value="Send SMS" class="sbtn">
</form>

<script type="text/javascript">
$(function() {
	
	$(".title").click(function()		
	{
		var id = this.id;
		var checked_status = this.checked;
		$("."+id).each(function()
		{
			this.checked = checked_status;
		});
		
		//$('.myCheckbox').prop('checked', true)
	});
	

	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			txtMsg: { required:true }
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});
	
});
</script>
			
