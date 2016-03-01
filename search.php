<?php
//定义个常量，用来指定本页的内容
define('SCRIPT','search');
//引入公共文件
require 'includes/common.inc.php';

//接收数据
if(isset($_GET['type']) && isset($_GET['key'])){
	$_type = $_GET['type'];
	$_keyword = $_GET['key'];
}else{
	$_type = $_POST['type'];
	$_keyword = $_POST['key'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-搜索</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" type="text/css" href="styles/search.css" />
	<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?
		require 'includes/header.inc.php';
	?>
	<?
		require 'includes/head.php';
	?>


	<div id="body_area">
		
		<?
	        require 'includes/left_nav.inc.php';
	    ?>
	    <div id="body_r">
	    	<div class="search_title"><div class="search_ico"></div>搜索结果</div>
	        <div class="search_tip"><p>搜索</p><p class="red"><? echo $_keyword;?></p><p>的结果如下：</p></div>
	        <div class="clear"></div>
	        <div class="search_res">
	        	<ul>
	            <?
					$rs_search = _query("SELECT * FROM bamboo WHERE title LIKE '%$_keyword%' ORDER BY modify_time DESC");
					while($rows_search = _fetch_array_list($rs_search)){
						//获取橙果信息
						$html_search = array();
						$html_search['id'] = $rows_search['id'];
						$html_search['title'] = $rows_search['title'];
						$html_search['img'] = $rows_search['img'];
						$html_search['type'] = $rows_search['type'];
						$html_search['score'] = $rows_search['score'];
						$html_search['username'] = $rows_search['username'];
						$html_search['time'] = $rows_search['time'];
						//正则替换
						$html_search_red['title'] = preg_replace("/($_keyword)/i","<strong><span>\\1</span></strong>",$html_search['title']);
						//获取作者信息
						$rows_author = _fetch_array("SELECT id FROM user WHERE username='{$html_search['username']}'");
						$html_author = array();
						$html_author['id'] = $rows_author['id'];
						echo '
							<li>
								<input type="hidden" value="'.$html_search['title'].'" />
								<a href="bamboo_detail.php?id='.$html_search['id'].'" class="show_img">'.$html_search['img'].'</a>
								<div class="search_msg">
								<div class="bamboo_title"><a href="bamboo_detail.php?id='.$html_search['id'].'">'.$html_search_red['title'].'</a></div>
								<div class="bamboo_level"><p>等级：</p>'.trans_rank($html_search['score']).'</div>
									<div class="clear"></div>
									<div class="bamboo_username">作者：<a href="user.php?id='.$html_author['id'].'">'.$html_search['username'].'</a></div>
									<div class="bamboo_type">类型：<a href="'._bamboo_url($html_search['type']).'">'._bamboo_type($html_search['type']).'</a></div>
									<div class="bamboo_time">发布时间：'._return_time($html_search['time']).'</div>
								</div>
							</li>';
							$_result = 1;
					}
					
					//未搜索到信息
					if (!isset($_result)) {
						echo '<div id="blank">未搜索到相关信息</div>';
					}
				?>
				</ul>
	        </div>
	        <div class="clear"></div>
	        <div class="search_user_res">
	        	<ul>
					<?
					$rs_search_user = _query("SELECT * FROM user WHERE username LIKE '%$_keyword%' ORDER BY bamboo_num DESC");
					if(_num_rows($rs_search_user) != 0){
						echo '<div class="search_user_title">以下是用户搜索信息：</div>
							<div class="clear"></div>';
					}
					while($rows_search_user = _fetch_array_list($rs_search_user)){
						//获取用户数据
						$html_search_user = array();
						$html_search_user['id'] = $rows_search_user['id'];
						$html_search_user['username'] = $rows_search_user['username'];
						$html_search_user['face'] = $rows_search_user['face'];
						//正则替换
						$html_search_user_red['username'] = preg_replace("/($_keyword)/i","<strong><span>\\1</span></strong>",$html_search_user['username']);
						echo '
							<li>
								<a href="user.php?id='.$html_search_user['id'].'" target="_blank"><div class="user_face"><img src="'.$html_search_user['face'].'" alt="" /></div></a>
								<a href="user.php?id='.$html_search_user['id'].'" target="_blank"><div class="user_name">'.$html_search_user_red['username'].'</div></a>
							</li>
						';
					}
				?>
	            </ul>
	        </div>
	    </div>
	</div>
</body>
</html>