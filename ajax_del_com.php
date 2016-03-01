<?php
//引入公共文件
require 'includes/common.inc.php';

$_commentid = $_POST['commentid'];
$_userid = $_POST['userid'];
$_bambooid = $_POST['bambooid'];

$_state = _query("DELETE FROM comment WHERE id='{$_commentid}'");
if($_state){
	//在user表中减少一个评论量
	_query("UPDATE user SET comment_num=comment_num-1 WHERE id='{$_userid}'");
	//在bamboo表中减少一个评论量
	_query("UPDATE bamboo SET comment=comment-1 WHERE id='{$_bambooid}'");
	echo 1;
} else {
	echo 0;
}
?>