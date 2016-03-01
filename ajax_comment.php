<?php
//引入公共文件
require 'includes/common.inc.php';

$_userid = $_POST['userid'];
$_bambooid = $_POST['bambooid'];
$_content= $_POST['content'];

if($_userid && $_bambooid && $_content) {
	$_state = _query("INSERT INTO comment (userid,bambooid,comment,time) VALUES ($_userid,$_bambooid,'$_content',NOW())");
	if($_state){
		//在user表中增加一个评论量
		_query("UPDATE user SET comment_num=comment_num+1 WHERE id='{$_userid}'");
		//在bamboo表中增加一个评论量
		_query("UPDATE bamboo SET comment=comment+1 WHERE id='{$_bambooid}'");
		$rs_comment = _query("SELECT * FROM comment WHERE bambooid='{$_bambooid}' ORDER BY time DESC");
		$comment_i = (_num_rows($rs_comment));
		//提取评论时间
		$rows_last_time = _fetch_array("SELECT * FROM comment WHERE comment='{$_content}' LIMIT 1");
		$html_last_time = array();
		$html_last_time['time'] = $rows_last_time['time'];
		//评论用户
		$rows_c_a_a = _fetch_array("SELECT * FROM user WHERE id='{$_userid}' LIMIT 1");
		//提取发表评论用户的信息
		$html_c_a_a = array();
		$html_c_a_a['id'] = $rows_c_a_a['id'];
		$html_c_a_a['face'] = $rows_c_a_a['face'];
		$html_c_a_a['username'] = $rows_c_a_a['username'];
		echo '
		<div class="comment_floor">
			<a href="user.php?id='.$html_c_a_a['id'].'"><img src="'.$html_c_a_a['face'].'" alt="face" /></a>
			<a href="user.php?id='.$html_c_a_a['id'].'"><div class="comment_a">'.$html_c_a_a['username'].'</div></a>
			<div class="comment_t">'.$html_last_time['time'].'</div>';
			if($comment_i == 1){
				echo '
				<div class="comment_n">沙发</div>';
			} else{
				echo '
				<div class="comment_n">'.$comment_i.'楼</div>';
			}
			echo '<div class="comment_c">'.$_content.'</div>';
		echo '</div>';
	}
}

?>