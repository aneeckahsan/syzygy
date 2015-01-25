<?php 
include_once "../config.php";
if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID) {echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://localhost/smsportal/index.php">';exit;}

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
?>

<form id="form1"><div class="cls"></div><div class="smsbox">
	<div id="addNew" style="disply:inline-block;float:left; padding-right:10px;">
		<label>Account Name: </label>
		<select id="account" onchange="LoadAccountDetails();">
			<option value='0' selected='selected'>Select an account</option>
			<?php 			
			buildDropDownFromMySQLQuery($cn, 'select * from account', 'accountID', 'accountName'); 
			?>
		</select>		
	</div>	
	<input type="button" value="Add New" onclick="addNewAccountEntry();" />	

	<div class="cls"></div>
	<label>Credit Balance:</label>
	<input type="text" id="txtCreditBalance" name="txtCreditBalance" style="width:130px;" readonly/>

	<div class="cls"></div>
	<label>Masks:</label>
	<textarea id="txtMasks" rows="5"></textarea>

	<div class="cls"></div>
	<label>Status: </label>
	<select id="status" name="status">
		<option value="0">Inactive</option>
		<option value="1" selected="selected">Active</option>
	</select>

	<div class="cls"></div>
	<input type="button" name="submit" id="submit" value="Save" class="sbtn" onclick="AddOrUpdateAccount();">
	<!--input type="button" value="Remove" class="sbtn" onclick="DeleteAccount();"-->
</div>
</form>
<script type="text/javascript">

function addNewAccountEntry(){
	var parent = document.getElementById("addNew");
 	var numberofchildren = parent.childNodes.length;

    	if (numberofchildren <= 5) {
       	var clear = document.createElement('div');
        	clear.setAttribute('class', 'cls');

        	var label = document.createElement('label');
        	label.innerHTML = "New Name:";

        	var input = document.createElement('input');
        	input.setAttribute('type', 'text');
        	input.setAttribute('id', 'txtNewName');
		input.setAttribute('size','18');

        	parent.appendChild(clear);
        	parent.appendChild(label);
        	parent.appendChild(input);
	}

	document.getElementById("account").value = 0;
    	document.getElementById("txtCreditBalance").value = "";
	document.getElementById("txtCreditBalance").readOnly = false;
    	document.getElementById("txtMasks").value = "";
}

function LoadAccountDetails(){
	
	document.getElementById("txtCreditBalance").value = "";
	document.getElementById("txtCreditBalance").readOnly = true;
	document.getElementById("txtMasks").value = "";
	
	if($('#account').val()>0){
		$.ajax({		
				type: "POST",
				url: "<?php echo $ROOTURL ?>" + "forms/ajaxGetAccountDetails.php",
				data: {accountID:$('#account').val()},
				success: function(value){
					if(value!="0")
					{						
						var arr = value.split(";");
						if (arr[0])
							document.getElementById("txtCreditBalance").value = arr[0];	
								
						if(arr[1]){
							var masksArr = arr[1].split(",");									
							for(var iter = 0; iter<masksArr.length; iter++)
								document.getElementById("txtMasks").value += masksArr[iter].trim() + '\n';
						}
						if(arr[2]) document.getElementById("status").value = arr[2]; 
					}
					else
						alert("No data found in the table");
				},
				error: function(value) {
					alert(value);
				}
		});
	}
}

function AddOrUpdateAccount(){

	var accountid = document.getElementById("account").value;
	var accountStatus = document.getElementById("status").value;
	var newAccountName = ".";
	if(accountid==0){
		newAccountName = $('#txtNewName').val();
		if(newAccountName.length <= 0){alert("Please enter a valid account name and then try again.");return;}
	}
		
	var creditBalance = parseInt($('#txtCreditBalance').val());
	if(!isPositiveInteger(creditBalance)) {alert("Please enter a positive balance amount and then try again."); return;}
					
	var arr = $('#txtMasks').val().trim().split('\n');
	if(arr.length > CONST_MAX_MASK_COUNT){alert("An account can't have more than " + CONST_MAX_MASK_COUNT + " masks."); return;}
	var masks;
	if(arr[0].length <= CONST_MAX_MASK_LENGTH){ 
		if (arr[0].indexOf(' ') >= 0){alert("Whitespace is not allowed inside mask"); return;}
		else masks = arr[0];
		for(var i=1; i<arr.length; i++){
			if(arr[i].length <= CONST_MAX_MASK_LENGTH){
				if (arr[i].indexOf(' ') >= 0){alert("Whitespace is not allowed inside mask"); return;}
				else masks = masks + "," + arr[i].trim();
			}
			else{
				alert("Mask exceeded maximum length");
				return;
			}	
		}
		$.ajax({		
			type: "POST",
			url: "<?php echo $ROOTURL ?>" + "forms/ajaxAddUpdateAccount.php",
			data: {accountID:accountid, accountName:newAccountName, mask:masks, balance:creditBalance, status:accountStatus },
			async: false,
			success: function(value){
				alert(value);
				location.reload(true);
			},
			error: function(value) {
				alert("Error occurred");
			}
		});
	}
	else{
		alert("Mask exceeded maximum length");
		return;
	}
}

</script>
