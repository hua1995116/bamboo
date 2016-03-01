<?
session_start();
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
	<link href="styles/user.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/home_com.js"></script>
	<script>
	$(function(){
		$('.galleryImage').hover(
			function(){
				$(this).find('img').animate({width:165, height:110, marginTop:10, marginLeft:52},200);
			 },
			 function(){
				 $(this).find('img').animate({width:270, height:180, marginTop:0, marginLeft:0},200);
			 });
			 
		$(".galleryContainer").hover(function(){
			var $title = $(this).find("input").val();
			$(this).find("img").attr("title",$title);
		})
	})
	</script>
	<?
	if(isset($_GET['id'])){
		 $rows_user = _fetch_array("SELECT * FROM user WHERE id='{$_GET['id']}'");
		 
		 //获取用户信息
		 $html_user['username'] = $rows_user['username'];
		 $html_user['face'] = $rows_user['face'];
		 $html_user['birthday'] = $rows_user['birthday'];
		 $html_user['email'] = $rows_user['email'];
		 $html_user['qq'] = $rows_user['qq'];
		 $html_user['content'] = $rows_user['content'];
		 $html_user['bamboo_num'] = $rows_user['bamboo_num'];
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
	<title>衣恋-<? echo $html_user['username']; ?>的主页</title>
</head>
<body>

	<?
		require 'includes/head.php';
	?>
	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome h_select"><a href="user.php?id=<? echo $_GET['id']; ?>">TA的主页</a></li>
                <li class="mybamboo"><a href="user_bamboo.php?id=<? echo $_GET['id']; ?>">TA的艺竹</a></li>
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
        	<div class="right_title"><? echo $html_user['username']; ?>的主页</div>
            <div class="user_show_area">
            	<div class="user_show_title">
                	<p>最新成果果（共<? echo $html_user['bamboo_num']; ?>个）</p>
                	<div class="more_show"><a href="user_bamboo.php">查看更多</a></div>
                </div>
                <?
				$html_a = array();
				$rs_bamboo = _query("SELECT * FROM bamboo WHERE username='{$html_user['username']}' && check_bamboo=1 ORDER BY modify_time DESC LIMIT 2");
				if(_affected_rows($rs_bamboo) != 0){
					while (!!$rows_bamboo = _fetch_array_list($rs_bamboo)) {
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
				} else {
					echo '<img src="images/sad.png" class="sad_face" alt="" />';
					echo '<div class="no_show">还未发布过艺竹！</div>';
				}
				?>
            </div>
            <div class="user_comment_area">
            	<div class="user_comment_title">
                	<?
						$comment_num = _num_rows(_query("SELECT * FROM comment WHERE userid={$_GET['id']}"));
                    ?>
                	<p>最新评论（共<? echo $comment_num; ?>个）</p>
                	<div class="more_show"><a href="user_comment.php">查看更多</a></div>
                </div>
                <?
					$html_com = array();
                	$rs_comment = _query("SELECT * FROM comment WHERE userid={$_GET['id']} ORDER BY time DESC LIMIT 1");
					if(_affected_rows($rs_comment) != 0){
						while (!!$rows_comment = _fetch_array_list($rs_comment)) {
							$html_com['id'] = $rows_comment['id'];
							$html_com['userid'] = $rows_comment['userid'];
							$html_com['bambooid'] = $rows_comment['bambooid'];
							$html_com['comment'] = $rows_comment['comment'];
							$html_com['time'] = $rows_comment['time'];
							$rows_com_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_com['bambooid']}'");
							$html_com_a = array();
							$html_com_a['id'] = $rows_com_bamboo['title'];
							$html_com_a['title'] = $rows_com_bamboo['title'];
							$html_com_a['img'] = $rows_com_bamboo['img'];
							echo '
								<div class="galleryContainer">   
									<div class="galleryImage">
										<input type="hidden" value="'.$html_com_a['title'].'" />
										<a href="bamboo_detail.php?id='.$html_com_a['id'].'">'.$html_com_a['img'].'</a>
										<div class="info">
											<a href="bamboo_detail.php?id='.$html_com_a['id'].'"><h2>'._title($html_com_a['title'],14).'</h2></a>
											<div class="bamboo_list">
												<div class="comment">评论：'._title($html_com['comment'],20).'</div>
											</div>
										</div>
									</div>
								</div>';
						}
					} else {
						echo '<img src="images/sad.png" class="sad_face" alt="" />';
						echo '<div class="no_show">还未发表过评论！</div>';
					}
				?>
            </div>
            <div class="user_collect_area">
            	<div class="user_collect_title">
                	<?
						$collect_num = _num_rows(_query("SELECT * FROM collect WHERE userid={$_GET['id']}"));
                    ?>
                	<p>最新收藏（共<? echo $collect_num; ?>个）</p>
                	<div class="more_show"><a href="user_collect.php">查看更多</a></div>
                </div>
                <?
					$html_col = array();
                	$rs_collect = _query("SELECT * FROM collect WHERE userid={$_GET['id']} ORDER BY time DESC LIMIT 1");
					if(_affected_rows($rs_collect) != 0){
						while (!!$rows_collect = _fetch_array_list($rs_collect)) {
							$html_col['id'] = $rows_collect['id'];
							$html_col['userid'] = $rows_collect['userid'];
							$html_col['bambooid'] = $rows_collect['bambooid'];
							$html_col['time'] =$rows_collect['time'];
							$rows_col_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_col['bambooid']}'");
							$html_col_a['id'] = $rows_col_bamboo['title'];
							$html_col_a['title'] = $rows_col_bamboo['title'];
							$html_col_a['img'] = $rows_col_bamboo['img'];
							echo '
								<div class="galleryContainer">   
									<div class="galleryImage">
										<input type="hidden" value="'.$html_col_a['title'].'" />
										<a href="bamboo_detail.php?id='.$html_col_a['id'].'">'.$html_col_a['img'].'</a>
										<div class="info">
											<a href="bamboo_detail.php?id='.$html_col_a['id'].'"><h2>'._title($html_col_a['title'],14).'</h2></a>
											<div class="bamboo_list">
												<div class="collect">在'._return_time($html_col['time']).'收藏</div>
											</div>
										</div>
									</div>
								</div>';
						}
					} else {
						echo '<img src="images/sad.png" class="sad_face" alt="" />';
						echo '<div class="no_show">还未收藏过艺竹！</div>';
					}
				?>
            </div>
        </div>
	</div>
</body>
</html>