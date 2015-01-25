<?php

//connect to the database
mysql_connect('127.0.0.1', 'root', 'nopass') or die("I couldn't connect to your database, please make sure your info is correct!");
mysql_select_db('smsportal') or die("I couldn't find the database table make sure it's spelt right!");
