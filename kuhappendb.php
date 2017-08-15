<?php

$server = 'localhost';
$username = 'root';
$password = '';
$db = 'kuhappen';

/*mysql_connect($server,$username,$password);
mysql_select_db($db);*/
$connection = new PDO ("mysql:host=$server;dbname=$db", $username, $password);
if (!$connection){
	die('Not connected');
}

/*if (!mysql_connect($server, $username,$password) || !mysql_select_db($db)){
	die('You are not connected to server or database');
}else{
	$connection = new PDO ("mysql:host=$server;dbname=$db", $username, $password);
}*/
?>