<style type="text/css">
div.scrollable {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}
</style>	
		<div>
			<table style="height:200px;" width="100%" border="1">
				<tr>
					<td width="60%">
						<div id="tabs">
							<ul>
								<li><a href="#tab1">Manual Input</a></li>
								<li><a href="#tab2">Import from file</a></li>
								<li><a href="#tab3">Contact Group</a></li>
							</ul>
		
							<div id="tab1" style="height:200px;">
								<div class="cls"></div>
								<textarea id="txtManualInputContactList" cols="30" rows="5"></textarea>
							</div>

							<div id="tab2" style="height:200px;">
								<div class="cls"></div>
								<input type="file" id="fileinput" name="files[]" multiple/>
								<div class="cls"></div>
								<textarea name="txtContactList" id="txtContactList" cols="30" rows="5"></textarea>
							</div>				
						
							<div id="tab3" style="height:250px; overflow: auto;">
								<table border="1">
									<tr>
										<td><input type="text" name="searchgroupinput" id="searchgroupinput" value = "Group Name" onblur="if(this.value == '') { this.value='Group Name'}" onfocus="if (this.value == 'Group Name') {this.value=''}"><br></td>
										<td><input type="text" name="searchphoneinput" id="searchphoneinput" value = "Phone Number" onblur="if(this.value == '') { this.value='Phone Number'}" onfocus="if (this.value == 'Phone Number') {this.value=''}">
									</tr>
									<tr>
										<td>
											<div id="searchholder" class="scrollable">
												<?php								
												$qry ="select * from smsportal.group where userid = '$LoggedInUserID'";
												$rs = mysql_query($qry,$cn);
												echo "<ul>";
												while($row=mysql_fetch_array($rs)) {
													$groupname=$row["groupname"];$groupid=$row["groupid"];
													echo "<li>$groupname</li>";																		
												}
												echo "</ul>";
												?>	
											</div>
										</td>
										<td>
											<div id="searchholder1" class="scrollable">
												<ul id="getphonenumberbygrouplist"><li id=""><input id="checkall1" type="checkbox" value=""/>Select all</li></ul>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>	
					</td>

					<td width="7%" style="vertical-align:middle; padding-left:50px;">
						<input type="button" class="sbtn" value="Add" onclick="clickonaddbutton();"/>
					</td>
					
					<td width="40%" style="padding-left:50px;">
						<table>
							<tr>
								<td>
									<ul>
										<div style="padding-left: 10px;">
											<li>
												<label style="width:76px;">Search no:</label>
												<input type="text" name="searchinfinallist" id="searchinfinallist" style="width:120px;">
												<div class="cls"></div>
												<input type="button" value="Remove All" onclick="removeall();"/>
												<input type="button" value="Remove Selected" onclick='removeselectedrows(2);'/>
											</li>
										</div>
									</ul>
								</td>
							</tr>
							<tr>
								<td>
									<ul id="searchfromfinallist"></ul>
									<div class="holder" style="padding-left: 30px;"></div>
								</td>
							</tr>	
						</table>
					</td>
				</tr>	
			</table>	
		</div>
		<div id="test"></div><br></br>
		<div class="cls"></div>

<script type="text/javascript">

var prefix=[];
var finalListnames = {};
var finalListemails = {};
var finalListnos = {};
var finalListids = {};
var finalListid = 0;
var nos=[], names=[],emails=[];
var x = 0;

document.getElementById('fileinput').addEventListener('change', readSingleFile, false);

$('#checkall1').click(function(){
	$(this).closest('ul').find('> li > input[type=checkbox]').not(':first').not(':hidden').prop('checked', this.checked);
});

$( "#searchphoneinput" ).keyup(function( event ) {
	var input = $(this).val().toLowerCase(); 
	searchfromgetphonenumberbygrouplist(input);
});

$( "#searchinfinallist" ).keyup(function( event ) {
	searchfromfinallist();
	jpage("searchfromfinallist");
});

function destroyfinallist(){
	$("#searchfromfinallist").children('ul').remove();
	jpage("searchfromfinallist");
	finalListids={};
	finalListnos={};
	finalListnames={};
	finalListemails={};
	finalListid=0;
}

$( "#searchholder ul li" ).on( "click", function() {
	$("#loader").fadeIn('slow');
	$('#getphonenumberbygrouplist input[type="checkbox"]').first().prop('checked', false );
	var input = $.trim($( this ).text()).toLowerCase(); 
	$("#getphonenumberbygrouplist").children('li').not(':first').remove();
	$("#getphonenumberbygrouplist").show();
	getphonenumberbygroup(input);
	selectallcheckedorunchecked();
});

