<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Balance Check</title>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>

	<body></body>
</html>
<script type="text/javascript">
$(function() {
            
	$.ajax({
                type:'GET',
                dataType:'jsonp',
                jsonp:'jsonp',
                //url:'http://api.stackoverflow.com/1.0/tags/',
		  url:'http://api.silverstreet.com/creditcheck.php?username=ssdhq&password=q01J2GAW',
                success:function(data) {
                    /*$.each(data["tags"],function(index, item) {
                        var tag = item.name;
                        var count = item.count;
                        $("body").append('<div class="stackoverflow"> The Tag<span class="q-tag">'+ tag +'</span> has <span class="q-count">'+ count +'</span> Questions.</div>')
                    });*/
                },
                error:function() {
                    alert("Sorry, I can't get the feed");  
                }
            });
        });
</script>