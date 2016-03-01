<?
session_start();
define('SCRIPT','admin_comment');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理-管理评论</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link href="styles/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/admin.js"></script>
	<style type="text/css">
	.member_header ul li.admin_comment {
		background:url(images/member_nav.png) -240px -200px no-repeat;
	}
	.member_header ul li.admin_comment:hover {
		background:url(images/member_nav.png) -240px -200px no-repeat;
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
		_query("DELETE FROM comment WHERE id IN ({$_clean['ids']})");
		if (_affected_rows()) {
			_close();
			_alert_back('face-smile','删除成功','admin_comment.php');
		} else {
			_close();
			_alert_back('face-sad','删除失败',null);
		}
	}

	//分页
	global $_pagesize,$_pagenum;
	_page("SELECT * FROM comment ORDER BY time DESC",10); 
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
		        	<div class="admin_title">管理评论</div>
		        	 <table cellspacing="2">
		                <tr><th width="6%">ID</th><th width="30%">评论标题</th><th width="24%">评论艺竹</th><th width="16%">评论者</th><th width="16%">评论时间</th><th width="8%">操作</th></tr>
		                <?
		                    $rs_comment = _query("SELECT * FROM comment ORDER BY time DESC LIMIT $_pagenum,$_pagesize");
		                    while($rows_comment = _fetch_array_list($rs_comment)){
		                        //获取评论数据
		                        $html_comment = array();
		                        $html_comment['id'] = $rows_comment['id'];
		                        $html_comment['userid'] = $rows_comment['userid'];
		                        $html_comment['bambooid'] = $rows_comment['bambooid'];
		                        $html_comment['comment'] = $rows_comment['comment'];
		                        $html_comment['time'] = $rows_comment['time'];
		                        //获取评论者昵称
		                        $rows_username = _fetch_array("SELECT id,username FROM user WHERE id='{$html_comment['userid']}' LIMIT 1");
		                        $html_username = array();
								$html_username['id'] = $rows_username['id'];
		                        $html_username['username'] = $rows_username['username'];
		                        //获取文章标题
		                        $rows_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$html_comment['bambooid']}' LIMIT 1");
		                        $html_bamboo = array();
		                        $html_bamboo['id'] = $rows_bamboo['id'];
		                        $html_bamboo['title'] = $rows_bamboo['title'];
		                ?>
		                <tr>
		                	<td><? echo $html_comment['id']; ?></td><td><? echo $html_comment['comment']; ?></td><td><a href="bamboo_detail.php?id=<? echo $html_bamboo['id']; ?>" title="<? $html_bamboo['title']; ?>"><? echo _title($html_bamboo['title'],20); ?></a></td><td><? echo '<a href="user.php?id='.$html_username['id'].'">'.$html_username['username'].'</a>'; ?></td><td><? echo $html_comment['time']; ?>
		                    </td>
		                	<td>
		                    	<input type="hidden" class="comment_id" value="<? echo $html_comment['id'];?>" />
		                        <input type="hidden" class="user_id" value="<? echo $html_username['id'];?>" />
		                        <input type="hidden" class="article_id" value="<? echo $html_bamboo['id'];?>" />
		                		<div class="delete_com">删除</div>
		                	</td>
		                </tr>
		                <?
		                    }
		                    _free_result($rs_comment);
		                ?>
		            </table>
		        	 <? _paging(2); ?>
		        </div>
		    </div>
		</div>

	</div>
</body>
</html>