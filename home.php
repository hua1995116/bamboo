<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-个人主页</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" href="styles/home_com.css" type="text/css" />
	<link rel="stylesheet" href="styles/home.css" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/home.js"></script>
	<?
	if(isset($_SESSION['username'])){
		$rows_user = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}'");
		//获取用户信息
		$html_user = array();
		$html_user['id'] = $rows_user['id'];
		$html_user['username'] = $rows_user['username'];
		$html_user['face'] = $rows_user['face'];
		$html_user['birthday'] = $rows_user['birthday'];
		$html_user['email'] = $rows_user['email'];
		$html_user['content'] = $rows_user['content'];
		$html_user['bamboo_num'] = $rows_user['bamboo_num'];
	} else {
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
	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome h_select"><a href="home.php">我的主页</a></li>
                <li class="mybamboo"><a href="mybamboo.php">我的竹艺</a></li>
                <li class="mycomment"><a href="mycomment.php">我的评论</a></li>
                <li class="mycollect"><a href="mycollect.php">我的收藏</a></li>
                <li class="myfriend"><a href="myfriend.php">我的好友</a></li>
                <li class="mydata"><a href="mydata.php">我的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<div class="member_left">
			<div class="left_title">个人信息</div>
			<div class="user_data">
        		<img src="<? echo $html_user['face']; ?>" class="user_face" />
            	<div class="user_name"><? echo $html_user['username']; ?></div>
            	<div class="user_info">
			        <ul>
			            <li>
			                <p>性别：</p><div class="user_sex"><? if($html_user['sex'] == 0){echo '未填写';} else if($html_user['sex'] == 1){echo '男';} else if($html_user['sex'] == 2){echo '女';} else {echo '未填写';} ?></div>
			            </li>
			            <li>
			                <p>生日：</p><div class="user_birthday"><? if($html_user['birthday'] == '0000-00-00'){echo '未填写';} else { echo $html_user['birthday']; } ?></div>
			            </li>
			            <li>
			                <p>邮箱：</p><div class="user_email"><? if($html_user['email'] == ''){echo '未填写';} else { echo $html_user['email']; } ?></div>
			            </li>
			            <li>
			                <p>q&nbsp;&nbsp;q&nbsp;：</p><div class="user_qq"><? if($html_user['qq'] == ''){echo '未填写';} else { echo $html_user['qq']; } ?></div>
			            </li>
			            <li>
			                <h3>个人简介：</h3><div class="user_content"><? if($html_user['content'] == ''){echo '未填写';} else { echo $html_user['content']; } ?></div>
			            </li>
			        </ul>
			    </div>
        	</div>
		</div>
		<div class="member_right">
        	<div class="right_title">我的主页
				<div class="new_msg">查看推广消息</div>
        	</div>
        	<div class="my_show_area">
            	<div class="my_show_title">
                	<p>最新发布工艺品（共<? echo $html_user['bamboo_num']; ?>个）</p>
                	<div class="more_show"><a href="mybamboo.php">查看更多</a></div>
                </div>
                <?
				$html_a = array();
				$rs_bamboo = _query("SELECT * FROM bamboo WHERE username='{$html_user['username']}' && check_bamboo=1 ORDER BY modify_time DESC LIMIT 2");
				if(_affected_rows($rs_bamboo) != 0){
					while (!!$rows_bamboo = _fetch_array_list($rs_bamboo)) {
						$html_bamboo['id'] = $rows_bamboo['id'];
						$html_bamboo['title'] = $rows_bamboo['title'];
						$html_bamboo['type'] = $rows_bamboo['type'];
						$html_bamboo['time'] = $rows_bamboo['time'];
						$html_bamboo['img'] = $rows_bamboo['img'];
						echo '
							<div class="galleryContainer">   
								<div class="galleryImage">
									<input type="hidden" value="'.$html_bamboo['title'].'" />
									<a href="bamboo_detail.php?id='.$html_bamboo['id'].'">'.$html_bamboo['img'].'</a>
									<div class="info">
										<a href="bamboo_detail.php?id='.$html_bamboo['id'].'"><h2>'._title($html_bamboo['title'],14).'</h2></a>
										<div class="bamboo_list">
											<div class="bamboo_type">'._bamboo_type($html_bamboo['type']).'</div>
											<div class="bamboo_time">'._return_time($html_bamboo['time']).'</div>
										</div>
									</div>
								</div>
							</div>';
					}
				} else {
					echo '<img src="images/sad.png" class="sad_face" alt="" />';
					echo '<div class="no_show">还未发布过竹工艺！</div>';
				}
				?>
            </div>
            <div class="my_comment_area">
            	<div class="my_comment_title">
                	<?
						$comment_num = _num_rows(_query("SELECT * FROM comment WHERE userid={$html_user['id']}"));
                    ?>
                	<p>最新评论（共<? echo $comment_num; ?>个）</p>
                	<div class="more_show"><a href="mycomment.php">查看更多</a></div>
                </div>
                <?
					$html_com = array();
                	$rs_comment = _query("SELECT * FROM comment WHERE userid={$html_user['id']} ORDER BY time DESC LIMIT 1");
					if(_affected_rows($rs_comment) != 0){
						while (!!$rows_comment = _fetch_array_list($rs_comment)) {
							$html_com['id'] = $rows_comment['id'];
							$html_com['userid'] = $rows_comment['userid'];
							$html_com['bambooid'] = $rows_comment['bambooid'];
							$html_com['comment'] = $rows_comment['comment'];
							$html_com['time'] = $rows_comment['time'];
							$rows_com_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_com['bambooid']}'");
							$html_com_c = array();
							$html_com_c['id'] = $rows_com_bamboo['title'];
							$html_com_c['title'] = $rows_com_bamboo['title'];
							$html_com_c['img'] = $rows_com_bamboo['img'];
							echo '
								<div class="galleryContainer">   
									<div class="galleryImage">
										<input type="hidden" value="'.$html_com_c['title'].'" />
										<a href="bamboo_detail.php?id='.$html_com_c['id'].'">'.$html_com_c['img'].'</a>
										<div class="info">
											<a href="bamboo_detail.php?id='.$html_com_c['id'].'"><h2>'._title($html_com_c['title'],14).'</h2></a>
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
            <div class="my_collect_area">
            	<div class="my_collect_title">
                	<?
						$collect_num = _num_rows(_query("SELECT * FROM collect WHERE userid={$html_user['id']}"));
                    ?>
                	<p>最新收藏（共<? echo $collect_num; ?>个）</p>
                	<div class="more_show"><a href="mycollect.php">查看更多</a></div>
                </div>
                <?
					$html_col = array();
                	$rs_collect = _query("SELECT * FROM collect WHERE userid={$html_user['id']} ORDER BY time DESC LIMIT 1");
					if(_affected_rows($rs_collect) != 0){
						while (!!$rows_collect = _fetch_array_list($rs_collect)) {
							$html_col['id'] = $rows_collect['id'];
							$html_col['userid'] = $rows_collect['userid'];
							$html_col['bambooid'] = $rows_collect['bambooid'];
							$html_col['time'] =$rows_collect['time'];
							$rows_col_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_col['bambooid']}'");
							$html_col_c['id'] = $rows_col_bamboo['title'];
							$html_col_c['title'] = $rows_col_bamboo['title'];
							$html_col_c['img'] = $rows_col_bamboo['img'];
							echo '
								<div class="galleryContainer">   
									<div class="galleryImage">
										<input type="hidden" value="'.$html_col_c['title'].'" />
										<a href="article_detail.php?id='.$html_col_c['id'].'">'.$html_col_c['img'].'</a>
										<div class="info">
											<a href="article_detail.php?id='.$html_col_c['id'].'"><h2>'._title($html_col_c['title'],14).'</h2></a>
											<div class="article_list">
												<div class="collect">在'._return_time($html_col['time']).'收藏</div>
											</div>
										</div>
									</div>
								</div>';
						}
					} else {
						echo '<img src="images/sad.png" class="sad_face" alt="" />';
						echo '<div class="no_show">还未收藏过竹工艺！</div>';
					}
				?>
            </div>
        </div>
        <!-- member_right over -->
	</div>

	<!--推广消息-->
	<div id="new_area">
		<?
	        $rs_new_area = _query("SELECT * FROM contact WHERE beuserid={$html_user['id']} ORDER BY time DESC LIMIT 6");
	        if(_num_rows($rs_new_area) != 0){
	            echo '
	            <table class="new" cellspacing="0">
	                <tr>
	                    <th width="20%">我的作品</th><th width="16%">发送人</th><th width="36%">内容</th><th width="20%">发送时间</th><th width="8%">操作</th>
	                </tr>';
	            while($rows_new_area = _fetch_array_list($rs_new_area)){
	                $html_new = array();
	                $html_new['id'] = $rows_new_area['id'];
	                $html_new['userid'] = $rows_new_area['userid'];
	                $html_new['beuserid'] = $rows_new_area['beuserid'];
	                $html_new['bambooid'] = $rows_new_area['bambooid'];
	                $html_new['say'] = $rows_new_area['say'];
	                $html_new['time'] = $rows_new_area['time'];
	                $rows_new_a = _fetch_array("SELECT * FROM bamboo WHERE id={$html_new['bambooid']}");
	                $html_new_a = array();
	                $html_new_a['title'] = $rows_new_a['title'];
	                $rows_new_u = _fetch_array("SELECT * FROM user WHERE id={$html_new['userid']}");
	                $html_new_u = array();
	                $html_new_u['id'] = $rows_new_u['id'];
	                $html_new_u['username'] = $rows_new_u['username'];
	                ?>
	                    <tr>
	                        <td width="20%"><? echo $html_new_a['title']; ?></td>
	                        <td width="16%"><a href="user.php?id=<? echo $html_new_u['id']; ?>"><? echo $html_new_u['username']; ?></a></td>
	                        <td width="36%"><? echo $html_new['say']; ?></td>
	                        <td width="20%"><? echo _return_time($html_new['time']); ?></td>
	                        <td width="8%">
	                            <input type="hidden" class="delete_id" value="<? echo $html_new['id']; ?>" />
	                            <div class="delete_new">删除</div>
	                        </td>
	                    </tr>
	                <?
	            }
	            echo '</table>';
	        } else {
	            echo '<img src="images/sad.png" class="sad_face" alt="" />';
	            echo '<div class="no_new">暂时没有人向你发送此类消息！</div>';
	        }
	    ?>
	</div>
</body>
</html>