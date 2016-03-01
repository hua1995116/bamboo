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
	<link href="styles/user_data.css" rel="stylesheet" type="text/css" />
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
		 $html_user['phone'] = $rows_user['phone'];
		 $html_user['qq'] = $rows_user['qq'];
		 $html_user['content'] = $rows_user['content'];
		 $html_user['sex'] = $rows_user['sex'];
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
	<title>衣恋-<? echo $html_user['username']; ?>的信息</title>
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
                <li class="myfriend"><a href="user_friend.php?id=<? echo $_GET['id']; ?>">TA的好友</a></li>
                <li class="mydata h_select"><a href="user_data.php?id=<? echo $_GET['id']; ?>">TA的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<?
			require 'includes/member_left.inc.php';
		?>
		<div class="member_right">
			<div class="right_title"><? echo $html_user['username']; ?>的资料</div>
            <div class="member_info">
            	<ul>
                	<li><p>用&nbsp;户&nbsp;&nbsp;名：</p><div class="member_name"><? echo $html_user['username']; ?></div></li>
                    <li>
                        <p>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</p>
                        <div class="member_sex">
                        <? 
                            if($html_user['sex'] == '0'){
                                echo '未知';
                            } else if($html_user['sex'] == '1'){
                                echo '男';
                            } else {
                                echo '女';
                            } 
                        ?>
                    	</div>
                    </li>
                    <li><p>生&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日：</p><div class="member_birthday"><? if($html_user['birthday'] == '0000-00-00'){echo '未填写';} else { echo $html_user['birthday']; } ?></div></li>
                </ul>
            </div>
            <div class="member_con">
            	<ul>
                	<li><p>电子邮箱：</p><div class="member_email"><? if($html_user['email'] == ''){echo '未填写';} else { echo $html_user['email']; } ?></div></li>
                    <li><p>手&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机：</p><div class="member_phone"><? if($html_user['phone'] == ''){echo '未填写';} else { echo $html_user['phone']; } ?></div></li>
                    <li><p>&nbsp;&nbsp;&nbsp;&nbsp;Q&nbsp;&nbsp;&nbsp;Q：</p><div class="member_qq"><? if($html_user['qq'] == ''){echo '未填写';} else { echo $html_user['qq']; } ?></div></li>
                </ul>
            </div>
            <div class="member_content_note">个人简介：</div>
            <div class="member_content"><? if($html_user['content'] == ''){echo '未填写';} else { echo $html_user['content']; } ?>
            </div>
		</div>
	</div>
</body>
</html>