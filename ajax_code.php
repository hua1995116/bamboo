<?php
session_start();
$_code = strtolower($_POST['code']);
$_scode = strtolower($_SESSION['code']);
if($_code == $_scode){
	echo 1;
	}

?>