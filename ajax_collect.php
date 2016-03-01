<?php
//引入公共文件
require 'includes/common.inc.php';

$_uid = $_POST['uid'];
$_cid = $_POST['cid'];

if($_uid && $_cid) {
	$_state = _query("INSERT INTO collect (userid,bambooid,time) VALUES ($_uid,$_cid,NOW())");
	//在user表中增加一个收藏量
	_query("UPDATE user SET collect_num=collect_num+1 WHERE id='{$_uid}'");
	//在bamboo表中增加一个收藏量
	$_collection = _query("UPDATE bamboo SET collect=collect+1 WHERE id='{$_cid}'");
	if($_state && $_collection){
		echo 1;
	}
}

?>