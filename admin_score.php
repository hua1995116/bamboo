<?
session_start();
define('SCRIPT','admin_score');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理-管理评分</title>
	<?
		require 'includes/title.inc.php';
	?>
	<script type="text/javascript" src="scripts/jquery.raty.min.js"></script>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link href="styles/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/admin.js"></script>
	<script>
	$(function(){
		$(".star_model,.star_color,.star_material,.star_fashion").raty({
			path : 'images',
			size : 16,
			starHalf : 'star-half.png',
			starOff : 'star-off.png',
			starOn : 'star-on.png',
			number : 5,
			readOnly : true,
			hints : ["差","下","中","良","优"],
			space: false,
			score : function(){
				return $(this).attr('data-score');
			}
		});
	})
	</script>
	<style type="text/css">
	.member_header ul li.admin_score {
		background:url(images/member_nav.png) -360px -200px no-repeat;
	}
	.member_header ul li.admin_score:hover {
		background:url(images/member_nav.png) -360px -200px no-repeat;
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

	//分页
	global $_pagesize,$_pagenum;
	_page("SELECT * FROM score ORDER BY id DESC",10); 
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
		        	<div class="admin_title">管理评分</div>
		        	<table cellspacing="2">
		                <tr><th width="8%">ID</th><th width="20%">艺竹标题</th><th width="16%">评分人</th><th width="12%">实用30%</th><th width="12%">创意20%</th><th width="12%">材质30%</th><th width="12%">时尚20%</th><th width="8%">操作</th></tr>
		                <?
		                    $rs_star = _query("SELECT * FROM score ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
		                    while($rows_star = _fetch_array_list($rs_star)){
		                        //获取评分数据
		                        $html_star = array();
		                        $html_star['id'] = $rows_star['id'];
								$html_star['userid'] = $rows_star['userid'];
		                        $html_star['bambooid'] = $rows_star['bambooid'];
		                        $html_star['score_model'] = $rows_star['score_model'];
		                        $html_star['score_color'] = $rows_star['score_color'];
								$html_star['score_material'] = $rows_star['score_material'];
								$html_star['score_fashion'] = $rows_star['score_fashion'];
								//获取橙果对应的用户id
								$rows_user = _fetch_array("SELECT * FROM user WHERE id='{$html_star['userid']}' LIMIT 1");
								$html_user = array();
								$html_user['id'] = $rows_user['id'];
								$html_user['username'] = $rows_user['username'];
								//获取橙果信息
								$rows_article = _fetch_array("SELECT * FROM bamboo WHERE id={$html_star['bambooid']}");
								$html_article = array();
								$html_article['id'] = $rows_article['id'];
								$html_article['title'] = $rows_article['title'];
		                ?>
		                <tr>
		                    <td><? echo $html_star['id']; ?></td>
		                    <td><a href="bamboo_detail.php?id=<? echo $html_article['id']; ?>"><? echo $html_article['title']; ?></a></td>
		                    <td><a href="user.php?id=<? echo $html_user['id']; ?>"><? echo $html_user['username']; ?></td>
		                    <td>
		                    	<div id="star_model" class="star_model" data-score="<? echo _trans_score($html_star['score_model']); ?>"></div>
		                    </td>
		                    <td>
		                    	<div id="star_color" class="star_color" data-score="<? echo _trans_score($html_star['score_color']); ?>"></div>
		                    </td>
		                    <td>
		                    	<div id="star_material" class="star_material" data-score="<? echo _trans_score($html_star['score_material']); ?>"></div>
		                    </td>
		                    <td>
		                    	<div id="star_fashion" class="star_fashion" data-score="<? echo _trans_score($html_star['score_fashion']); ?>"></div>
		                    </td>
		                    <td>
		                    	<input type="hidden" class="article_id" value="<? echo $html_article['id']; ?>" />
		                        <input type="hidden" class="star_id" value="<? echo $html_star['id'];?>" />
		                        <div class="delete_star">删除</div>
		                    </td>
		                </tr>
		                <?
		                    }
		                    _free_result($rs_star);
		                ?>
		            </table>
		        	<? _paging(2); ?>
		        </div>
		    </div>
		</div>

	</div>
</body>
</html>