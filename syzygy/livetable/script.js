var url = document.URL;
var formPage = url.substring(url.lastIndexOf("/")+1)+"?";
var CONST_TEXT_MAXLENGTH = 90;

$(document).ready(function() {
    load('action=ajax&page=1'); //Load by default first page on load
});

$(document).on('click','.pagin a', function(){
	load('action=ajax&page='+$(this).attr('id')); //Load data when click on pagination
})
$(document).on('click','#summary_button', function(){
	$("#summary").toggle( "slow" );
  $("#details").toggle( "slow" );
  if ($(this).val() == "Summary Report") {
      $(this).val("Details Report");
  }
  else {
      $(this).val("Summary Report");
  }
})
function load(str) {
    $("#loader").fadeIn('slow');
    $('#data').load(formPage + str, function() {
         //$("#summary").hide();
        $("#loader").fadeOut('slow');
    });
}

//Select All with checkbox functionality
$(document).on('click','input:checkbox',function(e) {
	if($(this).hasClass('selall')) {
		$('.selrow').prop({checked:$(this).is(':checked')});
	} else {
		if($('.selrow:checked').length == $('.selrow').length) {
			$('.selall').prop({checked:true})
		} else {
			$('.selall').prop({checked:false})
		}
	}
})

//Functionality for insert
$(document).on('click', '.addnew', function(e) {
	//var tblID = $(this).next("table").attr("class");
	var tblclass = $("table").attr("class");
	//alert(tblclass);
	if(tblclass === 'rules'){
		//$( "#data" ).load( "signup_template.html" );
		window.location = "http://192.168.5.143/callfilter/index.php?FORM=forms/frmRules.php";
		return;
	}
    var trBackColor, trPKColName;
    var tdString = "";

    //Get the last row
    var lastRow = $("table tbody tr:last-child");

    // Select alternate background color for the new row
    if (hexc(lastRow.css("background-color")) == '#ECEEF4')
        trBackColor = '#FFFFFF';
    else
        trBackColor = '#ECEEF4';

    // Get the class names of each span element of the last row
    var spanSelector = $("table tbody tr:last-child span");
    if (spanSelector.length > 0) {
        for (var i = 0; i < spanSelector.length; i++) 
            //tdString += '<td class="'+spanSelector[i].parent().attr('class')+'"><span class="' + spanSelector[i].getAttribute('class') + '"></span></td>';
                  tdString += '<td class="'+spanSelector[i].parentNode.getAttribute('class')+'"><span class="' + spanSelector[i].getAttribute('class') + '"></span></td>';

        // Get primary key column name
        trPKColName = $("table tbody tr td").find('input:hidden').attr('name')
    }
    else {

        // Get primary key column name
        trPKColName = $("table thead tr th:first").attr('name');
        $("table thead tr th").each(function() {//alert($(this).attr('class'));
			
				var name = $(this).attr('name');
				if (name && (name != trPKColName)) {
					if($(this).attr('class') === "editable"){
						tdString += '<td class="editable"><span class="' + name + '"></span></td>';
					}
					else{
						tdString += '<td><span class="' + name + '"></span></td>';
					}
				}
        })
    }

    // HTML code string for the new row
    var newrow = '<tr style="background:' + trBackColor + '">' +
    '<td><input type="checkbox" class="selrow" value="0"/><input type="hidden" value="" name="' + trPKColName + '" /></td>' +
    tdString + '<td align="center">' +
    '<img src="livetable/edit.png" class="updrow" title="Insert"/>&nbsp;<img src="livetable/delete.png" class="delrow" title="Delete"/>' +
    '</td></tr>';
    $('tbody').after(newrow);
});

//Functionality for single or multiple delete
$(document).on('click', '.delall,.delrow', function(e) {
    var id;
    if ($(this).hasClass('delall')) {
        e.preventDefault();
        id = $('.selrow:checked').map(function() {
            return $(this).val();
        }).get();
    } else {
        id = $(this).parents('tr').find('input:hidden').val();
    }
    if ($('.selrow:checked').length == 0 && $(this).hasClass('delall')) {
        alert('Please select atleast one row');
    } else if (confirm('Do you really want to delete?')) {
        load('action=delete&page=1&id=' + id);
    }
    e.stopImmediatePropagation();
});

//Save updated data in database
function savedata() {
	
	if($('.modified').length > 0) {
		$('.modified').each(function(e) {
	       	$tr = $(this);
	        	$tr.find('input:text').hide();
	        	if ($tr.find(':input').val() == '0') 
	        		$.post(formPage + $tr.find(':input').serialize() + '&action=insert', function() { });	        	
	        	else 
	            		$.post(formPage + $tr.find(':input').serialize() + '&action=update', function() { });
	        	
	        	$tr.find('span').show(function() {
	        		$(this).text($(this).next('input').val()).next('input').remove();
	        	});
	        	$tr.css('background-color', '#F5E6DA').removeClass('modified').find('img').show();
		});
	}
	//load('action=ajax&page=1');
}

//Save data when click anywhere on page body
$(document).on('click','html',function(e){
	if(! $(e.target).is(':input')) {
		savedata();
	}
	e.stopImmediatePropagation();
});

//Show input boxes in row when click on update icon
$(document).on('click','.updrow',function(e){
	$(this).hide();
	$tr = $(this).parents('tr');
	$tr.addClass('modified');
	
	var tblclass = $("table").attr("class");
	var id = $tr.find('input:checkbox:first').val();
	if(tblclass === 'rules'){
		//alert(id);
		window.location = "http://192.168.5.143/callfilter/index.php?FORM=forms/frmRules.php&mode=edit&id="+id;
		return;
	}
	
	
	$tr.css('background-color','#686C70');
	$tr.find('span').each(function(){
		if($(this).parent().hasClass("editable")){
			$(this).hide(function(){
				$(this).after('<input name="'+$(this).attr('class')+'" value="'+$(this).text()+'" maxlength="'+ CONST_TEXT_MAXLENGTH +'"/>');
			});
		}
	});
	e.stopImmediatePropagation();
});

//RGB to HEX converter for background color
function hexc(colorval) {
    if (colorval) {
        var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        delete (parts[0]);
        for (var i = 1; i <= 3; ++i) {
            parts[i] = parseInt(parts[i]).toString(16).toUpperCase();
            if (parts[i].length == 1) parts[i] = '0' + parts[i];
        }
        return '#' + parts.join('');
    }
    else
        return '#ECEEF4';
}
