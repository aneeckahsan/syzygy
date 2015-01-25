<?php
	$file = fopen('Book2.csv', 'rb');
    	$newfile = fopen('target.txt', 'wb');
    	while(($line = fgets($file)) !== false) {
            fputs($newfile, $line);
    	}
    	fclose($newfile);
    	fclose($file);
?>