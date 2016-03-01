<?
//引入公共文件
require 'includes/common.inc.php';

$page = isset($_GET['page'])?(int)$_GET['page']:0;
$num = isset($_GET['requestNum'])?(int)$_GET['requestNum']:3;
$startNum = $page*$num;
$rows = _query('SELECT * FROM bamboo WHERE type=1 && check_bamboo=1 ORDER BY modify_time DESC LIMIT '.$startNum.' , '.$num.'');
$data = array();
while ($row = _fetch_array_list($rows)){
	$data['id'] = $row['id'];
	$data['username'] = $row['username'];
	$data['img'] = $row['img'];
	$data['title'] = $row['title'];
	$data['collect'] = $row['collect'];
	$data['comment'] = $row['comment'];
	$data_user = _fetch_array("SELECT id FROM user WHERE username='{$data['username']}'");
	$data_userid = array();
	$data_userid['id'] = $data_user['id'];
	echo '
		<div class="pin">
			<div class="box">
				<a href="bamboo_detail.php?id='.$data['id'].'">'.$data['img'].'</a>
				<div class="note_area">
					<a href="bamboo_detail.php?id='.$data['id'].'"><div class="bamboo_title">'._title($data['title'],14).'</div></a>
					<div class="bamboo_author">发布人：<a href="user.php?id='.$data_userid['id'].'">'.$data['username'].'</a></div>
					<div class="bamboo_collect">'.$data['collect'].'人收藏<img src="images/ico/_collect.png" /></div>
					
					<div class="bamboo_comment"><img src="images/ico/_comment.png" />'.$data['comment'].'人评论</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>';
}
?>