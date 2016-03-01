<?php
//引入公共文件
require 'includes/common.inc.php';

$_collectid = $_POST['collectid'];
$_userid = $_POST['userid'];
$_bambooid = $_POST['bambooid'];

$_state = _query("DELETE FROM collect WHERE id='{$_collectid}'");
if($_state){
	//在user表中减少一个收藏量
	_query("UPDATE user SET collect_num=collect_num-1 WHERE id='{$_userid}'");
	//在article表中减少一个收藏量
	_query("UPDATE bamboo SET collect=collect-1 WHERE id='{$_bambooid}'");
	echo 1;
} else {
	echo 0;
}
?>