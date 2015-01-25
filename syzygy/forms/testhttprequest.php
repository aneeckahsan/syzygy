
<?php
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
);

$context = stream_context_create($opts);

/* Sends an http request to www.example.com
   with additional headers shown above */
$fp = fopen('http://api.silverstreet.com/send.php?username=ssdhq&password=q01J2GAW&destination=8801911700341&sender=mohsin&body=This is%20a%test%20message%20for%20smsportal', 'r', false, $context);
//fpassthru($fp);
 $response = stream_get_contents($fp);
echo $response;
fclose($fp);
?>
