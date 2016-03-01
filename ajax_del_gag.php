<?php
//引入公共文件
require 'includes/common.inc.php';

$_userid = $_POST['userid'];

if($_userid){
	_query("UPDATE user SET gag=1 WHERE id='{$_userid}'");
	echo 1;
} else {
	echo 0;
}
?>