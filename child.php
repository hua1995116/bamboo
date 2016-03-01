<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-其他用品</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/child.css" type="text/css" />
	<script src="scripts/slider.js" type="text/javascript"></script>
	<script src="scripts/common.js" type="text/javascript"></script>
	<script type="text/javascript" src="scripts/waterfall.js"></script>
	<script type="text/javascript" src="scripts/child.js"></script>
	<script type="text/javascript">
	window.onload=function(){
		waterfallInit({
			parent:'article_list',
			pin:'pin',
			successFn:success,
			loadImgSrc:'images/load.gif',
			requestUrl:'ajax_child.php',
			requestNum:1,
			style:1
		})
		function success(data) {
			$("#article_list").append(data);
			return true;
		}
	}
	</script>
</head>
<body>
	<?
		require 'includes/header.inc.php';
	?>
    <?
		require 'includes/head.php';
	?>
	<div id="body_bg"></div>
	<div id="body_area">

		<?
	        require 'includes/left_nav.inc.php';
	    ?>
	    <div id="body_r">
	    	<!-- 焦点图 -->
	    	<div class="focus">
    			<div id="screen" class="wrap clear">
				  	<div class="bd">
				    	<?
    						$rs_focus = _query("SELECT * FROM bamboo WHERE type=5 && check_bamboo=1 ORDER BY time DESC LIMIT 6");
	            			while ($rows_focus = _fetch_array_list($rs_focus)){
	            				$data_focus = array();
	            				$data_focus['id'] = $rows_focus['id'];
	            				$data_focus['username'] = $rows_focus['username'];
	                			$data_focus['img'] = $rows_focus['img'];
	                			$data_focus['title'] = $rows_focus['title'];
	            				echo '<div class="mt">
										<a href="bamboo_detail.php?id='.$data_focus['id'].'">'.$data_focus['img'].'</a>
										<div class="bg"></div>
							      		<div>
							        		<p>
							        			<a href="bamboo_detail.php?id='.$data_focus['id'].'" onfocus="this.blur()">'._title($data_focus['title'],12).'</a>
							        		</p>
							      		</div>
	            					</div>';
	            			}
    					?>
				  	</div>
				  	<div class="hd">
				    	<ul>
						    <?
    							$rs_focus_hd = _query("SELECT * FROM bamboo WHERE type=5 && check_bamboo=1 ORDER BY time DESC LIMIT 6");
		            			while ($rows_focus_hd = _fetch_array_list($rs_focus_hd)){
		            				$data_focus_hd = array();
		            				$data_focus_hd['id'] = $rows_focus_hd['id'];
		                			$data_focus_hd['img'] = $rows_focus_hd['img'];
		                			echo '<li>
									    	<a href="" onfocus="this.blur()">
									    		'.$data_focus_hd['img'].'
									    		<span class="mask"></span>
									    	</a>
									    </li>
		                			';
		                		}
    						?>
				    	</ul>
				  	</div>
				</div>
				<script>anisee.init.screens()</script>

	    	</div>
	    	<!-- 焦点图完 -->
	    	<div class="content_title1">
	        	<p>其他</p>
	        	<a href="top_child.php">查看完整排行</a>
	        </div>
	    	<!--瀑布流-->
	        <!--此处必须使用id-->
	        <div id="article_list">
				<?
	            $rs_fall = _query("SELECT * FROM bamboo WHERE type=5 && check_bamboo=1 ORDER BY modify_time DESC LIMIT 3");
	            while ($rows_fall = _fetch_array_list($rs_fall)){
	                $data_fall = array();
	                $data_fall['id'] = $rows_fall['id'];
	                $data_fall['username'] = $rows_fall['username'];
	                $data_fall['img'] = $rows_fall['img'];
	                $data_fall['title'] = $rows_fall['title'];
	                $data_fall['collect'] = $rows_fall['collect'];
	                $data_fall['comment'] = $rows_fall['comment'];
	                $data_fall_user = _fetch_array("SELECT id FROM user WHERE username='{$data_fall['username']}'");
	                $data_fall_userid = array();
	                $data_fall_userid['id'] = $data_fall_user['id'];
	                echo '
	                    <div class="pin">
	                        <div class="box">
	                            <a href="bamboo_detail.php?id='.$data_fall['id'].'">'.$data_fall['img'].'</a>
	                            <div class="note_area">
	                                <a href="bamboo_detail.php?id='.$data_fall['id'].'"><div class="bamboo_title">'._title($data_fall['title'],14).'</div></a>
	                                <div class="bamboo_author">发布人：<a href="user.php?id='.$data_fall_userid['id'].'">'.$data_fall['username'].'</a></div>
	                                <div class="bamboo_collect">'.$data_fall['collect'].'人收藏<img src="images/ico/_collect.png" /></div>
	                                <div class="bamboo_comment"><img src="images/ico/_comment.png" />'.$data_fall['comment'].'人评论</div>
	                                <div class="clear"></div>
	                            </div>
	                        </div>
	                    </div>';
	            }
	            ?>
	        </div>
	    </div>
	</div>
</body>
</html>