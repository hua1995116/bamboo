<?
session_start();
define('SCRIPT','user_bamboo');
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
	<link href="styles/user_bamboo.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/user_bamboo.js"></script>
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
		$html_user['bamboo_num'] = $rows_user['bamboo_num'];
	} else {
		_alert_back('error','非法操作！','index.php');
	}

	//分页
	global $_pagesize,$_pagenum;
	_page("SELECT * FROM bamboo WHERE username='{$html_user['username']}' ORDER BY id DESC",6); 

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
	<title>艺竹-<? echo $html_user['username']; ?>的艺竹</title>
</head>
<body>

	<?
		require 'includes/head.php';
	?>

	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome"><a href="user.php?id=<? echo $_GET['id']; ?>">TA的主页</a></li>
                <li class="mybamboo h_select"><a href="user_bamboo.php?id=<? echo $_GET['id']; ?>">TA的艺竹</a></li>
                <li class="mycomment"><a href="user_comment.php?id=<? echo $_GET['id']; ?>">TA的评论</a></li>
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
			<div class="right_title"><? echo $html_user['username']; ?>的艺竹（共<? echo $html_user['bamboo_num'];?>个）</div>
            <?
            $html_a = array();
            $rs_bamboo_list = _query("SELECT * FROM bamboo WHERE username='{$html_user['username']}' && check_bamboo=1 ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
			if(_affected_rows($rs_bamboo_list) != 0){
				while (!!$rows_bamboo = _fetch_array_list($rs_bamboo_list)) {
					$html_a['id'] = $rows_bamboo['id'];
					$html_a['title'] = $rows_bamboo['title'];
					$html_a['type'] = $rows_bamboo['type'];
					$html_a['time'] = $rows_bamboo['time'];
					$html_a['img'] = $rows_bamboo['img'];
					echo '
						<div class="galleryContainer">   
							<div class="galleryImage">
								<input type="hidden" value="'.$html_a['title'].'" />
								<a href="bamboo_detail.php?id='.$html_a['id'].'">'.$html_a['img'].'</a>
								<div class="info">
									<a href="bamboo_detail.php?id='.$html_a['id'].'"><h2>'._title($html_a['title'],14).'</h2></a>
									<div class="bamboo_list">
										<div class="bamboo_type">'._bamboo_type($html_a['type']).'</div>
										<div class="bamboo_time">'._return_time($html_a['time']).'</div>
									</div>
								</div>
							</div>
						</div>';
				}
				_paging_user(1);
			} else {
				echo '<img src="images/sad.png" class="sad_face" alt="" />';
				echo '<div class="no_show">还未发布过艺竹！</div>';
			}
            ?>
		</div>
	</div>
</body>
</html>