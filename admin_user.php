<?
session_start();
define('SCRIPT','admin_user');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理-管理用户</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link href="styles/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/admin.js"></script>
	<style type="text/css">
	.member_header ul li.admin_user {
		background:url(images/member_nav.png) -600px -200px no-repeat;
	}
	.member_header ul li.admin_user:hover {
		background:url(images/member_nav.png) -600px -200px no-repeat;
	}
	</style>
	<?
	//判断登录
	if (isset($_SESSION['username'])){
		$rs_userid = _query("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
		 while(!!$_rows=_fetch_array_list($rs_userid)){
			$_html_u['id'] = $_rows['id'];
			$_html_u['level'] = $_rows['level'];
			if($_html_u['level'] != 1){
				_alert_back('face-sad','你无权查看该页面！','index.php');
			}
		}
	} else {
		_alert_back('face-sad','请先登录！','index.php');
	}

	//删除
	if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
		$_clean = array();
		$_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
		_query("DELETE FROM user WHERE id IN ({$_clean['ids']})");
		if (_affected_rows()) {
			_close();
			_alert_back('face-smile','删除成功','admin_user.php');
		} else {
			_close();
			_alert_back('face-sad','删除失败',null);
		}
	}

	//分页
	global $_pagesize,$_pagenum;
	_page("SELECT * FROM user ORDER BY reg_time DESC",10); 
	?>
</head>
<body>
	<?
		require 'includes/header.inc.php';
	?>
	<?
		require 'includes/head.php';
	?>

	<div id="body_area">

		<div id="member_body">
		    <div id="member_body_area">
		    	<div class="member_header">
		        	<ul>
		            	<li class="admin_show"><a href="admin.php">管理艺竹</a></li>
		                <li class="admin_comment"><a href="admin_comment.php">管理评论</a></li>
		                <li class="admin_user"><a href="admin_user.php">管理用户</a></li>
		                <li class="admin_score"><a href="admin_score.php">管理评分</a></li>
		            </ul>
		        </div>
		        <div class="admin_body">
		        	<div class="admin_title">管理用户</div>
		        	<table cellspacing="2">
		                <tr><th width="10%">ID</th><th width="24%">用户名</th><th width="30%">邮箱</th><th width="20%">注册时间</th><th width="16%">操作</th></tr>
		                <?
		                    $rs_user = _query("SELECT * FROM user ORDER BY reg_time DESC LIMIT $_pagenum,$_pagesize");
		                    while($rows_user = _fetch_array_list($rs_user)){
		                        //获取用户数据
		                        $html_user = array();
		                        $html_user['id'] = $rows_user['id'];
		                        $html_user['username'] = $rows_user['username'];
		                        $html_user['email'] = $rows_user['email'];
		                        $html_user['reg_time'] = $rows_user['reg_time'];
								$html_user['gag'] = $rows_user['gag'];
								$html_user['gag_time'] = $rows_user['gag_time'];
		                ?>
		                <tr>
		                    <td><? echo $html_user['id']; ?></td><td><a href="user.php?id=<? echo $html_user['id']; ?>"><? echo $html_user['username']; ?></a></td><td><? echo $html_user['email']; ?></td><td><? echo $html_user['reg_time']; ?>
		                    </td>
		                    <td>
		                    	<input type="hidden" class="user_id" value="<? echo $html_user['id'];?>" />
		                        <?
		                        if($html_user['gag'] == 1){
		                        	echo '<div class="gag">禁言</div>';
								} else {
									echo '<div class="del_gag" title="上次禁言时间：'.$html_user['gag_time'].'">取消禁言</div>';
								}
								?>
		                    	<div class="delete_user">删除</div>
		                    </td>
		                </tr>
		                <?
		                    }
		                    _free_result($rs_user);
		                ?>
		            </table>
		        	<? _paging(2); ?>
		        </div>
		    </div>
		</div>

	</div>
</body>
</html>