$('#searchgroupinput').keypress(function(event){	
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		$("#loader").fadeIn('slow');
		$('#getphonenumberbygrouplist input[type="checkbox"]').first().prop('checked', false );
		var input = $(this).val().toLowerCase(); 
		$("#getphonenumberbygrouplist").children('li').not(':first').remove();
		$("#getphonenumberbygrouplist").show();
		getphonenumberbygroup(input);
		selectallcheckedorunchecked();		
	}	
});

function fetchselectedgroupnumbers(input){
	showLoader();
	$.ajax({
       	type: "POST",
       	url: "<?php echo $ROOTURL ?>" + "forms/getphonenumberbygroup.php",
              data: {groupname:input,userid:"<?php echo $LoggedInUserID;?>"},
              success: function(data){
			var VariableArray = data.split('&');
			for(var i = 0; i < VariableArray.length-1; i++){
				var KeyValuePair = VariableArray[i].split(',');
				finalListids[KeyValuePair[1]] = finalListid;
				finalListnos[KeyValuePair[1]] = 1;
				finalListnames[KeyValuePair[1]] = KeyValuePair[2];
				finalListemails[KeyValuePair[1]] = KeyValuePair[3];
				finalListid++;							
			}
			hideLoader();
			searchfromfinallist();
			jpage("searchfromfinallist");
		},
	       error: function(data) {
			$("#loader").fadeOut('slow');				
		}
	});
}

function searchfromgetphonenumberbygrouplist(input){
	$("#getphonenumberbygrouplist li").show();
	if(input){
		$('#getphonenumberbygrouplist input[type="checkbox"]').not(':first').map(function(i,n) {
			if($(n).attr('value').lastIndexOf(input, 0) != 0)
				$(n).parent().hide();
		});
	}	
}		

$(document).ready(function() {
	getPrefix();
	$('#tabs').tabs({
       	cookie: { expires: 30 }
    	});

       $('.jquery').each(function() {
       	eval($(this).html());
    	});

       $('.button').button();
	initPagination("searchfromfinallist");
	searchfromfinallist();
});

function appendtofinallist(){
	var nosfrommanualandcsv = getnumbersfromstring();
	var checkedCheckboxes = $('#getphonenumberbygrouplist input[type="checkbox"]:checked').not('#checkall1');
	var groups = [];
	var invaliddestnos = '';
	var duplicatenos = '';
	document.getElementById("txtContactList").innerHTML = '';
	document.getElementById("txtManualInputContactList").value = '';
	for(var i=0, im=checkedCheckboxes.length; im>i; i++){
		if(checkedCheckboxes [i].value){
			if(!finalListnos[checkedCheckboxes[i].value]){
				if(isValidDestNo(checkedCheckboxes[i].value)){			
					finalListids[checkedCheckboxes[i].value] = finalListid;
					finalListnos[checkedCheckboxes[i].value] = 1;
					finalListnames[checkedCheckboxes[i].value] = checkedCheckboxes[i].id;
					finalListemails[checkedCheckboxes[i].value] = checkedCheckboxes[i].className;
					finalListid++;
				}
				else
					invaliddestnos += checkedCheckboxes[i].value + '\n';
			}
			else
				duplicatenos += checkedCheckboxes[i].value + '\n';
		}
	}
	for(var i = 0; i < nosfrommanualandcsv.length; i++){
		if(nosfrommanualandcsv[i]){
			if(!finalListnos[nosfrommanualandcsv[i]]){			
				if(isValidDestNo(nosfrommanualandcsv[i])){
					finalListnos[nosfrommanualandcsv[i]] = 1;
					finalListnames[nosfrommanualandcsv[i]] = names[i];
					finalListemails[nosfrommanualandcsv[i]] = emails[i];
					finalListids[nosfrommanualandcsv[i]] = finalListid;
					finalListid++;	
				}
				else
					invaliddestnos += nosfrommanualandcsv[i] + '\n';
			}
			else
				duplicatenos += nosfrommanualandcsv[i] + '\n';
		}
			
	}
	searchfromfinallist();
	jpage("searchfromfinallist");
	if(invaliddestnos) alert("Invalid Numbers:\n\n"+invaliddestnos);
	if(duplicatenos) alert("Duplicate Numbers:\n\n"+duplicatenos);
}

function clickonaddbutton(){
	showLoader();
	appendtofinallist();
	hideLoader();
}

