<?
session_start();
define('SCRIPT','admin');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理-管理艺竹</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="styles/admin.css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/admin.js"></script>
	<style type="text/css">
	.member_header ul li.admin_show {
		background:url(images/member_nav.png) -120px -200px no-repeat;
	}
	.member_header ul li.admin_show:hover {
		background:url(images/member_nav.png) -120px -200px no-repeat;
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
	_page("SELECT * FROM bamboo ORDER BY modify_time DESC",10); 
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
		        	<div class="admin_title">管理艺竹</div>
		            <table cellspacing="2">
		                <tr><th width="5%">ID</th><th width="30%">艺竹标题</th><th width="12%">艺竹类型</th><th width="18%">作者</th><th width="18%">发布时间</th><th width="17%">操作</th></tr>
		                <?
		                    $rs_bamboo = _query("SELECT * FROM bamboo ORDER BY modify_time DESC LIMIT $_pagenum,$_pagesize");
		                    while($rows_bamboo = _fetch_array_list($rs_bamboo)){
		                        //获取橙果数据
		                        $html_bamboo = array();
		                        $html_bamboo['id'] = $rows_bamboo['id'];
		                        $html_bamboo['title'] = $rows_bamboo['title'];
		                        $html_bamboo['type'] = $rows_bamboo['type'];
		                        $html_bamboo['username'] = $rows_bamboo['username'];
		                        $html_bamboo['check_bamboo'] = $rows_bamboo['check_bamboo'];
		                        $html_bamboo['time'] = $rows_bamboo['time'];
								//获取橙果对应的用户id
								$rows_user = _fetch_array("SELECT id FROM user WHERE username='{$html_bamboo['username']}' LIMIT 1");
								$html_user = array();
								$html_user['id'] = $rows_user['id'];
								//获取举报信息
								$rs_accuse = _is_repeat("SELECT * FROM accuse WHERE bambooid={$html_bamboo['id']}");
		                ?>
		                <tr>
		                    <td><? echo $html_bamboo['id']; ?></td><td><a href="bamboo_detail.php?id=<? echo $html_bamboo['id']; ?>" title="<? $html_bamboo['title']; ?>"><? if($rs_accuse){ echo '<img src="images/ico/accuse.png" class="accuse_ico" title="有人举报！" alt="" />'; }; ?><? echo _title($html_bamboo['title'],20)?></a></td><td><? echo '<a href="'._bamboo_url($html_bamboo['type']).'">'._bamboo_type($html_bamboo['type']).'</a>'; ?></td><td><? echo '<a href="user.php?id='.$html_user['id'].'">'.$html_bamboo['username'].'</a>'; ?></td><td><? echo $html_bamboo['time']; ?></td>
		                    <td>
		                        <?
		                        if($html_bamboo['check_bamboo'] == 0){
		                            echo '<div class="check">审核</div>';
									echo '<input type="hidden" class="article_id" value="'.$html_bamboo['id'].'" />';
		                        } else {
		                            echo '<div class="checked">已审核</div>';
									echo '<input type="hidden" class="article_id" value="'.$html_bamboo['id'].'" />';
		                        }
		                        ?>
		                        <a href="bamboo_modify?id=<? echo $html_bamboo['id'];?>"><div class="modify">修改</div></a>
		                        <input type="hidden" class="user_id" value="<? echo $html_user['id'];?>" />
		                        <div class="delete">删除</div>
		                    </td>
		                </tr>
		                <?
		                    }
		                    _free_result($rs_userid);
		                    _free_result($rs_bamboo);
		                ?>
		            </table>
		            <? _paging(2); ?>
		        </div>
		    </div>
		</div>

	</div>
</body>
</html>