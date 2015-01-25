
<span class="txtsuccess"><?php echo $res; ?></span>
<br /><br />
<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
<label for="Contact Group">Message</label>
<textarea name="txtMsg" id="txtMsg" cols="45" rows="5" ><?php echo($txtMsg);?></textarea>
<span class="error"></span>
<div class="cls"></div>
<input name='recipient' id='single' class='title' type="radio" value='single'  checked="checked" /><span class="label">Recipient Number</span>
<input type="text" disabled="disabled" id="txtDestNo" name="txtDestNo" value="<?php echo($txtDestNo);?>">
<div class="cls"></div>
<input name='recipient' id='choose' class='title' type="radio" value='choose' /><span class="label">Recipient from contact list</span>
<div class="cls"></div>
<label for="Contact list">&nbsp;</label>
<div class="contactdiv" id="contactdiv"> 

<?php
$qry ="select distinct(ContactGroup) as ContactGroup from contactlist where UserID = '$LoggedInUserID'";
$rs=Sql_exec($cn,$qry);
while ($row=Sql_fetch_array($rs))
{
	$ContactGroup=$row["ContactGroup"];
	//echo "<input name='$ContactGroup' id='$ContactGroup' class='title' type='checkbox' value='$ContactGroup' />";
	echo "<span> $ContactGroup </span>";
	echo " <br />";
	$qry2 ="select FirstName, LastName, MobileNo as ContactGroup from contactlist where UserID = '$LoggedInUserID' And ContactGroup = '$ContactGroup'";
	$rs2=Sql_exec($cn,$qry2);
	
	while ($row2=Sql_fetch_array($rs2))
	{
		$FirstName = $row2["FirstName"];
		$LastName = $row2["LastName"];
		$MobileNo = $row2["MobileNo"];
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='recipient[]' class='check' type='checkbox' id='$MobileNo' value='$MobileNo' />";
		echo "<span> $FirstName </span>";
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
	
	$(".check").click(function()		
	{
		var id = this.id;
		$('.check').prop('checked', false);
		$(this).prop('checked', true);
		//$('.myCheckbox').prop('checked', true)
	});
	
	$("#single").click(function()		
	{		
		$('#txtDestNo').removeAttr('disabled');		
		$("#contactdiv").children().attr("disabled","disabled");
	});
	
	$("#choose").click(function()		
	{
		$('#txtDestNo').attr('disabled', 'disabled');
		$("#contactdiv").children().removeAttr("disabled");
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
			
