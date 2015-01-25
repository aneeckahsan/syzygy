//Configurations
var ROOTURL = "http://localhost/syzygy/";
var amount = 0.0;
if(!String.prototype.startsWith){
    String.prototype.startsWith = function (str) {
        return !this.indexOf(str);
    }
}

function readSingleFile(evt){
	var f = evt.target.files; 
	var lastindex = f.length - 1;
	var f = evt.target.files[lastindex];
    	if (f){
		var r = new FileReader();
        	r.onload = function(e){document.getElementById("txtContactList").innerHTML = e.target.result;}
			r.readAsText(f);
    	}
	else
		alert("Failed to load file");
}

function charCount() {
    var length = document.getElementById("txtMsg").value.length;
    var smsCount = 0;
    if (document.getElementById("txtMsg").value == null) {
        document.getElementById("SMSCharCount").innerHTML = "";
        smsCount = 0;
    }
    else if (length <= 640) {
        smsCount = parseInt(length / 160);
        var text = (length) + " (" + smsCount + "/4)";
        if (length == 640)
            text += "SMS length reached limit !!!";
        document.getElementById("SMSCharCount").innerHTML = text;
    }
    else { }
}
function loadTemplates(){
var sel = document.getElementById("templateoptions").selectedIndex;
	document.getElementById("txtMsg").value+=document.getElementById("templateoptions").options[sel].text;
}
function addNew() {
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

        parent.appendChild(clear);
        parent.appendChild(label);
        parent.appendChild(input);
    }
}

function ajaxInsertUpdateDelete(sqlquery) {

    var success = 0;
    $.ajax({
        type: "POST",
        url: ROOTURL + "forms/ajaxInsertUpdateDelete.php",
        data: { query: sqlquery },
	 async:false,
        success: function(value) {
            if (value == "1") {
                alert("Operation Successful");
				success = 1;
            }
            else {
                alert("Operation failed. Error Reason: "+value);
                success = 0;
            }
        },
        error: function(value) {
            alert('Error occurred: ' + value);
        }
    });
    return success;
}
function ValidateEmail(n) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (n.match(mailformat)) return true;
    else return false; 
}

function isValidDestNo(mblno){
	if(mblno.length == 13){
		for(var j=0; j<prefix.length; j++)
			if(mblno.startsWith(prefix[j]))
				return true;
		return false;
	}
	return false;
}
function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function isPositiveInteger(val) {
    return val == "0" || ((val | 0) > 0 && val % 1 == 0);
}

