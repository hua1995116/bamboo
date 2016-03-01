<?
session_start();
define('SCRIPT','mybamboo');
//引入公共文件
require 'includes/common.inc.php';
//分页
global $_pagesize,$_pagenum;
_page("SELECT * FROM bamboo WHERE username='{$_SESSION['username']}' ORDER BY modify_time DESC",4); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-我的艺竹</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="ueditor/themes/default/css/ueditor.css" />
	<link rel="stylesheet" href="ueditor/themes/default/dialogbase.css" />
	<link rel="stylesheet" href="ueditor/themes/iframe.css" />
	<script type="text/javascript" src="ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="ueditor/ueditor.all.js"></script>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" href="styles/home_com.css" type="text/css" />
	<link rel="stylesheet" href="styles/mybamboo.css" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/mybamboo.js"></script>
	<?
	//是否正常登录
	if (isset($_SESSION['username'])) {
		//获取数据
		$_rows = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
		if ($_rows) {
			$_html['id'] = $_rows['id'];
			$_html['username'] = $_rows['username'];
			$_html['bamboo_num'] = $_rows['bamboo_num'];
			$_html['level'] = $_rows['level'];
			$_html['type'] = $_rows['type'];
			$_html = _html($_html);
		} else {
			_alert_back('face-sad','此用户不存在！',null);
		}
	} else {
		_alert_back('face-sad','请登录后再发布艺竹！','index.php');
	}

	//将艺竹放入数据库
	if ($_GET['action'] == 'launch') {
		include 'includes/check.func.php';
		//接受内容
		$_clean = array();
		$_clean['username'] = $_html['username'];
		$_clean['type'] = $_POST['type'];
		if($_clean['type']==0){
			_alert_back('face-sad','请选择艺竹类别',null);
		}
		$_clean['title'] = _check_post_title($_POST['title'],2,40);
		$_clean = _mysql_string($_clean);
		$_clean['content'] = _check_post_content($_POST['content'],20);
		$_clean['cost'] = $_POST['costs'];
		//正则匹配第一张图片
		preg_match_all("/<img.*?>/im",$_clean['content'],$_img);
		$_clean['img'] = $_img[0][0];
		if($_clean['img'] == ''){
			$_clean['img'] = '<img src="images/default.jpg" />';
		}
		//写入数据库
		_query("INSERT INTO bamboo (
									username,
									type,
									title,
									content,
									img,
									cost,
									modify_time,
									time
								) 
				VALUES (
									'{$_clean['username']}',
									'{$_clean['type']}',
									'{$_clean['title']}',
									'{$_clean['content']}',
									'{$_clean['img']}',
                                    '{$_clean['cost']}',
									NOW(),
									NOW()
								)
		");
		if (_affected_rows() == 1) {
			$_clean['id'] = _insert_id();
			_query("UPDATE user SET bamboo_num=bamboo_num+1 WHERE id='{$_html['id']}'");
			_close();
			_alert_back('face-smile','发布成功！','bamboo_detail.php?id='.$_clean['id']);
		} else {
			_close();
			_alert_back('face-sad','发布失败！',null);
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


	</div>
	<div id="body_bg"></div>
	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome"><a href="home.php">我的主页</a></li>
                <li class="mybamboo h_select"><a href="mybamboo.php">我的艺竹</a></li>
                <li class="mycomment"><a href="mycomment.php">我的评论</a></li>
                <li class="mycollect"><a href="mycollect.php">我的收藏</a></li>
                <li class="myfriend"><a href="myfriend.php">我的好友</a></li>
                <li class="mydata"><a href="mydata.php">我的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<div class="member_left">
			<div class="left_title">历史作品（共<? echo $_html['bamboo_num'];?>个）</div>
			<?
            $html_a = array();
            $rs_bamboo_list = _query("SELECT * FROM bamboo WHERE username='{$_SESSION['username']}' ORDER BY modify_time DESC LIMIT $_pagenum,$_pagesize");
			if(_affected_rows($rs_bamboo_list) != 0){
				while (!!$rows_bamboo = _fetch_array_list($rs_bamboo_list)) {
					$html_a['id'] = $rows_bamboo['id'];
					$html_a['title'] = $rows_bamboo['title'];
					$html_a['type'] = $rows_bamboo['type'];
					$html_a['img'] = $rows_bamboo['img'];
					$html_a['time'] = $rows_bamboo['time'];
					echo '
						<div class="bamboo_list">
							<div class="bamboo_title">
								<a href="bamboo_detail.php?id='.$html_a['id'].'" title="'.$html_a['title'].'">'._title($html_a['title'],12).'</a>
							</div>
							<a href="bamboo_modify.php?id='.$html_a['id'].'"><div class="modify">修改</div></a>
							<input type="hidden" value="'.$html_a['title'].'" />
							<a href="bamboo_detail.php?id='.$html_a['id'].'" class="show_img">'.$html_a['img'].'</a>
							<div class="bamboo_type">'._bamboo_type($html_a['type']).'</div>
							<div class="bamboo_time">'._return_time($html_a['time']).'</div>
						</div>';
				}
				_paging_mybamboo(1);
			}
			else {
				echo '<img src="images/sad.png" class="sad_face" alt="" />';
				echo '<div class="no_show">还未发布过竹工艺！<br>赶快在右边行动吧！</div>';
			}
            ?>
		</div>
		<div class="member_right">
        	<div class="up_title">发布竹工艺</div>
        	<div class="up_note">请在此按要求发布你的竹工艺，享受相互分享交流学习的乐趣！^_^</div>
            <form method="post" id="postform" action="?action=launch" name="launch">
            	<select name="type">
                	<option value="0">请选择类别</option>
                    <option value="1">灯具</option>
                    <option value="2">家具用品</option>
                    <option value="3">装饰用品</option>
                    <option value="4">日常用品</option>
                    <option value="5">其他</option>
                </select>
                <input class="title_b" type="text" name="title" maxlength="20" value="请在此输入标题" onfocus="if(this.value=='请在此输入标题'){this.value='';} this.className='title_f';" onblur="if(this.value==''){this.value='请在此输入标题';} this.className='title_b';" autocomplete="off">
                <?
                  if($_html['type']=='厂家用户'){
                	echo '产品价格：<input class="cost" type="text" name="costs" maxlength="5">';
                  }
                ?>
                <textarea name="content" id="up_bamboo"></textarea>
                <script type="text/javascript">
                    var editor = new UE.ui.Editor();
                    editor.render("up_bamboo");
                </script>
                <input type="submit" name="submit" class="submit" value="发布">
        	</form>
        </div>
	</div>
</body>
</html>