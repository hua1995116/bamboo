<?
session_start();
define('SCRIPT','user_comment');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<?
	require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link href="styles/home_com.css" rel="stylesheet" type="text/css" />
	<link href="styles/user_comment.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/user_comment.js"></script>
	<script type="text/javascript" src="scripts/home_com.js"></script>
	<?
	if(isset($_GET['id'])){
		 $rows_user = _fetch_array("SELECT * FROM user WHERE id='{$_GET['id']}'");
		 
		 //获取用户信息
		 $html_user['username'] = $rows_user['username'];
		 $html_user['face'] = $rows_user['face'];
		 $html_user['qq'] = $rows_user['qq'];
		 $html_user['birthday'] = $rows_user['birthday'];
		 $html_user['email'] = $rows_user['email'];
		 $html_user['content'] = $rows_user['content'];
		 $html_user['comment_num'] = $rows_user['comment_num'];
	} else {
		_alert_back('error','非法操作！','index.php');
	}

	if(!!$_SESSION['username']){
			$rows_visit = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
			//获取浏览者信息
			$html_visit = array();
			$html_visit['id'] = $rows_visit['id'];
			//避免user.php和home.php冲突
			if($_GET['id'] == $html_visit['id']){
				echo '
					<script type="text/javascript">location.href="home.php"</script>
				';
			}
		}
	?>
	<title>衣恋-<? echo $html_user['username']; ?>的评论</title>
</head>
<body>

	<?
		require 'includes/head.php';
	?>
	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome"><a href="user.php?id=<? echo $_GET['id']; ?>">TA的主页</a></li>
                <li class="mybamboo"><a href="user_bamboo.php?id=<? echo $_GET['id']; ?>">TA的艺竹</a></li>
                <li class="mycomment h_select"><a href="user_comment.php?id=<? echo $_GET['id']; ?>">TA的评论</a></li>
                <li class="mycollect"><a href="user_collect.php?id=<? echo $_GET['id']; ?>">TA的收藏</a></li>
                <li class="myfriend"><a href="user_friend.php?id=<? echo $_GET['id']; ?>">TA的好友</a></li>
                <li class="mydata"><a href="user_data.php?id=<? echo $_GET['id']; ?>">TA的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<?
			require 'includes/member_left.inc.php';
		?>
		<div class="member_right">
			<div class="right_title"><? echo $html_user['username']; ?>的评论（共<? echo $html_user['comment_num'];?>个）</div>
            <?
			//获取用户对应的user ID
			$rows_author = _fetch_array("SELECT * FROM user WHERE username='{$html_user['username']}' LIMIT 1");
			$user_id = array();
			$user_id['id'] = $rows_author['id'];
			//分页
			global $_pagesize,$_pagenum;
			_page("SELECT * FROM comment WHERE userid='{$user_id['id']}' ORDER BY time DESC",5); 
			//获取用户评论数据
			$rs_comment = _query("SELECT * FROM comment WHERE userid='{$user_id['id']}' ORDER BY time DESC LIMIT $_pagenum,$_pagesize");
			if(_affected_rows($rs_bamboo_list) != 0){
				while($rows_comment = _fetch_array_list($rs_comment)){
					$html_c = array();
					$html_c['bambooid'] = $rows_comment['bambooid'];
					$html_c['comment'] = $rows_comment['comment'];
					$html_c['time'] = $rows_comment['time'];
					//获取评论文章的信息
					$rows_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_c['bambooid']}' LIMIT 1");
					$html_clo = array();
					$html_clo['username'] = $rows_bamboo['username'];
					$html_clo['img'] = $rows_bamboo['img'];
					$html_clo['type'] = $rows_bamboo['type'];
					$html_clo['title'] = $rows_bamboo['title'];
					echo '
						<div class="comment_list">
							<div class="_bamboo">
								<div class="comment_username">'.$html_clo['username'].'</div>
								<p>&nbsp;————&nbsp;</p>
								<div class="comment_title"><a href="bamboo_detail.php?id='.$html_c['bambooid'].'">'._title($html_clo['title'],20).'</a></div>
								<div class="comment_type">'._bamboo_type($html_clo['type']).'</div>
							</div>
							<input type="hidden" value="'.$html_clo['title'].'" />
							<a href="bamboo_detail.php?id='.$html_c['bambooid'].'" class="show_img_r">'.$html_clo['img'].'</a>
							<div class="_comment">
								<p>'.$html_user['username'].'在&nbsp;</p>
								<div class="comment_time">'._return_time($html_c['time']).'</div>
								<p>&nbsp;的评论：</p>
								<div class="comment_comment">'.$html_c['comment'].'</div>
							</div>
						</div>
					';
				}
				_paging_user(1);
			} else {
				echo '<img src="images/sad.png" class="sad_face" alt="" />';
				echo '<div class="no_comment">还未发表过评论！</div>';
			}
			?>
		</div>
	</div>
</body>
</html>