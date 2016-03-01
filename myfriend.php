<?
session_start();
define('SCRIPT','myfriend');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-我的好友</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" href="styles/home_com.css" type="text/css" />
	<link rel="stylesheet" href="styles/myfriend.css" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/myfriend.js"></script>
	<?
	//判断是否登录
	if (!isset($_SESSION['username'])){
		_alert_back('error','请先登录！','index.php');
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
                <li class="mycomment"><a href="mycomment.php">我的评论</a></li>
                <li class="mycollect"><a href="mycollect.php">我的收藏</a></li>
                <li class="myfriend h_select"><a href="myfriend.php">我的好友</a></li>
                <li class="mydata"><a href="mydata.php">我的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<div class="member_left">
			<?
            	if(isset($_SESSION['username'])) {
                    //获取用户对应的user ID
                    $rows_author = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
                    $user_id = array();
                    $user_id['id'] = $rows_author['id'];
                    //获取用户好友的id
                    $rs_friend = _query("SELECT * FROM friend WHERE userid='{$user_id['id']}' ORDER BY time DESC");
					$html_friend_num = _affected_rows($rs_friend);
				}
			?>
			<div class="left_title">我的好友（共有<? echo $html_friend_num; ?>位好友）</div>
			<div class="myfriend">
            	<ul>
				<?
                if(isset($_SESSION['username'])) {
					if(_affected_rows($rs_friend) != 0){
						while($rows_friend = _fetch_array_list($rs_friend)){
							$html_friend = array();
							$html_friend['id'] = $rows_friend['id'];
							$html_friend['beuserid'] = $rows_friend['beuserid'];
							//获取好友的数据
							$rows_friend_info = _fetch_array("SELECT * FROM user WHERE id='{$html_friend['beuserid']}' LIMIT 1");
							$html_friend_info = array();
							$html_friend_info['username'] = $rows_friend_info['username'];
							$html_friend_info['face'] = $rows_friend_info['face'];
							echo '
									<li>
										<a href="user.php?id='.$html_friend['beuserid'].'"><img class="friend_face" src="'.$html_friend_info['face'].'" alt="face" /></a>
										<a href="user.php?id='.$html_friend['beuserid'].'"><div class="friend_name">'.$html_friend_info['username'].'</div></a>
										<input type="hidden" class="friend_id" value="'.$html_friend['id'].'" />
										<input type="hidden" class="user_id" value="'.$user_id['id'].'" />
										<div class="del_friend">删除好友</div>
									</li>';
						}
					} else {
						echo '<img src="images/sad.png" class="sad_face" alt="" />';
						echo '<div class="no_friend">还未添加过好友！</div>';
					}
                }
				_free_result($rs_friend);
                ?>
                </ul>
            </div>
		</div>
		<div class="member_right">
        	<div class="right_title">我的好友动态</div>
        	<div class="myfriend_thing">
                <ul>
                <?
				if(isset($_SESSION['username'])) {
					//分页
					global $_pagesize,$_pagenum;
					_page("SELECT * FROM friend WHERE userid='{$user_id['id']}' ORDER BY time DESC",5);
					//获取用户好友的id
                	$rs_friend = _query("SELECT * FROM friend WHERE userid='{$user_id['id']}' ORDER BY time DESC LIMIT $_pagenum,$_pagesize");
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
											<div class="friend_show_r"><p>最新工艺品：</p>';?><? if($html_friend_clo['title'] == ''){ echo '未发表过艺竹'; } else { echo '<a href="bamboo_detail.php?id='.$html_friend_clo['id'].'">'._title($html_friend_clo['title'],20).'</a>';} ?><? echo '</div>
											<div class="friend_comment_r" title="'.$html_friend_comment['comment'].'"><p>最新评论：</p>';?><? if($html_friend_comment['comment'] == ''){ echo '未参与过评论'; } else { echo _title($html_friend_comment['comment'],20); }?><? echo '</div>
											<div class="friend_collect_r"><p>最新收藏：</p>';?><? if($html_friend_collect_clo['title'] == ''){ echo '未收藏过艺竹'; } else { echo '<a href="bamboo_detail.php?id='.$html_friend_collect['bambooid'].'">'._title($html_friend_collect_clo['title'],20).'</a>';} ?><? echo '</div>
										</div>
									</li>';
						}
						_paging(1);
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