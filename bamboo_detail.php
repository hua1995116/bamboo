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
	<script type="text/javascript" src="scripts/jquery.raty.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/jquery.pagination.css" />
	<script type="text/javascript" src="scripts/jquery.pagination.js"></script>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" href="styles/bamboo_detail.css" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script src="scripts/bamboo_detail.js" type="text/javascript"></script>
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
			$('#hiddenresult tr.show').removeClass('show');
			$('#hiddenresult tr:lt('+(page_index+1)*10+'):gt('+page_index*10+')').addClass('show');
			$('#hiddenresult tr:eq('+page_index*10+')').addClass('show');
			var new_content = $('#hiddenresult tr.show').clone();
			$('#Searchresult').empty().append(new_content);
			return false;
		}
		/** 
		 * Initialisation function for pagination
		 */
		function initPagination() {
			// count entries inside the hidden content
			var num_entries = jQuery('#hiddenresult tr').length;
			// Create content inside pagination element
			$("#Pagination").pagination(num_entries, {
				callback: pageselectCallback,
				prev_text:'上页',
				next_text:'下页',
				num_display_entries:5,
				items_per_page:10 // Show items per page
			});
		 }
		// When document is ready, initialize pagination
		$(document).ready(function(){
			initPagination();
		});	
	</script>
	<style type="text/css">
	#Pagination {
		width:500px;
	}
	</style>
	<?
	if ($_GET['action'] == 'contact') {
		$_clean_c = array();
		$_clean_c['contact_author_id'] = $_POST['contact_author_id'];
		$_clean_c['contact_user_id'] = $_POST['contact_user_id'];
		$_clean_c['contact_id'] = $_POST['contact_id'];
		$_clean_c['say'] = $_POST['say'];
		if(!!$_SESSION['username']){
			if($_clean_c['say'] != '在此输入要对他说的话，不能超过100个字'){
				if($_clean_c['contact_user_id'] != $_clean_c['contact_author_id']){
					_query(
					"INSERT INTO contact (userid,beuserid,bambooid,say,time) VALUES ('{$_clean_c['contact_user_id']}','{$_clean_c['contact_author_id']}','{$_clean_c['contact_id']}','{$_clean_c['say']}',NOW())"
					);
					if (_affected_rows() == 1) {
						mysql_close();
						_alert_back('face-smile','提交成功！','bamboo_detail.php?id='.$_clean_c['contact_id'].'');
					} else {
						mysql_close();
						_alert_back('face-sad','提交失败！','bamboo_detail.php?id='.$_clean_c['contact_id'].'');
					}
				} else {
					_alert_back('face-sad','自己就别对自己说了吧！',null);
				}
			} else {
				_alert_back('face-sad','内容不能为空！',null);
			}
		} else {
			_alert_back('face-sad','请先登录！',null);
		}
	}
	if ($_GET['action'] == 'accuse') {
		$_clean = array();
		$_clean['reason'] = $_POST['reason'];
		$_clean['email'] = $_POST['email'];
		$_clean['id'] = $_POST['id'];
		_query(
		"INSERT INTO accuse (bambooid,reason,email,time) VALUES ('{$_clean['id']}','{$_clean['reason']}','{$_clean['email']}',NOW())"
		);
		if (_affected_rows() == 1) {
			mysql_close();
			_alert_back('face-smile','举报成功！','bamboo_detail.php?id='.$_clean['id'].'');
		} else {
			mysql_close();
			_alert_back('face-sad','举报失败！','bamboo_detail.php?id='.$_clean['id'].'');
		}
	}

	if (isset($_GET['id'])) {
		if(!!$rows_bamboo = _fetch_array("SELECT * FROM bamboo WHERE id='{$_GET['id']}'")){
		
			//累积阅读量
			_query("UPDATE bamboo SET hit=hit+1 WHERE id='{$_GET['id']}'");
			
			//提取艺竹信息
			$html_bamboo = array();
			$html_bamboo['username'] = $rows_bamboo['username'];
			$html_bamboo['type'] = $rows_bamboo['type'];
			$html_bamboo['title'] = $rows_bamboo['title'];
			$html_bamboo['content'] = $rows_bamboo['content'];
			$html_bamboo['id'] = $rows_bamboo['id'];
			$html_bamboo['hit'] = $rows_bamboo['hit'];
			$html_bamboo['collect'] = $rows_bamboo['collect'];
			$html_bamboo['comment'] = $rows_bamboo['comment'];
			$html_bamboo['modify_time'] = $rows_bamboo['modify_time'];
			
			$rows_author = _fetch_array("SELECT * FROM user WHERE username='{$html_bamboo['username']}'");
			
			//提取用户信息
			$html_author = array();
			$html_author['id'] = $rows_author['id'];
			$html_author['username'] = $rows_author['username'];
			$html_author['email'] = $rows_author['email'];
			$html_author['qq'] = $rows_author['qq'];
			$html_author['phone'] = $rows_author['phone'];
			
			//提取评论
			$rs_comment = _query("SELECT * FROM comment WHERE bambooid='{$_GET['id']}' ORDER BY time DESC");
			
			//提取得分
			$rows_score = _fetch_array("SELECT * FROM bamboo WHERE id='{$_GET['id']}'");
			$html_score = array();
			$html_score['score'] = $rows_score['score'];
			$html_score['score_model'] = $rows_score['score_model'];
			$html_score['score_color'] = $rows_score['score_color'];
			$html_score['score_material'] = $rows_score['score_material'];
			$html_score['score_fashion'] = $rows_score['score_fashion'];
			
			//提取举报
			$rs_accuse = _query("SELECT * FROM accuse WHERE bambooid='{$_GET['id']}'");
		} else {
			_alert_back('error','不存在该作品！',null);
		}
	}

    //获取浏览者信息
	$html_visit = array();
	if(!!$_SESSION['username']){
		$html_visit['username'] = $_SESSION['username'];
		$rows_visit = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
		$html_visit['id'] = $rows_visit['id'];
		$html_visit['username'] = $rows_visit['username'];
		$html_visit['face'] = $rows_visit['face'];
		$html_visit['email'] = $rows_visit['email'];
		$html_visit['gag'] = $rows_visit['gag'];
	} else{
		$html_visit['username'] = "游客";
	}

	?>
	<title>艺竹-<? echo $html_bamboo['title']; ?></title>
