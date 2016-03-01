<?php
//引入公共文件
require 'includes/common.inc.php';

$_newid = $_POST['newid'];

$_state = _query("DELETE FROM contact WHERE id='{$_newid}'");
if($_state){
	echo 1;
} else {
	echo 0;
}
?>