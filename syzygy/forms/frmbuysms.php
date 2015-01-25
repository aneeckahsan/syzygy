<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
<!--<label for="User ID">User ID</label>
<label for="User ID"><?php $LoggedInUserID;?></label>
<div class="cls"></div>
<label for="ID">ID</label>-->
<input type="hidden" name="txtUserID" value="<?php echo($txtUserID);?>">
<input type="hidden" name="txtMobileNo" value="<?php echo($txtMobileNo);?>">
<div class="cls"></div>
<label for="First Name">User Name</label>
<input type="text" readonly='true' id="txtUserName" name="txtUserName" value="<?php echo($txtUserName);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Last Name">SMS Balance</label>
<input type="text" readonly='true' id="txtSMSBalance" name="txtSMSBalance" value="<?php echo($txtSMSBalance);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Mobile No">Buy SMS</label>
<select name="txtBuySMS" id="txtBuySMS" >
    <option value="100">100</option>
	<option value="200">200</option>
	<option value="300">300</option>
	<option value="400">400</option>
</select>

<div class="cls"></div>

<input type="submit" name="button" id="button" value="Save" class="sbtn" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
<tr>
<td>ID</td>
<td>User Name</td>
<td>Mobile No</td>
<td>SMS Balance</td>
<td>Select</td>
</tr></thead>
<?php 
showEntryListSelectMYSQL($cn, "SELECT UserID,UserName,MobileNo,SMSBalance FROM smsgw_2_0.user WHERE CreatedBy = 'SMSPORTAL' ORDER BY UserName","UserID");
?>
</table>
</form>
<script type="text/javascript">
$(function() {
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: 
		{
			txtUserName: { required:true }			
		},
		errorPlacement: function(error, element) 
		{
			element.next("span.error").html(error);
		}
	});
	
	
	/*$('#drpBuySMS').change(function() 
	{
	  var $val = $(this).val();
	  alert ($val);
	});*/
	

});
</script>
