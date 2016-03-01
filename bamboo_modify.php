<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-修改艺竹</title>
	<?
	require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="ueditor/themes/default/css/ueditor.css" />
	<link rel="stylesheet" href="ueditor/themes/default/dialogbase.css" />
	<link rel="stylesheet" href="ueditor/themes/iframe.css" />
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link href="styles/home_com.css" rel="stylesheet" type="text/css" />
	<link href="styles/bamboo_modify.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="ueditor/ueditor.all.js"></script>
	<?
	//是否正常登录
	if (isset($_SESSION['username'])) {
		//获取数据
		$_rows = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
		if ($_rows) {
			$_html['id'] = $_rows['id'];
			$_html['username'] = $_rows['username'];
			$_html['level'] = $_rows['level'];
			$_html = _html($_html);
		} else {
			_alert_back('face-sad','此用户不存在！',null);
		}
	} else {
		_alert_back('face-sad','请登录后再修改艺竹！',null);
	}

	//获取橙果数据
	if(isset($_GET['id'])){
		if(!!$rows_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$_GET['id']}'")){
			$html_bamboo['username'] = $rows_bamboo['username'];
			$html_bamboo['type'] = $rows_bamboo['type'];
			$html_bamboo['title'] = $rows_bamboo['title'];
			$html_bamboo['content'] = $rows_bamboo['content'];
			if($_html['username'] != $html_bamboo['username'] && $_html['level'] != 1){
				_alert_back('error','非法操作！',null);
			}
		} else {
			_alert_back('error','不存在该艺竹！',null);
		}
	} else {
		_alert_back('error','非法操作！',null);
	}

	if($_GET['action'] == 'modify') {
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
		$_clean['content'] = _check_post_content($_POST['content'],4);
		//正则匹配第一张图片
		preg_match_all("/<img.*?>/im",$_clean['content'],$_img);
		$_clean['img'] = $_img[0][0];
		if($_clean['img'] == ''){
			$_clean['img'] = '<img src="images/default.jpg" />';
		}
		
		//更新数据库
		_query("UPDATE bamboo SET 
													type='{$_clean['type']}',
													check_bamboo=0,
													title='{$_clean['title']}',
													content='{$_clean['content']}',
													img='{$_clean['img']}',
													modify_time=NOW()
										WHERE
													id='{$_GET['id']}'
		");
		if (_affected_rows() == 1) {
			_close();
			_alert_back('face-smile','修改成功！','bamboo_detail.php?id='.$_GET['id']);
		} else {
			_close();
			_alert_back('face-sad','修改失败！',null);
		}
	}
	?>
</head>
<body>

	<?
		require 'includes/header.inc.php';
	?>
	<?
	   require 'includes/head.php';
	?>
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
		<div class="modify_area">
        	<div class="modify_title">修改</div>
            <form method="post" id="postform" action="?id=<? echo $_GET['id']; ?>&&action=modify" name="launch">
            	<select name="type">
                	<option value="0">请选择类别</option>
                    <option value="1" <? if($html_bamboo['type'] == 1 ){echo 'selected="selected"';}?>>灯具</option>
                    <option value="2" <? if($html_bamboo['type'] == 2 ){echo 'selected="selected"';}?>>家具用品</option>
                    <option value="3" <? if($html_bamboo['type'] == 3 ){echo 'selected="selected"';}?>>装饰用品</option>
                    <option value="4" <? if($html_bamboo['type'] == 4 ){echo 'selected="selected"';}?>>日常用品</option>
                    <option value="5" <? if($html_bamboo['type'] == 5 ){echo 'selected="selected"';}?>>其他</option>
                 
                </select>
                <input class="title_b" type="text" name="title" maxlength="40" value="<? echo $html_bamboo['title']; ?>" onfocus="if(this.value=='请在此输入标题'){this.value='';} this.className='title_f';" onblur="if(this.value==''){this.value='请在此输入标题';} this.className='title_b';" autocomplete="off">
                <textarea name="content" id="up_bamboo"><? echo htmlspecialchars_decode($html_bamboo['content']); ?></textarea>
                <script type="text/javascript">
                    var editor = new UE.ui.Editor();
                    editor.render("up_bamboo");
                </script>
                <input type="submit" name="submit" class="submit" value="确认修改">
        	</form>
        </div>
	</div>
</body>
</html>