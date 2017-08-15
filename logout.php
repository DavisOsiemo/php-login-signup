<?php
require 'kuhappendb.php';
ob_start();
session_start();

$referer = $_SERVER['HTTP_REFERER'];

session_destroy();
header('Location: '.$referer);
function Login(){
	if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
		return true;
	} else {
		return false;
	}
}
if (Login()){
	echo "ok";
}else{
	echo "not ok";
}
?>