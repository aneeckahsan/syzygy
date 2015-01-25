<head>
<?php 
include("included/checkboxtreeandjpages.php");
checkPrivilegePermission($BulkSMS);
$action = (isset($_REQUEST['mode']) && !empty($_REQUEST['mode']))?$_REQUEST['mode']:  NULL;
$urlgroupid = (isset($_REQUEST['groupid']) && !empty($_REQUEST['groupid']))?$_REQUEST ['groupid']: NULL;
?>
<script type="text/javascript" src="js/constants.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Bulk SMS
                </h1>
                <ol class="breadcrumb">
					<li><a href="http://localhost/syzygy/index.php">Dashboard</a></li>
					<li class="active">Bulk SMS</li>
                </ol>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-6">
				<div class="smsbox">
					<div id="loader"><img src="images/loader.gif"></div>
					<form id="sampleform" method="post" action="<?php echo($ACTION);?>">					
						<div class="form-group">
							<label for="Message">Message</label>
							<label for="smscount" id="SMSCharCount"></label>
							<textarea class="form-control" id="txtMsg" cols="45" rows="5" maxlength="640" oninput="charCount();" >
								<?php  echo $msg;?>
							</textarea>
						</div>
					
						<div class="form-group">
							<label for="Message">Load from template</label>
							<div id="templates">
								<select class="form-control" id="templateoptions" onchange="loadTemplates();">
									<option value="">Select a template</option>
									<?php 
									$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
									$query = "select * from template where userid = $LoggedInUserID";
									$value = 'text';
									$text = 'text';
									buildDropDownFromMySQLQuery($cn, $query, $value, $text); 
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="Masking">Masking</label>
							<select class="form-control" id="maskingOptions" onchange="loadMaskingForAccount();">
								<option value="" selected="selected">Select a Mask</option>
								<?php 
								$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
								$query = "select mask from smsportal.account where accountID = (select accountID  from user where userID = $LoggedInUserID)";
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
						<?php include "contactimport.php"; ?>

						<div class="cls"></div>
						<input type="button" value="Calculate Charge" class="sbtn" onclick="calculateSMSCharge ();">
						<input type="button" value="Send Bulk SMS" class="sbtn" onclick='preparebulksmsparameters();'>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

function calculateSMSCharge(){	

	var finallistid = document.getElementById('searchfromfinallist');
	if(!finallistid ){alert(" Please add phone numbers");return;}
	var lis = finallistid.getElementsByTagName("li");
	var recipientList = '';
	for(var i=0, im=lis.length; im>i; i++)
		recipientList = recipientList + lis[i].childNodes[1].nodeValue + '\n';
	$.ajax({  
		type: "POST",
		url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetSMSRate.php",
		data: {},
		async: false,
		success: function(value){
			if(value){
				var arrRate = value.split(";");
				var prefixCount = arrRate.length;
		     
				var operators = new Array(prefixCount);
				var counter = new Array(prefixCount);
				var charge = new Array(prefixCount);
				var prefix = new Array(prefixCount);
		     
				for(var i=0; i<arrRate.length; i++){
					if(arrRate[i]){
						var arr2 = arrRate[i].split(",");
						operators[i] = arr2[0];
						prefix[i] = arr2[1];
						charge[i] = parseFloat(arr2[2]);
					}
					counter[i] = 0;
				}

				var arr = recipientList.split('\n');
				for(var i=0; i<arr.length; i++)
					for(var j=0; j<prefix.length; j++)
						if(arr[i].startsWith(prefix[j])) counter [j]++;
				
				var total = 0;
				var amount = 0.0;
				for(var i=0; i<counter.length-1; i++){
					total += counter[i];
					amount=amount+parseFloat((charge[i]*counter [i]).toFixed(2));
				}
                           
				var str = '';
				for(var i=0; i<counter.length-1; i++){
					str += "OPERATOR: "+operators[i]+" CHARGE:  "+charge[i]+ " COUNT: "+counter[i]+" TOTAL: "+(charge[i]*counter[i]).toFixed(2)+"\n";		 		}

				str += "\n TOTAL SMS Count: " + total+"\n TOTAL Amount: "  + amount;
				alert(str);
			}
			else{
				alert("Found nothing");
			}
		},
		error: function(value){
			alert("ERROR: "+value);
		}
	});

}
function preparebulksmsparameters(){

	if($('#txtMsg').val()==''){alert("Please input message");return  false;}
	if($('#maskingOptions').val()==''){alert("Please input mask");return false;}
	if(finalListid == 0 ){alert("Please enter numbers");return false;}

	var finallistid = document.getElementById('searchfromfinallist');
	if(!finallistid ){alert(" Please add phone numbers");return;}
	var lis = finallistid.getElementsByTagName("li");
	var recipientList = '';
	for(var i=0, im=lis.length; im>i; i++) recipientList = recipientList + lis[i].childNodes[1].nodeValue + '\n';
	getcurrentbalanceanddeduct("<?php echo $ROOTURL;?>","<?php echo $_SESSION["LoggedInAccountID"];?>","<?php echo $_SESSION["LoggedInUserID"];?>",recipientList);
}

</script>