</head>
<body>
	<?
		/*require 'includes/hide_nav.php';*/
	?>
	<?
		require 'includes/header.inc.php';
	?>
	<div class="head1"> 
	  <a href="index.php"><img src="images/logo.png"></a>
	</div>
	<div class="head2">
		<img src="images/head4.png">
	</div>
	<div id="body_area">

		<div class="nav_left">
	        <div class="nav_title1 all_title">同类热门</div>
	        <div class="_msg1">
	        	<div class="like_article">
	            	<ul>
	                	<?
						$rs_like = _query("SELECT * FROM bamboo WHERE type='{$html_bamboo['type']}' && check_bamboo=1 ORDER BY hit DESC LIMIT 3");
						while($rows_like = _fetch_array_list($rs_like)){
							$html_like = array();
							$html_like['id'] = $rows_like['id'];
							$html_like['img'] = $rows_like['img'];
							$html_like['title'] = $rows_like['title'];
							echo '
								<li class="article_list">
									<a href="bamboo_detail.php?id='.$html_like['id'].'" class="show_img">'.$html_like['img'].'</a>
									<div class="article_title"><a href="bamboo_detail.php?id='.$html_like['id'].'" title="'.$html_like['title'].'">'._title($html_like['title'],14).'</a></div>
								</li>
							';
						}
	                    ?>
	                </ul>
	            </div>
	        </div>
		</div>
    	<div id="body_r">
	    	<div id="detail">
	    		<div class="title_area1">
	    			<div class="back_list"><a href="javascript:history.go(-1);"><img src="images/to_left.png" alt="" />返回列表</a></div>
	    			<div class="article_detail_path">
                        <ul>
                            <li><a href="index.php">首页</a></li>
                            <li><a href="<? echo _bamboo_url($html_bamboo['type']);?>"><? echo _bamboo_type($html_bamboo['type']);?></a></li>
                            <li><a href="bamboo_detail.php?id=<? echo $_GET['id'];?>" class="location">竹工艺品详情</a></li>
                        </ul>
                    </div>
	    			<div class="to_info">详细信息<img src="images/to_right.png" alt="" /></div>
	    		</div>
	    		<div class="bamboo_title"><? echo $html_bamboo['title']; ?></div>
	    		<div class="accuse">举报</div>
	    		<div class="bamboo_msg">
	    			<div class="bamboo_time"><? echo $html_bamboo['modify_time']; ?></div>
	    			<div class="bamboo_username">作者：<a href=""><? echo $html_bamboo['username']; ?></a></div>
	    			<div class="bamboo_hit">浏览：<? echo $html_bamboo['hit']; ?></div>
	    			<div class="bamboo_comment">评论：<? echo $html_bamboo['comment']; ?></div>
	    			<div class="bamboo_collect">收藏：<? echo $html_bamboo['collect']; ?></div>
	    			<input type="hidden" name="bamboo_type" class="bamboo_type" value="<? echo $html_bamboo['type'];?>" />
	    			<div class="share">
	    				<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
						<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
					</div>
	    		</div>
	    		<div class="clear"></div>
	    		<div class="bamboo_content"><? echo htmlspecialchars_decode($html_bamboo['content']); ?></div>
	    		<div class="clear"></div>
	    		<div class="see_score"><img src="images/ico/point.png" alt="" /><b>与我订购</b></div>
                <div class="see_comment"><img src="images/ico/_comment_.png" alt="" /><b>查看评论</b></div>
                <div class="contact"><img src="images/ico/contact.png" alt="" /><b>联系作者</b></div>
                <div class="clear"></div>
                <?
					$rows_pre_bamboo = _fetch_array("SELECT id,title FROM bamboo WHERE type='{$html_bamboo['type']}' && id<'{$_GET['id']}' LIMIT 1");
					$html_pre_bamboo = array();
					$html_pre_bamboo['id'] = $rows_pre_bamboo['id'];
					$html_pre_bamboo['title'] = $rows_pre_bamboo['title'];
					$rows_next_bamboo = _fetch_array("SELECT id,title FROM bamboo WHERE type='{$html_bamboo['type']}' && id>'{$_GET['id']}' LIMIT 1");
					$html_next_bamboo = array();
					$html_next_bamboo['id'] = $rows_next_bamboo['id'];
					$html_next_bamboo['title'] = $rows_next_bamboo['title'];
				?>
                <div class="more_bamboo">
   	  				<div class="pre_bamboo">
                    <?
						if($html_pre_bamboo['title'] == ''){ 
							echo '上一个：没有了'; 
						} else {
							echo '<a href="bamboo_detail.php?id='.$html_pre_bamboo['id'].'">上一个：'.$html_pre_bamboo['title'].'</a>';
						}
					?>
                    </div>
                    <div class="next_bamboo">
                    <?
						if($html_next_bamboo['title'] == ''){ 
							echo '下一个：没有了'; 
						} else {
							echo '<a href="bamboo_detail.php?id='.$html_next_bamboo['id'].'">下一个：'.$html_next_bamboo['title'].'</a>';
						}
					?>
                    </div>
                </div>
		    </div>
	    	<div id="info">
	    		<div class="title_area1">
            		<div class="back_article"><img src="images/to_left.png" alt="" />返回原文</div>
            	</div>
            	<div class="info_area">
            		<div class="detail_title"><? echo $html_bamboo['title']; ?><p>（已评价）</p></div>
            		<div class="info">
                    	<ul>
                    		<li class="info_username">作者：<span><? echo '<a href="user.php?id='.$html_author['id'].'">'.$html_bamboo['username'].'</a>'; ?></span></li>
                            <li class="info_time">发布：<span><? echo _return_time($html_bamboo['modify_time']); ?></span></li>
                            <li class="info_hit">阅读量：<span><? echo $html_bamboo['hit']; ?></span></li>
                            <li class="info_collect">收藏量：
                            <span>
                                <strong><? echo $html_bamboo['collect']; ?></strong>
                                <? 
                                    $_collection = 0;
                                    $rs_col = _query("SELECT * FROM collect WHERE bambooid='{$_GET['id']}'");
                                    while(!!$rows_col = _fetch_array_list($rs_col)){
                                        $html_cl['id'] = $rows_col['userid'];
                                        if($html_cl['id'] == $html_visit['id']) {
                                            $_collection = 1;
                                        }
                                    }
                                    _free_result($rs_col);
                                    //判断是否已收藏
                                    if($_collection == 0) {
                                        if(!$_SESSION['username']) {
                                            echo '
                                            <span class="collect no_reg_col">+收藏</span>
                                            <span class="collect_has" style="display:none;">已收藏</span>';
                                        } else {
                                            echo '
                                            <span class="collect">+收藏</span>
                                            <span class="collect_has" style="display:none;">已收藏</span>';
                                        }
                                    } else {
                                        echo '
                                        <span class="collect_has">已收藏</span>';
                                    }
                                ?>
                            </span></li>
                            <li class="info_comment">评论量：<span><strong><? echo _num_rows($rs_comment); ?></strong></span></li>
                            <li class="info_accuse">举报量：<span><strong><? echo _num_rows($rs_accuse); ?></strong></span></li>
                        </ul>
                    </div>

                	<!--评分-->
                    <div class="score">
                    	<!--评分园-->
                        <div class="score_show" title="点击查看历史评分">
                        	<div class="score_show_model">
                            	
                            </div>
                        	<div class="score_show_color">
                            	
                            </div>
                            <div class="clear"></div>
                            <div class="score_show_fashion">
								
                            </div>
                            <div class="score_show_material">
								
                            </div>
                        </div>
                        <div class="all_score"><p>等级：</p><? echo trans_rank($html_score['score']); ?></div>
                        <!--评分区域-->
                        <div class="score_input">
                        	<div class="score_title">我来评分</div>
                            <div class="clear"></div>
                            <div class="score_input_model">
                            	<p>实用</p>
                                <div id="star_input_model" class="star_input_model"></div>
                                <div id="hint_input_model" class="hint_input_model"></div>
                            </div>
                            <div class="clear"></div>
                            <div class="score_input_color">
                            	<p>创意</p>
                                <div id="star_input_color" class="star_input_color"></div>
                                <div id="hint_input_color" class="hint_input_color"></div>
                            </div>
                            <div class="clear"></div>
                            <div class="score_input_material">
                            	<p>材质</p>
                                <div id="star_input_material" class="star_input_material"></div>
                                <div id="hint_input_material" class="hint_input_material"></div>
                            </div>
                            <div class="clear"></div>
                            <div class="score_input_fashion">
                            	<p>时尚</p>
                                <div id="star_input_fashion" class="star_input_fashion"></div>
                                <div id="hint_input_fashion" class="hint_input_fashion"></div>
                            </div>
                            <div class="clear"></div>
                            <div class="score_submit">确定</div>
                        </div>
                    </div>
                    <!--评分结束-->

                	<!-- 评论区 -->
                	<div class="comment_reply">
                    	<?
                    	if (!$_SESSION['username']){
                    		echo '
								<img src="face/default.jpg" alt="face" />
								<div class="visit_name">未登录</div>
							';
                        } else {
							echo'
							<img src="'.$html_visit['face'].'" alt="face" />
							<div class="visit_name">'.$html_visit['username'].'</div>
							';
                        }
                        ?>
                        <input type="hidden" name="userid" class="userid" value="<? echo $html_visit['id'];?>" />
                        <input type="hidden" name="bambooid" class="bambooid" value="<? echo $_GET['id'];?>" />
                        <textarea name="content" class="content"></textarea>
                        <?
                        if (!$_SESSION['username']){
                            echo '<input type="submit" name="submit" class="submit no_reg_com" value="提交评论" />';
                        } else if ($html_visit['gag'] == 0){
							echo '<input type="submit" name="submit" class="submit gag" disabled="disabled" value="你已被禁言" />';
						} else {
                            echo '<input type="submit" name="submit" class="submit" value="提交评论" />';
                        }
                        ?>
                        <span></span>
                    </div>
                    <div class="comment_list">
                    	<div class="comment_list_title">全部评论（共<span><? echo _num_rows($rs_comment); ?></span>条）</div>
                        <?
							echo '<input type="hidden" class="comment_num" value="'._num_rows($rs_comment).'" />';
                        ?>
                        <?
						if(_num_rows($rs_comment) == 0){
							$_flag = 0;
							echo '<div class="no_comment">还没有评论，快来抢沙发！</div>';
						} else{
							$_flag = 1;
							$comment_i = (_num_rows($rs_comment))+1;
							$comment_show_i = 0;
							while(!!$rows_comment = _fetch_array_list($rs_comment)){
								//提取评论
								$html_c = array();
								$html_c['userid'] = $rows_comment['userid'];
								$html_c['comment'] = $rows_comment['comment'];
								$html_c['time'] = $rows_comment['time'];
								$comment_i -= 1;
								//评论用户
								$rs_c_a = _query("SELECT * FROM user WHERE id='{$html_c['userid']} LIMIT 1'");
								while(!!$rows_c_a = _fetch_array_list($rs_c_a)){
									//提取发表评论用户的信息
									$html_c_a = array();
									$html_c_a['id'] = $rows_c_a['id'];
									$html_c_a['face'] = $rows_c_a['face'];
									$html_c_a['username'] = $rows_c_a['username'];
									$comment_show_i += 1;
									if($comment_show_i >= 6){
										echo '
										<div class="comment_hide_floor">
											<a href="user.php?id='.$html_c_a['id'].'"><img src="'.$html_c_a['face'].'" alt="face" /></a>
											<a href="user.php?id='.$html_c_a['id'].'"><div class="comment_a">'.$html_c_a['username'].'</div></a>
											<div class="comment_t">'.$html_c['time'].'</div>
											<div class="comment_n">'.$comment_i.'楼</div>
											<div class="comment_c">'.$html_c['comment'].'</div>
										</div>';
									} else{
									echo '
									<div class="comment_floor">
										<a href="user.php?id='.$html_c_a['id'].'"><img src="'.$html_c_a['face'].'" alt="face" /></a>
										<a href="user.php?id='.$html_c_a['id'].'"><div class="comment_a">'.$html_c_a['username'].'</div></a>
										<div class="comment_t">'.$html_c['time'].'</div>';
										if($comment_i == 1){
											echo '
											<div class="comment_n">沙发</div>';
										} else{
											echo '
											<div class="comment_n">'.$comment_i.'楼</div>';
										}
										echo '<div class="comment_c">'.$html_c['comment'].'</div>';
									echo '</div>';
									}
								}
							}
						}
						if($_flag == 1){
                        	echo '<div class="showmore">点击显示剩余评论</div>';
						}
						?>
                    </div>
                </div>
	    	</div>

	    </div>
	</div>

	<!--所有评分展示-->
	<div id="score_his_area">
		<div class="score_his">
	    	<table class="score_his_title" cellspacing="0">
	        	<tr>
	            	<th width="28%"><? echo $html_bamboo['title']; ?></th><th width="18%">样式30%</th><th width="18%">色彩20%</th><th width="18%">原料30%</th><th width="18%">时尚20%</th>
	            </tr>
	        </table>
	        <table id="Searchresult" class="score_his_show" cellspacing="0"></table>
	        <div class="clear"></div>
	        <div id="Pagination"></div>
	        <div class="clear"></div>
	        <table id="hiddenresult" style="display:none">
	        <?
	            $rs_star = _query("SELECT * FROM score WHERE bambooid={$_GET['id']} ORDER BY id DESC");
	            while($rows_star = _fetch_array_list($rs_star)){
	                $html_star = array();
					$html_star['id'] = $rows_star['id'];
	                $html_star['userid'] = $rows_star['userid'];
	                $html_star['score_model'] = $rows_star['score_model'];
	                $html_star['score_color'] = $rows_star['score_color'];
	                $html_star['score_material'] = $rows_star['score_material'];
	                $html_star['score_fashion'] = $rows_star['score_fashion'];
	                $rows_star_user = _fetch_array("SELECT * FROM user WHERE id={$html_star['userid']}");
	                $html_star_user = array();
	                $html_star_user['username'] = $rows_star_user['username'];
	        ?>
	                    <tr>
	                        <td width="28%"><? echo $html_star_user['username']; ?></td>
	                        <td width="18%">
	                            <div id="star_his_model" class="star_his_model" data-score="<? echo _trans_score($html_star['score_model']); ?>"></div>
	                        </td>
	                        <td width="18%">
	                            <div id="star_his_color" class="star_his_color" data-score="<? echo _trans_score($html_star['score_color']); ?>"></div>
	                        </td>
	                        <td width="18%">
	                            <div id="star_his_material" class="star_his_material" data-score="<? echo _trans_score($html_star['score_material']); ?>"></div>
	                        </td>
	                        <td width="18%">
	                            <div id="star_his_fashion" class="star_his_fashion" data-score="<? echo _trans_score($html_star['score_fashion']); ?>"></div>
	                        </td>
	                    </tr>
	                <?
	            }
	        ?>
	        </table>
	    </div>
	    <?
			$rs_type_star = _query("SELECT * FROM bamboo WHERE type='{$html_bamboo['type']}'");
			$rs_over_star = _query("SELECT * FROM bamboo WHERE type='{$html_bamboo['type']}' && score<'{$html_score['score']}'");
			$_over_num = number_format(_num_rows($rs_over_star)/_num_rows($rs_type_star),3);
		?>
	    <div class="last_score">等级：</div>
	    <?
			echo trans_rank($html_score['score']);
	    ?>
	    <div class="over_star"><p>超过了</p><strong><? echo $_over_num*100; ?>%</strong><p>的同类其他作品</p></div>
	    <div class="see_top"><a href="buy.php?id=<? echo $html_bamboo['id'] ?>">点击购买</a></div>
