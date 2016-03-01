<?
session_start();
define('SCRIPT','user_friend');
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
	<link href="styles/user_friend.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
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
	<title>衣恋-<? echo $html_user['username']; ?>的好友</title>
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
                <li class="mycomment"><a href="user_comment.php?id=<? echo $_GET['id']; ?>">TA的评论</a></li>
                <li class="mycollect"><a href="user_collect.php?id=<? echo $_GET['id']; ?>">TA的收藏</a></li>
                <li class="myfriend h_select"><a href="user_friend.php?id=<? echo $_GET['id']; ?>">TA的好友</a></li>
                <li class="mydata"><a href="user_data.php?id=<? echo $_GET['id']; ?>">TA的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<?
			require 'includes/member_left.inc.php';
		?>
		<div class="member_right">
			<div class="right_title"><? echo $html_user['username']; ?>的好友动态</div>
            <div class="myfriend_thing">
            	<ul>
				<?
                if(isset($_GET['id'])){
					//分页
					global $_pagesize,$_pagenum;
					_page("SELECT * FROM friend WHERE userid='{$_GET['id']}' ORDER BY time DESC",2);
                    //获取用户好友的id
                    $rs_friend = _query("SELECT * FROM friend WHERE userid='{$_GET['id']}' ORDER BY time DESC LIMIT $_pagenum,$_pagesize");
					if(_affected_rows($rs_friend) != 0){
						while($rows_friend = _fetch_array_list($rs_friend)){
							$html_friend = array();
							$html_friend['beuserid'] = $rows_friend['beuserid'];
							//获取好友的数据
							$rows_friend_thing = _fetch_array("SELECT * FROM user WHERE id='{$html_friend['beuserid']}' LIMIT 1");
							$html_friend_thing = array();
							$html_friend_thing['username'] = $rows_friend_thing['username'];
							$html_friend_thing['face'] = $rows_friend_thing['face'];
							//获取好友的成果
							$rows_friend_clo = _fetch_array("SELECT * FROM bamboo WHERE username='{$html_friend_thing['username']}' ORDER BY time DESC LIMIT 1");
							$html_friend_clo = array();
							$html_friend_clo['id'] = $rows_friend_clo['id'];
							$html_friend_clo['type'] = $rows_friend_clo['type'];
							$html_friend_clo['title'] = $rows_friend_clo['title'];
							//获取好友的评论
							$rows_friend_comment = _fetch_array("SELECT * FROM comment WHERE userid='{$html_friend['beuserid']}' ORDER BY time DESC LIMIT 1");
							$html_friend_comment = array();
							$html_friend_comment['comment'] = $rows_friend_comment['comment'];
							//获取好友的收藏
							$rows_friend_collect = _fetch_array("SELECT * FROM collect WHERE userid='{$html_friend['beuserid']}' ORDER BY time DESC LIMIT 1");
							$html_friend_collect = array();
							$html_friend_collect['bambooid'] = $rows_friend_collect['bambooid'];
							//获取收藏的文章信息
							$rows_friend_collect_clo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_friend_collect['bambooid']}' ORDER BY time DESC LIMIT 1");
							$html_friend_collect_clo = array();
							$html_friend_collect_clo['type'] = $rows_friend_collect_clo['type'];
							$html_friend_collect_clo['title'] = $rows_friend_collect_clo['title'];
							echo '
								<li class="friend_list">
									<a href="user.php?id='.$html_friend['beuserid'].'"><img class="friend_face_r" src="'.$html_friend_thing['face'].'" alt="face" /></a>
									<div class="friend_thing_msg">
										<div class="friend_name_r">'.$html_friend_thing['username'].'</div>
										<div class="friend_show_r"><p>最新艺竹：</p>';?><? if($html_friend_clo['title'] == ''){ echo '未发表过艺竹'; } else { echo '<a href="bamboo_detail.php?id='.$html_friend_clo['id'].'">'._title($html_friend_clo['title'],20).'</a>';} ?><? echo '</div>
										<div class="friend_comment_r" title="'.$html_friend_comment['comment'].'"><p>最新评论：</p>';?><? if($html_friend_comment['comment'] == ''){ echo '未参与过评论'; } else { echo _title($html_friend_comment['comment'],20); }?><? echo '</div>
										<div class="friend_collect_r"><p>最新收藏：</p>';?><? if($html_friend_collect_clo['title'] == ''){ echo '未收藏过艺竹'; } else { echo '<a href="bamboo_detail.php?id='.$html_friend_collect['bambooid'].'">'._title($html_friend_collect_clo['title'],20).'</a>';} ?><? echo '</div>
									</div>
								</li>';
						}
						_paging_user(1);
					} else {
						echo '<img src="images/sad.png" class="sad_face" alt="" />';
						echo '<div class="no_friend">还没有好友动态！</div>';
					}
                }
                ?>
            	</ul>
            </div>
		</div>
	</div>
</body>
</html>