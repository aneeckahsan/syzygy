<?php 
if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID) {echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://192.168.241.153/smsportal/index.php">';exit;}
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
?>
<div class="cls"></div>
<div class="smsbox">
<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
	<div class="cls"></div>
	<label>Account Name:</label>
	<select id="destinationAccount" onchange="showCurrentBalance();">
		<option value="0" selected="selected">Select an account</option>
		<?php
		$value = "accountID,balance";
		buildDropDownFromMySQLQuery($cn, 'select * from account where status = 1', $value, 'accountName'); 
		?>
	</select>

	<div class="cls"></div>
	<label>Current Balance:</label>
	<input type="text" id="txtCurrentBalance" readonly/>

	<div class="cls"></div>
	<label>Amount of Credit:</label>
	<input type="text" id="txtCreditAmount"/>

	<div class="cls"></div>
	<input type="button" id="btnTransferCredit" value="Transfer Credit" class="sbtn" onclick = "credittransfer();">
	
</form>
</div>
<script type="text/javascript">
function showCurrentBalance(){
	var tempArr = document.getElementById("destinationAccount").value.split(",");
	document.getElementById("txtCurrentBalance").value = tempArr[1];
}

function credittransfer(){
	if(document.getElementById("destinationAccount").value <= 0){
		alert("Please select an account");
		return;
	}	
	if(!document.getElementById("txtCreditAmount").value || document.getElementById("txtCreditAmount").value <= 0){
		alert("Please put a valid amount and then try again");
		return;
	}

	var superBalance;
	var credit = document.getElementById("txtCreditAmount").value;
	$('#destinationAccount option').each(function(){
		if($(this).val().indexOf('1,') == 0) {
			superBalance = $(this).val().split(",")[1]; 
		}
	});
	if($("#destinationAccount").val().split(",")[0] != <?php echo $SUPERADMIN_ACCOUNTID;?>){
	if(parseInt(credit) > parseInt(superBalance)){
		alert("Credit amount exceeded the SUPER-ADMIN's current balance ("+ superBalance +" sms credit)");
		return;
	}
	else{
		var balanceAfterDeduction = superBalance - $("#txtCreditAmount").val();
		if(confirm("Current Balance: "+ superBalance + " Deduction amount: " + $("#txtCreditAmount").val() + " Balance after deduction: " + balanceAfterDeduction)){
			callAjax();
		}
	}
	}
	else{
		callAjax();
	}
}	
function callAjax(){
			$.ajax({
				type: "POST",
				url: "<?php echo $ROOTURL ?>" + "forms/ajaxManageCredit.php",
				data: {destinationAccount:$("#destinationAccount").val(),txtCreditAmount:$("#txtCreditAmount").val()},
				success: function(value){
					if(value=="1") {alert("Credit transferred successfully" ); location.reload(true);}
					else {alert("Credit transfer failed" ); location.reload(true);}
				},
				error: function(value){
					alert("Error occured: " + value );
				}
			});
}
</script>