<!--	    <a href="<? echo _bamboo_top_url($html_bamboo['type']); ?>">-->
	</div>

	<!--联系作者-->
	<script type="text/javascript">
	function ismaxlength(obj){
		var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
		if (obj.getAttribute && obj.value.length>mlength)
			obj.value=obj.value.substring(0,mlength)
	}
	</script>
	<div id="contact_area">
		<div class="contact_body">
	    	<ul>
	        	<li><strong><? echo $html_bamboo['title']; ?></strong></li>
	        	<li><p>作者：</p><a href="user.php?id=<? echo $html_u['id']; ?>"><? echo $html_author['username']; ?></a></li>
	            <li><p>邮箱：</p><? echo $html_author['email']; ?></li>
	            <li><p>Q&nbsp;Q：</p><? if($html_author['qq'] == ''){ echo '未填写'; } else { echo $html_author['qq']; } ?></li>
	            <li><p>电话：</p><? if($html_author['phone'] == ''){ echo '未填写'; } else { echo $html_author['phone']; } ?></li>
	        </ul>
	        <form method="post" name="contact" action="?action=contact">
	        	<input type="hidden" name="contact_author_id" value="<? echo $html_author['id']; ?>" />
	            <input type="hidden" name="contact_user_id" value="<? echo $html_visit['id']; ?>" />
	            <input type="hidden" name="contact_id" value="<? echo $_GET['id']; ?>" />
	        	<textarea name="say" maxlength="100" onkeyup="return ismaxlength(this)">在此输入要对他说的话，不能超过100个字</textarea>
	            <input type="submit" class="contact_submit" value="提交" />
	        </form>
	    </div>
	</div>

	<!--举报区域-->
	<div id="accuse_area">
		<form method="post" name="accuse" action="?action=accuse">
	        <div class="accuse_reason">
	            <p>举报原因：</p>
	            <textarea name="reason" maxlength="100" onkeyup="return ismaxlength(this)">请输入举报理由</textarea>
	            <div class="accuse_reason_note">举报原因不得超过100个字！</div>
	        </div>
	        <div class="accuse_email">
	            <p>你的邮箱：</p>
	            <input type="text" name="email" value="<? echo $html_visit['email']; ?>" maxlength="40" />
	            <div class="accuse_email_note"></div>
	        </div>
	        <input type="hidden" name="id" value="<? echo $_GET['id']; ?>" />
	        <input type="submit" class="accuse_submit" value="确认举报" />
	        <div class="accuse_submit_note">存在错误，无法提交</div>
	    </form>
	</div>
</body>
</html>