function searchfromfinallist(){
	$("#searchfromfinallist").children('ul').remove();
	var searchinfinallist = $('#searchinfinallist').val();
	for (var i in finalListnos)
		if(finalListnos[i] && i.lastIndexOf(searchinfinallist, 0) === 0)
			$( "#searchfromfinallist" ).append( '<ul id="'+finalListids[i]+'"  class="'+finalListids[i]+'"><li style="padding-left: 40px;"><input type="checkbox" value="'+i+'"/>'+i+'</li></ul>' );
}

function initPagination(sourceid) {
	$("div.holder").jPages({
       	containerID: sourceid,
       	perPage: 7,
       	keyBrowse: true,
       	scrollBrowse: true,
       	animation: "bounceInUp",
       	callback: function (pages,items) {
       		$("#legend1").html("Page " + pages.current + " of " + pages.count);
       	       $("#legend2").html("Elements "+items.range.start + " - " + items.range.end + " of " + items.count);
        	}
	});
}

function removeall(){
	destroyfinallist();
}

function removeselectedrows(id){
	if(id == 1) var checkedCheckboxes = $('#finalList input[type="checkbox"]:checked');
	else var checkedCheckboxes = $('#searchfromfinallist input[type="checkbox"]:checked');
	var groups = [];
	for(var i=0, im=checkedCheckboxes.length; im>i; i++){
		if(checkedCheckboxes[i].value){
			var cls = checkedCheckboxes[i].parentNode.parentNode.className;
			cls='.'+cls;
			$(cls).remove();
			var numbertoberemoved = checkedCheckboxes[i].value;
			finalListnos[numbertoberemoved]=undefined;
			finalListnames[numbertoberemoved]=undefined;
			finalListemails[numbertoberemoved]=undefined;			
		}
	}
	jpage("searchfromfinallist");
}

function submitselectedlist(){
	var index;
	var texts = [],finallistid = document.getElementById('finalList'), lis = finallistid.getElementsByTagName("li");
	for(var i=0, im=lis.length; im>i; i++)
		if(!(i%2)) texts.push(lis[i].firstChild.nodeValue);
	var jsonString = JSON.stringify(texts);	
}

function getnumbersfromstring(){
	nos.length = 0;names.length = 0;emails.length = 0,x = 0;
	var SearchString = document.getElementById("txtManualInputContactList").value;
	if(SearchString){
		var VariableArray = SearchString.split('\n');
		for(var i = 0; i < VariableArray.length; i++){
			var KeyValuePair = VariableArray[i].split(',');
			for(var j = 0; j < KeyValuePair.length; j++){
				if(isNumeric(KeyValuePair[j])) {nos.push(KeyValuePair[j]);}
				else if(ValidateEmail(KeyValuePair[j])){ emails.push(KeyValuePair[j]);}
				else names.push(KeyValuePair[j]);
			}
			if(!nos[x]) nos.push('');
			if(!names[x]) names.push('');
			if(!emails[x]) emails.push('');
			x++;
		}
	}
	
	var SearchString = document.getElementById("txtContactList").value;
	if(SearchString){
		var VariableArray = SearchString.split('\n');
		for(var i = 0; i < VariableArray.length; i++){
			var KeyValuePair = VariableArray[i].split(',');
			for(var j = 0; j < KeyValuePair.length; j++){
				if(isNumeric(KeyValuePair[j])) {nos.push(KeyValuePair[j]);}
				else if(ValidateEmail(KeyValuePair[j])){ emails.push(KeyValuePair[j]);}
				else names.push(KeyValuePair[j]);
			}
			if(!nos[x]) nos.push('');
			if(!names[x]) names.push('');
			if(!emails[x]) emails.push('');
			x++;
		}
	}
	return nos;
}

function isNumeric(n) { return !isNaN(parseFloat(n)) && isFinite(n);}

function ValidateEmail(n){
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(n.match(mailformat)) return true;
	else return false;	
}

function getphonenumberbygroup(input){
	$.ajax({
		type: "POST",
              url: "<?php echo $ROOTURL ?>" + "forms/getphonenumberbygroup.php",
              data: {groupname:input,userid:"<?php echo $LoggedInUserID;?>"},
	       async:false,
              success: function(data){
			var VariableArray = data.split('&');
			for(var i = 0; i < VariableArray.length-1; i++){
				var KeyValuePair = VariableArray[i].split(',');
				$( "#getphonenumberbygrouplist" ).append( '<li><input id="'+KeyValuePair[2]+'" class="'+KeyValuePair[3]+'" type="checkbox" value="'+KeyValuePair[1]+'"/>'+KeyValuePair[1]+'</li>' );
			}
			$("#loader").fadeOut('slow');
				
		},
	       error: function(data) {
			$("#loader").fadeOut('slow');
		}
	});
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

</script>