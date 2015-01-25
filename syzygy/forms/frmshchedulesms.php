<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
<input type="hidden" name="txtID" value="<?php echo($txtID);?>">
<label for="Mobile No">Destination No</label>
<input type="text" name="txtDestNo" value="<?php echo($txtDestNo);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="First Name">Date</label>
<input type="text" class="Date" id="txtScheduleDate" name="txtScheduleDate" value="<?php echo($txtScheduleDate);?>">
<span class="error"></span>
<div class="cls"></div>
<label for="Contact Group">Message</label>
<textarea name="txtMsg" id="txtMsg" cols="45" rows="5" ><?php echo($txtMsg);?></textarea>
<span class="error"></span>
<div class="cls"></div>
<input type="submit" value="Save Scheduled SMS" class="sbtn">



<table width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
<tr>
<td>ID</td>
<td>Dest No</td>
<td>Message</td>
<td>Scheduled Date/Time</td>
<td>Edit</td>
<td>Delete</td>
</tr></thead>
<?php 
showEntryList($cn, "select ID, DestNo, Msg, ScheduleDate from schedulesms","ID");
?>
</table>
</form>

<script type="text/javascript">
$(function() {
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			txtDestNo: { required:true },
			txtScheduleDate: { required:true },
			txtMsg: { required:true }
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});
});
</script>
