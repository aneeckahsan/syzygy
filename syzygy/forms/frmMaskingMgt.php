
<form>

<div id="createMask">
	<div id="addNew">
		<input type="button" value="Edit Existing Masks" onclick="openWin();"/>
		<input type="button" value="Add New Mask" onclick="addRow('dataTable');"/>
	</div>	
</div>
<table id="dataTable">
<tr style="visibility:hidden;"><td><label>New Mask Name</label><input type="test" name="mask[]" value=""/ ></td>
</tr>

</table>
<br>
<input type="button" name="submit" id="submit" value="submit" onclick="submitOP();">
</form>
<script>
function openWin()
{
var myWindow = window.open("<?php echo $ROOTURL;?>"+"livetable/index.php?targetid=users","","width=900,height=700");
}
function submitOP(){
	var masks = document.forms[0].elements["mask[]"];
	var mask = new Array();
	for (var i = 0, len = masks.length; i < len; i++) {
		mask[i] = masks[i].value;
		//alert(mask[i]);
	}
	//alert(mask);
	var jsonString = JSON.stringify(mask);
	//alert(jsonString);
	$.ajax({
			
            type: "POST",
            url: "<?php echo $ROOTURL ?>" + "forms/ajaxMaskingMgt.php",
            data: {data:jsonString},
            success: function(value){

                if(value=="1")
                {
					alert('successfully inserted');
                    
					//$("#msg").empty();
                    //$("#msg").html( " Successfully Updated" );
                }
                else
			    {
					alert("Insertion Failed");
                    //$("#msg").empty();
                    //$("#msg").html( " Successfully Failed" );
                }
            },
			 error: function(value) {
				alert("Ajax Error");
				//$("#msg").html( " Error occured " );
			 }
        });
}
function addNew(){
	var parent = document.getElementById("addNew");
	var numberofchildren = parent.childNodes.length;
	//alert(numberofchildren);
	if(numberofchildren <=49){
		var clear = document.createElement('div');
		clear.setAttribute('class','cls');
		
		var label = document.createElement('label');
		label.innerHTML = "Mask Name:";
		
		var input = document.createElement('input');
		input.setAttribute('type','text');	
		input.setAttribute('id','txtNewContactGroupName');
		
		parent.appendChild(clear);
		parent.appendChild(label);
		parent.appendChild(input);
	}
}
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
			//alert(rowCount);
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
 
</script>