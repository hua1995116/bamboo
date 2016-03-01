<?php
//引入公共文件
require 'includes/common.inc.php';

$_name = $_POST['username'];
$_state = _is_repeat("SELECT username FROM user WHERE username= '$_name' LIMIT 1");
if($_state){
	echo 1;
}

?>