<?php
//引入公共文件
require 'includes/common.inc.php';

$_friendid = $_POST['friendid'];
$_userid = $_POST['userid'];

$_state = _query("DELETE FROM friend WHERE id='{$_friendid}'");
if($_state){
	//在user表中减少一个好友量
	_query("UPDATE user SET friend_num=friend_num-1 WHERE id='{$_userid}'");
	echo 1;
} else {
	echo 0;
}
?>