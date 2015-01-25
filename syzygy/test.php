<?php  
$userid = $_POST['userid'];echo $userid;
$path = "importedfiles/user".$userid."/";echo $path;
if(!is_dir($path)) mkdir($path, 0777); 

$fileName = $path."user".$userid.".txt";
$content = $_POST['txtContactList']; echo $content;
$fp = fopen($fileName, 'w') or die("can't open file"); 
fwrite($fp,$content);
fclose($fp);

?>