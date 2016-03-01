<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-家居用品</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/top.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="styles/jquery.pagination.css" />
	<script type="text/javascript" src="scripts/jquery.pagination.js"></script>
	<script type="text/javascript" src="scripts/top.js"></script>
	<script type="text/javascript">
		/**
		 * Callback function that displays the content.
		 *
		 * Gets called every time the user clicks on a pagination link.
		 *
		 * @param {int} page_index New Page index
		 * @param {jQuery} jq the container with the pagination links as a jQuery object
		 */
		function pageselectCallback(page_index, jq){
			$('#hiddenresult li.show').removeClass('show');
			$('#hiddenresult li:lt('+(page_index+1)*5+'):gt('+page_index*5+')').addClass('show');
			$('#hiddenresult li:eq('+page_index*5+')').addClass('show');
			var new_content = $('#hiddenresult li.show').clone();
			$('#Searchresult').empty().append(new_content);
			return false;
		}
		/** 
		 * Initialisation function for pagination
		 */
		function initPagination() {
			// count entries inside the hidden content
			var num_entries = jQuery('#hiddenresult li').length;
			// Create content inside pagination element
			$("#Pagination").pagination(num_entries, {
				callback: pageselectCallback,
				prev_text:'上页',
				next_text:'下页',
				num_display_entries:8,
				items_per_page:5 // Show items per page
			});
		 }
		// When document is ready, initialize pagination
		$(document).ready(function(){
			initPagination();
		});	
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
	    	<div class="title_area">
	    		<div class="article_detail_path">
	                <ul>
	                    <li><a href="index.php">首页</a></li>
	                    <li><a href="daily.php">家具用品</a></li>
	                    <li><a href="top_daily.php" class="location">家具用品排行</a></li>
	                </ul>
	            </div>
	        </div>
	        <div class="top_header">
	        	<ul>
	            	<li><a href="top_social.php">灯具</a></li>
	                <li class="selected">家具用品</li>
	                <li><a href="top_profession.php">装饰用品</a></li>
	                <li><a href="top_indoor.php">日常用品</a></li>
	                <li><a href="top_child.php">其他</a></li>
	                
	            </ul>
	        </div>
	        <div class="top_body">
	        	<ul id="Searchresult"></ul>
	            <div class="clear"></div>
	            <div id="Pagination"></div>
	            <div class="clear"></div>
	        	<ul id="hiddenresult" style="display:none">
					<?
						$_i = 0;
	                    $rs_top = _query("SELECT * FROM bamboo WHERE type=2 && check_bamboo=1 ORDER BY score DESC");
	                    while($rows_top = _fetch_array_list($rs_top)){
	                        $html_top = array();
	                        $html_top['id'] = $rows_top['id'];
							$html_top['username'] = $rows_top['username'];
							$html_top['img'] = $rows_top['img'];
							$html_top['title'] = $rows_top['title'];
							$html_top['score'] = $rows_top['score'];
							$html_top['time'] = $rows_top['time'];
							$_i += 1;
	                        echo '<li>';
							if($_i == 1){
								echo '<div class="top_rank1"></div>';
							} else if($_i == 2){
								echo '<div class="top_rank2"></div>';
							} else if($_i == 3){
								echo '<div class="top_rank3"></div>';
							} else if($_i == 4){
								echo '<div class="top_rank4"></div>';
							} else if($_i == 5){
								echo '<div class="top_rank5"></div>';
							} else if($_i == 6){
								echo '<div class="top_rank6"></div>';
							} else if($_i == 7){
								echo '<div class="top_rank7"></div>';
							} else if($_i == 8){
								echo '<div class="top_rank8"></div>';
							} else if($_i == 9){
								echo '<div class="top_rank9"></div>';
							} else if($_i == 10){
								echo '<div class="top_rank10"></div>';
							} else if($_i == 11){
								echo '<div class="top_rank11"></div>';
							} else if($_i == 12){
								echo '<div class="top_rank12"></div>';
							} else if($_i == 13){
								echo '<div class="top_rank13"></div>';
							} else if($_i == 14){
								echo '<div class="top_rank14"></div>';
							} else{
								echo '<div class="top_rank15"></div>';
							}
							echo '	
									<div class="top_img"><a href="bamboo_detail.php?id='.$html_top['id'].'">'.$html_top['img'].'</a></div>
									<div class="top_msg">
										<div class="top_title"><a href="bamboo_detail.php?id='.$html_top['id'].'" title="'.$html_top['title'].'">'._title($html_top['title'],10).'</a></div>
										<div class="top_user">发布人：'.$html_top['username'].'</div>
										<div class="top_time">发布时间：'._return_time($html_top['time']).'</div>
										<div class="top_score"><p>等级：</p>'.trans_rank($html_top['score']).'</div>
									</div>
								</li>';
	                    }
	                ?>
	            </ul>
	        </div>
	    </div>
	</div>
</body>
</html>