function test(n){
	if(isNumeric(n)) alert('true');
}
function getPrefix(){
	$.ajax({  
		type: "POST",
		url: ROOTURL + "forms/ajaxGetSMSRate.php",
		data: {},
		success: function(value){
			if(value){
				var arrRate = value.split(";");
				var prefixCount = arrRate.length;
		     
				for(var i=0; i<arrRate.length; i++){
					if(arrRate[i]){
						var arr2 = arrRate[i].split(",");
						prefix.push(arr2[1].trim());
					}
				}
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


function getcurrentbalanceanddeduct(ROOTURL,accountid,userid,recipientList){

	var recipientList = recipientList; 
	$.ajax({  
		type: "POST",
		url: ROOTURL + "forms/ajaxGetSMSRate.php",
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
				for(var i=0; i<arr.length; i++){
					for(var j=0; j<prefix.length; j++){
						if(arr[i].startsWith(prefix[j])) counter[j]++;
					}
				}
				var total = 0;
				var amount = 0.0;
				for(var i=0; i<counter.length-1; i++){
					total += counter[i];
					amount=amount+parseFloat((charge[i]*counter [i]).toFixed(2));
				}
            }
			$.ajax({		
				type: "POST",
				url: ROOTURL  + "forms/ajaxGetAccountDetails.php",
				data: {accountID:accountid},
				async: false,
				success: function(value){
					if(value!="0"){						
						var arr = value.split(";");
						var str = "Current Balance:"+ arr[0] + "\nCharged Amount:"+ amount + "\n";
						if((arr[0] - amount) >= 0 ){
							str = str + "Do you want to proceed?";
							if(confirm(str)){				
								if(sendbulksms(userid) == 1){
									$.ajax({		
										type: "POST",
										url: ROOTURL  + "forms/deductbalance.php",
										data: {balance:amount,accountID:accountid},
										async: false,
										success: function(value){
											if(value=="1"){											
												$.ajax({		
													type: "POST",
													url: ROOTURL  + "forms/ajaxGetAccountDetails.php",
													data: {accountID:accountid},
													async: false,
													success: function(value){													
														if(value!="0"){																		
															var arr = value.split(";");
															alert("After deduction current balance is: " + arr[0]);
														}
													}
												});
											}											
												
										}					
									});
								}								
							} 
						}
						else alert(str + "Charged amount exceeds current balance");												
					}
					else alert("No data found in the table");						
				},
				error: function(value) {
					alert(value);
				}
			});			
		},
		error: function(value){
			alert("ERROR: "+value);
		}
	});
}
function sendbulksms(userid){
	$("#loader").fadeIn('slow');
	var success = 0;
	$.ajax({
        type: "POST",
        url: ROOTURL + "forms/ajaxBulkSms.php",
	    data: {nosajax:finalListnos,msg:$('#txtMsg').val(),mask: $('#maskingOptions').val(),userid:userid},
	    async: false,
		success: function(value){
			$("#loader").fadeOut('slow');
			if(value == '01'){
				success = 1;
				alert('Sms has been sent successfully');
			}
			else alert('Sms sending failed');
        },
		error: function(value) {
			$("#loader").fadeOut('slow');
			alert('Internal error occured');
		}
    });
	return success;
}
function selectallcheckedorunchecked(){
	$('#getphonenumberbygrouplist input[type="checkbox"]').not(':first').each(function(){
		$(this).click(function(){
			var a = $('#getphonenumberbygrouplist input[type="checkbox"]').not(':first');
			if(a.length == a.filter(":checked").length) $('#getphonenumberbygrouplist input[type="checkbox"]').first().prop('checked', true );
    		else $('#getphonenumberbygrouplist input[type="checkbox"]').first().prop('checked', false );  				
		});
	});
}
function jpage(sourceid){
	$("div.holder").jPages("destroy").jPages({
		containerID: sourceid,
		perPage: 7,
		keyBrowse: true,
		scrollBrowse: true,
		callback: function (pages,items) {
			$("#legend1").html("Page " + pages.current + " of " +  pages.count);
			$("#legend2").html("Elements "+items.range.start + " - " +  items.range.end + " of " + items.count);
		}
	});
}

function ajaxInsertUpdateDeleteFromContactGroup(sqlquery) {

    var success = 0;
    $.ajax({
        type: "POST",
        url: ROOTURL + "forms/ajaxInsertUpdateDelete.php",
        data: { query: sqlquery },
		async:false,
        success: function(value) {
            if (value == "1") success = 1;           
            else {
                alert("Operation failed. Error Reason: "+value);
                success = 0;
            }
        },
        error: function(value) {
            alert('Error occurred: ' + value);
        }
    });
    return success;
}
function submitfile(userid){
	$("#loader").fadeIn('slow');
	$.ajax({		
		type: "POST",
		url: ROOTURL + "test.php",
		data: {txtContactList:$('#txtContactList').val(),userid:userid},
		async:false,
		success: function(value){},
		error: function(value) {alert("Error occurred: "+value);}
	});
	$("#loader").fadeOut('slow'); 
}
function showLoader(){
	//$("#loader").fadeIn('slow');
	$("body").addClass("loading");
}
function hideLoader(){
	//$("#loader").fadeOut('slow');
	 $("body").removeClass("loading");
}
