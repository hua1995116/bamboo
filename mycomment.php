<?
session_start();
define('SCRIPT','mycomment');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-我的评论</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/home_com.css" type="text/css" />
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" href="styles/mycomment.css" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/mycomment.js"></script>
	<?
	//判断是否登录
	if (!isset($_SESSION['username'])){
		_alert_back('error','请先登录！','index.php');
	} else{
		//获取数据
		$_rows = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
		if ($_rows) {
			$_html = array();
			$_html['comment_num'] = $_rows['comment_num'];
		} else {
			_alert_back('face-sad','此用户不存在！',null);
		}
	}
	?>
</head>
<body>

	<?
		require 'includes/header.inc.php';
	?>
	<div class="head1"> 
	  <a href="social.php"><img src="images/logo.png"></a>
	</div>
	<div class="head2">
		<img src="images/head2.png">
	</div>


	<div id="body_bg"></div>
	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome"><a href="home.php">我的主页</a></li>
                <li class="mybamboo"><a href="mybamboo.php">我的艺竹</a></li>
                <li class="mycomment h_select"><a href="mycomment.php">我的评论</a></li>
                <li class="mycollect"><a href="mycollect.php">我的收藏</a></li>
                <li class="myfriend"><a href="myfriend.php">我的好友</a></li>
                <li class="mydata"><a href="mydata.php">我的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<div class="member_left">
			<div class="left_title">热评工艺品</div>
			<?
            $html_a = array();
            $rs_bamboo_list = _query("SELECT * FROM bamboo ORDER BY comment DESC LIMIT 4");
            while ($rows_bamboo_list = _fetch_array_list($rs_bamboo_list)) {
                $html_a['id'] = $rows_bamboo_list['id'];
                $html_a['title'] = $rows_bamboo_list['title'];
				$html_a['type'] = $rows_bamboo_list['type'];
				$html_a['img'] = $rows_bamboo_list['img'];
                $html_a['time'] = $rows_bamboo_list['time'];
                echo '
                	<div class="bamboo_list">
						<div class="bamboo_title"><a href="bamboo_detail.php?id='.$html_a['id'].'" title="'.$html_a['title'].'">'._title($html_a['title'],14).'</a></div>
						<input type="hidden" value="'.$html_a['title'].'" />
						<a href="bamboo_detail.php?id='.$html_a['id'].'" class="show_img">'.$html_a['img'].'</a>
						<div class="bamboo_type">'._bamboo_type($html_a['type']).'</div>
						<div class="bamboo_time">'._return_time($html_a['time']).'</div>
					</div>';
            }
            ?>
		</div>
		<div class="member_right">
        	<div class="right_title">我的评论（共<? echo $_html['comment_num'];?>个）</div>
        	<?
			if (!!isset($_SESSION['username'])) {
				//获取用户对应的user id
				$rows_author = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
				$user_id = array();
				$user_id['id'] = $rows_author['id'];
				//分页
				global $_pagesize,$_pagenum;
				_page("SELECT * FROM comment WHERE userid='{$user_id['id']}' ORDER BY time DESC",5); 
				//获取用户评论数据
				$rs_comment = _query("SELECT * FROM comment WHERE userid='{$user_id['id']}' ORDER BY time DESC LIMIT $_pagenum,$_pagesize");
				if(_affected_rows($rs_comment) != 0){
					while($rows_comment = _fetch_array_list($rs_comment)){
						$html_c = array();
						$html_c['id'] = $rows_comment['id'];
						$html_c['userid'] = $rows_comment['userid'];
						$html_c['bambooid'] = $rows_comment['bambooid'];
						$html_c['comment'] = $rows_comment['comment'];
						$html_c['time'] = $rows_comment['time'];
						//获取评论文章的信息
						$rows_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_c['bambooid']}' LIMIT 1");
						$html_clo = array();
						$html_clo['username'] = $rows_bamboo['username'];
						$html_clo['type'] = $rows_bamboo['type'];
						$html_clo['title'] = $rows_bamboo['title'];
						$html_clo['img'] = $rows_bamboo['img'];
						echo '
							<div class="comment_list">
								<div class="_bamboo">
									<div class="comment_username">作者：'.$html_clo['username'].'</div>
									<p>&nbsp;————&nbsp;</p>
									<div class="comment_title"><a href="bamboo_detail.php?id='.$html_c['bambooid'].'" title="'.$html_clo['title'].'">'._title($html_clo['title'],20).'</a></div>
									<div class="comment_type">'._bamboo_type($html_clo['type']).'</div>
								</div>
								<input type="hidden" value="'.$html_clo['title'].'" />
								<a href="bamboo_detail.php?id='.$html_c['bambooid'].'" class="show_img_r">'.$html_clo['img'].'</a>
								<div class="_comment">
									<p>我在&nbsp;</p>
									<div class="comment_time">'._return_time($html_c['time']).'</div>
									<p>&nbsp;的评论：</p>
									<div class="comment_comment">'.$html_c['comment'].'</div>
								</div>
								<input type="hidden" class="comment_id" value="'.$html_c['id'].'" />
								<input type="hidden" class="user_id" value="'.$html_c['userid'].'" />
								<input type="hidden" class="bamboo_id" value="'.$html_c['bambooid'].'" />
								<div class="delete">删&nbsp;除</div>
							</div>
						';
					}
					_paging(1);
				} else {
					echo '<img src="images/sad.png" class="sad_face" alt="" />';
					echo '<div class="no_comment">还未发表过评论！</div>';
				}
			}
			?>
        </div>
    </div>
</body>
</html>