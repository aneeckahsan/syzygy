<?php
checkPrivilegePermission($SingleSMS);
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Single SMS
                </h1>
                <ol class="breadcrumb">
					<li><a href="http://localhost/syzygy/index.php">Dashboard</a></li>
					<li class="active">Single SMS</li>
                </ol>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-6">
				<form id="sampleform" method="post">
					<div class="form-group">
						<label for="Mobile No">Recipient No</label>
						<input type="text" class="form-control" id="txtDestNo" name="txtDestNo" value="<?php echo($txtDestNo);?>">
					</div>
					
					<div class="form-group">
						<label for="Masking">Masking</label>
						<select class="form-control" id="maskingOptions" onchange="loadMaskingForAccount();">
							<option value="" selected="selected">Select a Mask</option>
							<?php 
							$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);

							$query = "select mask from smsportal.account where accountID = (select accountID from user where userID = $LoggedInUserID)";
							$rs=mysql_query($query,$cn);
							if(mysql_affected_rows()>=1){
								$dt=mysql_fetch_array($rs);
								$KeyValuePair = explode(",", $dt[0]);
								for($j = 0; $j < sizeof($KeyValuePair); $j++){
									$val = trim($KeyValuePair[$j]);
									echo("<option value='".$val."'>".$val."</option>");
								}							
							}
							else echo mysql_error();							
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="Contact Group">Message</label>
						<label for="smscount" id="SMSCharCount"></label>
						<textarea class="form-control" id="txtMsg" cols="45" rows="5" maxlength="640" oninput="charCount();" ><?php echo $msg;?></textarea>
					</div>
					<input class="btn btn-danger" type="button" value="Send SMS" class="sbtn" onclick="preparesinglesmsparameters();">
				</form>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">

	var prefix=[];
	var finalListnos={};
	
	$(function() {
		getPrefix();
		$("#sampleform").validate({
			ignore: ":disabled",
			rules: {
				txtDestNo: { required:true },			
				txtMsg: { required:true }
			},
			errorPlacement: function(error, element) {
				element.next("span.error").html(error);
			}
		});
	});

	function charCount(){
		var length = document.getElementById("txtMsg").value.length;
		var smsCount = 0;
		if(document.getElementById("txtMsg").value==null){
			document.getElementById("SMSCharCount").innerHTML = "";
			smsCount = 0;
		}
		else if(length<640){
			smsCount = parseInt(length/160);
			document.getElementById("SMSCharCount").innerHTML = (length) + " (" + smsCount + "/4)";
		}
		else if(length==640){
			document.getElementById("SMSCharCount").innerHTML = "SMS length reached limit !!!";
		}
		else{}
	}
	
	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	function preparesinglesmsparameters(){
		if($('#txtMsg').val()==''){alert("Please input message");return  false;}
		if($('#maskingOptions').val()==''){alert("Please input mask");return false;}
		
		var numberinput = document.getElementById("txtDestNo").value;
		
		if(!isNumeric(numberinput) || !isValidDestNo(numberinput)){alert("Enter a valid number");return;}
		
		var recipientList = numberinput + '\n';
		finalListnos[numberinput] = 1;
		getcurrentbalanceanddeduct("<?php echo $ROOTURL;?>","<?php echo $_SESSION["LoggedInAccountID"];?>","<?php echo $_SESSION["LoggedInUserID"];?>",recipientList);
	}
	
</script>
