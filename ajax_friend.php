<?php
//引入公共文件
require 'includes/common.inc.php';

$_userid = $_POST['userid'];
$_beuserid = $_POST['beuserid'];

if($_userid){
	//在user表中增加一个好友量
	_query("UPDATE user SET friend_num=friend_num+1 WHERE id='{$_userid}'");
	$_state = _query("INSERT INTO friend (userid,beuserid,time) VALUES ($_userid,$_beuserid,NOW())");
	echo 1;
} else {
	echo 0;
}
?>