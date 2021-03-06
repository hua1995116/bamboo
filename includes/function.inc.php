<?
error_reporting(0);
//mysql_query
function _query($_sql) {
	if (!$_result = mysql_query($_sql)) {
		exit('  ');
	}
	return $_result;
}

/**
 * _fetch_array只能获取指定数据集一条数据组
 * @param $_sql
 */

function _fetch_array($_sql) {
	return mysql_fetch_array(_query($_sql));
}
/*跳转函数
 * info是显示字样url为地址
 */
function _location($_info,$_url){
	if(!empty($_info)){
		echo "<script type='text/javascript'>location.href='$_url';</script>";
		exit();
	}else{
		header('Location:'.$_url);
	}
}
/**
 * _fetch_array_list可以返回指定数据集的所有数据
 * @param $_result
 */

function _fetch_array_list($_result) {
	return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _num_rows($_result) {
	return mysql_num_rows($_result);
}

/**
 * _free_result销毁结果集
 * @param $_result
 */

function _free_result($_result) {
	mysql_free_result($_result);
}

//删除session
function _session_destroy() {
	if (session_start()) {
		session_destroy();
	}
}

//检测是否重名
function _is_repeat($_sql) {
	if (_fetch_array($_sql)) {
		return true;
	}else{
		return false;
		}
}

//原始版JS弹窗
function _alert_backs($_info) {
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
	exit();
}

//jquery_artDialog弹窗返回
function _alert_back($_icon,$_info,$_url) {
	if(!empty($_url)){
		echo "
			<script>
			$(function(){
				art.dialog({
					lock: true,
					background: '#000', 
					opacity: 0.87,
					content: '$_info',
					icon: '$_icon',
					ok: function () {
						location.href='$_url';
					},
					close:function(){
						location.href='$_url';
					}
				})
			})
			</script>";
	} else {
		echo "
			<script>
			$(function(){
				art.dialog({
					lock: true,
					background: '#000',
					opacity: 0.87,
					content: '$_info',
					icon: '$_icon',
					ok: function () {
						history.back();
					},
					close:function(){
						history.back();
					}
				})
			})
			</script>";
		exit();
	}
}

//验证码比对
function _check_code($_first_code,$_end_code) {
	if (strtolower($_first_code) != strtolower($_end_code)) {
		_alert_back('face-sad','验证码不正确!',null);
	}
}

//mysql_affected_rows()表示影响到的记录数
function _affected_rows() {
	return mysql_affected_rows();
}

/**
 * _insert_id
 */

function _insert_id() {
	return mysql_insert_id();
}

//设置cookies
function _setcookies($_username,$_time) {
	if (isset($_time)) {
		date_default_timezone_set('Asia/Shanghai');
		$_SESSION['username'] = $_username;
	} else {
		date_default_timezone_set('Asia/Shanghai');
		$_SESSION['username'] = $_username;
	}
}

//删除cookies
function _unsetcookies() {
	   date_default_timezone_set('Asia/Shanghai');
	setcookie('username','',time()-1);
	_session_destroy();
	header('Location:index.php');
}

//字符转义
function _mysql_string($_string) {
	//get_magic_quotes_gpc()如果开启状态，那么就不需要转义
	if (!GPC) {
		if (is_array($_string)) {
			foreach ($_string as $_key => $_value) {
				$_string[$_key] = _mysql_string($_value);   //递归
			}
		} else {
			$_string = mysql_real_escape_string($_string);
		}
	} 
	return $_string;
}

/**
 * _html() 函数表示对字符串进行HTML过滤显示，如果是数组按数组的方式过滤，
 * 如果是单独的字符串，那么就按单独的字符串过滤
 * @param unknown_type $_string
 */

function _html($_string) {
	if (is_array($_string)) {
		foreach ($_string as $_key => $_value) {
			$_string[$_key] = _html($_value);   //这里采用了递归，如果不理解，那么还是用htmlspecialchars
		}
	} else {
		$_string = htmlspecialchars($_string);
	}
	return $_string;
}

/**
 * _title()标题截取函数
 * @param $_string
 */

function _title($_string,$_strlen) {
	if (mb_strlen($_string,'utf-8') > $_strlen) {
		$_string = mb_substr($_string,0,$_strlen,'utf-8').'...';
	}
	return $_string;
}

function _close() {
	if (!mysql_close()) {
		exit('关闭异常');
	}
}

//转化成果类型为文字
function _bamboo_type($bamboo_type_num){
	switch ($bamboo_type_num){
		case 1:$bamboo_type_name="灯具";break;
		case 2:$bamboo_type_name="家具用品";break;
		case 3:$bamboo_type_name="装饰用品";break;
		case 4:$bamboo_type_name="日常用品";break;
		case 5:$bamboo_type_name="其他";break;
		case 6:$bamboo_type_name="创意类";break;
		default:return false;
	}
	return $bamboo_type_name;
}

//转化成果类型为网址
function _bamboo_url($bamboo_type_num){
	switch ($bamboo_type_num){
		case 1:$bamboo_type_url="social.php";break;
		case 2:$bamboo_type_url="daily.php";break;
		case 3:$bamboo_type_url="profession.php";break;
		case 4:$bamboo_type_url="indoor.php";break;
		case 5:$bamboo_type_url="child.php";break;
		case 6:$bamboo_type_url="idea.php";break;
		default:return false;
	}
	return $bamboo_type_url;
}

//转化成果类型为榜单网址
function _bamboo_top_url($bamboo_type_num){
		switch ($bamboo_type_num){
			case 1:$bamboo_type_url="top_social.php";break;
			case 2:$bamboo_type_url="top_daily.php";break;
			case 3:$bamboo_type_url="top_profession.php";break;
			case 4:$bamboo_type_url="top_indoor.php";break;
			case 5:$bamboo_type_url="top_child.php";break;
			case 6:$bamboo_type_url="top_idea.php";break;
			default:return false;
		}
		return $bamboo_type_url;
}

/**
 * 
 * @param $_sql
 * @param $_size
 */

function _page($_sql,$_size) {
	//将里面的所有变量取出来，外部可以访问
	global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num,$_list;
	if (isset($_GET['page'])) {
		$_page = $_GET['page'];
		if (empty($_page) || $_page <= 0 || !is_numeric($_page)) {
			$_page = 1;
		} else {
			$_page = intval($_page);
		}
	} else {
		$_page = 1;
	}
	$_pagesize = $_size;
	$_num = _num_rows(_query($_sql));
	if ($_num == 0) {
		$_pageabsolute = 1;
	} else {
		$_pageabsolute = ceil($_num / $_pagesize);
	}
	if ($_page > $_pageabsolute) {
		$_page = $_pageabsolute;
	}
	$_pagenum = ($_page - 1) * $_pagesize;
}

/**
 * _paging分页函数
 * @param $_type
 * @return 返回分页
 */

function _paging($_type) {
	global $_page,$_pageabsolute,$_num,$_id;
	if ($_type == 1) {
		$_list = 5;
		echo '<div id="page_num">';
		echo '<ul>';
				if ($_page == 1) {
					echo '<li class="no_page"><a>首页</a></li>';
					echo '<li class="no_page"><a>上一页</a></li>';
				} else {
					if ($_id == '') {
						echo '<li class="turn_page"><a href="'.SCRIPT.'.php">首页</a></li>';
						}else {
							echo '<li class="turn_page"><a href="'.SCRIPT.'.php?'.$_id.'">首页</a></li>';
						}
					echo '<li class="turn_page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a></li>';
				}
				if ($_page >= $_list) {
					$i = $_page - 3;
					$_list = $_page + 2;
						if ($_list >= $_pageabsolute) {
							$_list = $_pageabsolute;
							if ($_page == $_pageabsolute - 1 ) {
									$i = $_page - 4;
								}elseif ($_page == $_pageabsolute) {
									$i = $_page - 5;
								}
						}
					}else{
						$i = 0;
						if ($_list >= $_pageabsolute) {
							$_list = $_pageabsolute;
						}
					}
				for ($i;$i<$_list;$i++) {
						if ($_page == ($i+1)) {
							echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
						} else {
							echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
						}
				}
				if ($_page == $_pageabsolute) {
					echo '<li class="no_page"><a>下一页</a></li>';
					echo '<li class="no_page"><a>尾页</a></li>';
				} else {
				echo '<li class="turn_page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a></li>';
				echo '<li class="turn_page"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
				}
		echo '</ul>';
		echo '</div>';
	} elseif ($_type == 2) {
		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
		echo '<li>共有<strong>'.$_num.'</strong>条数据 | </li>';
				if ($_page == 1) {
					echo '<li>首页 | </li>';
					echo '<li>上一页 | </li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a> | </li>';
				}
				if ($_page == $_pageabsolute) {
					echo '<li>下一页 | </li>';
					echo '<li>尾页</li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
				}
		echo '</ul>';
		echo '</div>';
	} else {
		_paging(2);
	}
}

//mybamboo分页
function _paging_mybamboo($_type) {
	global $_page,$_pageabsolute,$_num,$_id;
	if ($_type == 1) {
		$_list = 5;
		echo '<div id="page_num">';
		echo '<ul>';
				if ($_page == 1) {
					echo '<li class="no_page"><a>上一页</a></li>';
				} else {
					if ($_id == '') {
						}else {
						}
					echo '<li class="turn_page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a></li>';
				}
				if ($_page >= $_list) {
					$i = $_page - 3;
					$_list = $_page + 2;
						if ($_list >= $_pageabsolute) {
							$_list = $_pageabsolute;
							if ($_page == $_pageabsolute - 1 ) {
									$i = $_page - 4;
								}elseif ($_page == $_pageabsolute) {
									$i = $_page - 5;
								}
						}
					}else{
						$i = 0;
						if ($_list >= $_pageabsolute) {
							$_list = $_pageabsolute;
						}
					}
				for ($i;$i<$_list;$i++) {
						if ($_page == ($i+1)) {
							echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
						} else {
							echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
						}
				}
				if ($_page == $_pageabsolute) {
					echo '<li class="no_page"><a>下一页</a></li>';
				} else {
				echo '<li class="turn_page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a></li>';;
				}
		echo '</ul>';
		echo '</div>';
	} elseif ($_type == 2) {
		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
		echo '<li>共有<strong>'.$_num.'</strong>条数据 | </li>';
				if ($_page == 1) {
					echo '<li>首页 | </li>';
					echo '<li>上一页 | </li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a> | </li>';
				}
				if ($_page == $_pageabsolute) {
					echo '<li>下一页 | </li>';
					echo '<li>尾页</li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
				}
		echo '</ul>';
		echo '</div>';
	} else {
		_paging(2);
	}
}

//user_show分页
function _paging_user($_type) {
	global $_page,$_pageabsolute,$_num,$_id;
	if ($_type == 1) {
		$_list = 5;
		echo '<div id="page_num">';
		echo '<ul>';
				if ($_page == 1) {
					echo '<li class="no_page"><a>首页</a></li>';
					echo '<li class="no_page"><a>上一页</a></li>';
				} else {
					if ($_id == '') {
						echo '<li class="turn_page"><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&">首页</a></li>';
						}else {
							echo '<li class="turn_page"><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&'.$_id.'">首页</a></li>';
						}
					echo '<li class="turn_page"><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&'.$_id.'page='.($_page-1).'">上一页</a></li>';
				}
				if ($_page >= $_list) {
					$i = $_page - 3;
					$_list = $_page + 2;
						if ($_list >= $_pageabsolute) {
							$_list = $_pageabsolute;
							if ($_page == $_pageabsolute - 1 ) {
									$i = $_page - 4;
								}elseif ($_page == $_pageabsolute) {
									$i = $_page - 5;
								}
						}
					}else{
						$i = 0;
						if ($_list >= $_pageabsolute) {
							$_list = $_pageabsolute;
						}
					}
				for ($i;$i<$_list;$i++) {
						if ($_page == ($i+1)) {
							echo '<li><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
						} else {
							echo '<li><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
						}
				}
				if ($_page == $_pageabsolute) {
					echo '<li class="no_page"><a>下一页</a></li>';
					echo '<li class="no_page"><a>尾页</a></li>';
				} else {
				echo '<li class="turn_page"><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&'.$_id.'page='.($_page+1).'">下一页</a></li>';
				echo '<li class="turn_page"><a href="'.SCRIPT.'.php?id='.$_GET['id'].'&&'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
				}
		echo '</ul>';
		echo '</div>';
	} elseif ($_type == 2) {
		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
		echo '<li>共有<strong>'.$_num.'</strong>条数据 | </li>';
				if ($_page == 1) {
					echo '<li>首页 | </li>';
					echo '<li>上一页 | </li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a> | </li>';
				}
				if ($_page == $_pageabsolute) {
					echo '<li>下一页 | </li>';
					echo '<li>尾页</li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
				}
		echo '</ul>';
		echo '</div>';
	} else {
		_paging(2);
	}
}

//时间转化
function _return_time($_string) {
	$_times = mktime() - strtotime($_string) + 8*3600;
	if ($_times <= 60) {
		$_time = $_times.'秒前';
	}elseif ($_times <= 3600) {
		$_time = ceil($_times/60 - 1).'分钟前';
		if($_time == '30分钟前'){
			$_time = '半小时前';
		}elseif($_time == '60分钟前'){
			$_time = '1小时前';
		}
	}elseif($_times <= 24*3600){
		$_time = ceil($_times/3600 - 1).'小时前';
	}elseif($_times <= 7*24*3600){
		$_time = ceil($_times/(24*3600) - 1).'天前';
	}elseif($_times < 365*24*3600){
		$_time = substr($_string,0,10);
	}else{
		$_time = ceil($_times/(365*24*3600) - 1).'年前';
	}
	return _mysql_string($_time);
}

//转换评分
function _trans_score($_score){
	if($_score == 90){
		$_star = 5;
	} else if($_score == 80){
		$_star = 4;
	} else if($_score == 70){
		$_star = 3;
	} else if($_score == 60){
		$_star = 2;
	} else if($_score == 50){
		$_star = 1;
	} else {
		$_star = 0;
	}
	return $_star;
}

//转换文字
function trans_level($_score){
	if($_score >= 50 && $_score < 60){
		$_level = "差";
	} else if($_score >= 60 && $_score < 70){
		$_level = "下";
	} else if($_score >= 70 && $_score < 80){
		$_level = "中";
	} else if($_score >= 80 && $_score < 90){
		$_level = "良";
	} else if($_score == 90){
		$_level = "优";
	} else {
		$_level = "无";
	}
	return $_level;
}

//等级转换
function trans_rank($_score){
	if($_score >= 50 && $_score <= 52){
		$_html = '<div class="img_stars"></div>';
	} else if($_score > 52 && $_score <= 60){
		$_html = '<div class="img_stars"></div><div class="img_stars"></div>';
	}
	 else if($_score > 60 && $_score <= 70){
		$_html = '<div class="img_stars"></div><div class="img_stars"></div><div class="img_stars"></div>';
	} else if($_score > 70 && $_score <= 80){
		$_html = '<div class="img_crowns"></div>';
	} else if($_score > 80 && $_score < 88){
		$_html = '<div class="img_crowns"></div><div class="img_crowns"></div>';
	} else if($_score >= 88 && $_score <= 90){
		$_html = '<div class="img_crowns"></div><div class="img_crowns"></div><div class="img_crowns"></div>';
	} else {
		$_html = '<div class="no_point">暂无等级</div>';
	}
	return $_html;
}


function _affect_row(){
	return mysql_affected_rows();
}
?>