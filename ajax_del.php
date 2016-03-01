<?php
//引入公共文件
require 'includes/common.inc.php';

$_articleid = $_POST['articleid'];
$_userid = $_POST['userid'];

if($_articleid){
	_query("DELETE FROM bamboo WHERE id='{$_articleid}'");
	_query("UPDATE user SET bamboo_num=bamboo_num-1 WHERE id='{$_userid}'");
	echo 1;
} else {
	echo 0;
}
?>