<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
//头像随机名
if (strlen($_SESSION['random_key'])==0){
    $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s'));
	$_SESSION['user_file_ext']= "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-我的资料</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" type="text/css" href="styles/imgareaselect-default.css" />
	<script type="text/javascript" src="scripts/jquery.imgareaselect.min.js"></script>
	<link href="styles/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.datepick.chinese.js"></script>
	<link rel="stylesheet" href="styles/hide_nav.css" type="text/css" />
	<link rel="stylesheet" href="styles/home_com.css" type="text/css" />
	<link rel="stylesheet" href="styles/mydata.css" type="text/css" />
	<script type="text/javascript" src="scripts/hide_nav.js"></script>
	<script type="text/javascript" src="scripts/mydata.js"></script>
	<script>
	$(function() {
	    $( "#birthday" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "images/birthday.png",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			yearRange: "1950:2020"
		});
	});
	</script>
	<?
	//是否正常登录
	if (isset($_SESSION['username'])) {
		//获取用户数据
		$rows_user = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
		$html_u = array();
		$html_u['username'] = $rows_user['username'];
		$html_u['password'] = $rows_user['password'];
		$html_u['sex'] = $rows_user['sex'];
		$html_u['birthday'] = $rows_user['birthday'];
		$html_u['content'] = $rows_user['content'];
		$html_u['email'] = $rows_user['email'];
		$html_u['phone'] = $rows_user['phone'];
		$html_u['qq'] = $rows_user['qq'];
		$html_u['face'] = $rows_user['face'];
		$html_u['reg_time'] = $rows_user['reg_time'];
		//头像处理
		if($html_u['face'] !='face/default.jpg') {
			$_htmls['face'] = preg_replace("/thumbnail*/","resize",$html_u['face']);
		}
	} else {
		_alert_back('error','非法登录！','index.php');
	}

	//基本信息
	if ($_GET['action'] == 'basic') {
		//引入验证文件
		include 'includes/check.func.php';
		$_clean = array();
		$_clean['sex'] = $_POST['sex'];
		$_clean['birthday'] = $_POST['birthday'];
		$_clean['content'] = _check_content($_POST['content'],140);
		//修改资料
		_query("UPDATE user SET sex='{$_clean['sex']}',birthday='{$_clean['birthday']}',content='{$_clean['content']}' WHERE username='{$_SESSION['username']}'");
		//判断是否修改成功
		if (_affected_rows() == 1) {
			mysql_close();
			_alert_back('face-smile','修改成功！','mydata.php');
		} else {
			mysql_close();
			_alert_back('face-sad','修改失败！',null);
		}
	}

	//联系方式
	if ($_GET['action'] == 'connection') {
		//引入验证
		include 'includes/check.func.php';
		$_clean = array();
		$_clean['email'] = _check_email($_POST['email'],6,40);
		$_clean['phone'] = _check_phone($_POST['phone']);
		$_clean['qq'] = _check_qq($_POST['qq']);
		//修改资料
		_query("UPDATE user SET
	email='{$_clean['email']}',phone='{$_clean['phone']}',qq='{$_clean['qq']}' WHERE username='{$_SESSION['username']}'");
		//判断是否修改成功
		if (_affected_rows() == 1) {
			mysql_close();
			_alert_back('face-smile','修改成功！','mydata.php');
		} else {
			mysql_close();
			_alert_back('face-sad','修改失败！',null);
		}
	}

	//密码
	if ($_GET['action'] == 'password') {
		//引入验证
		include 'includes/check.func.php';
		$_clean = array();
		$_clean['new_pwd'] = _check_modify_password($_POST['ori_pwd'],$_POST['old_pwd'],$_POST['new_pwd'],5);
		$_clean['con_pwd'] = _check_password($_POST['new_pwd'],$_POST['re_pwd'],5);
		//修改资料
		_query("UPDATE user SET password='{$_clean['new_pwd']}' WHERE username='{$_SESSION['username']}'");
		//判断是否修改成功
		if (_affected_rows() == 1) {
			mysql_close();
			//_session_destroy();
			_alert_back('face-smile','修改成功！','mydata.php');
		} else {
			mysql_close();
			//_session_destroy();
			_alert_back('face-sad','修改失败！',null);
		}
	}

	//修改头像函数
	require 'includes/face.func.php';
	//修改头像相关设置
	$upload_dir = "face"; 				// 存放上传图片的目录
	$upload_path = $upload_dir."/";				// 存放裁切后的图像
	$large_image_prefix = "resize_"; 			// 上传后重命名未裁切图片的附加字符
	$thumb_image_prefix = "thumbnail_";			// 上传后重命名已裁切图片的附加字符
	$large_image_name = $large_image_prefix.$_SESSION['random_key'];     // 上传后未裁切的图片名的命名规则
	$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // 上传后已裁切的图片名的命名规则
	$max_file = "5"; 							// 上传图片大小，这里默认5M
	$max_width = "400";							// 上传图片的最大宽度
	$thumb_width = "120";						// 裁切后小图的初始宽度
	$thumb_height = "120";						// 裁切后小图的初始高度
	// 以下数组存放允许上传的文件类型
	$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
	$allowed_image_ext = array_unique($allowed_image_types); 
	foreach ($allowed_image_ext as $mime_type => $ext) {
	    $image_ext.= strtoupper($ext)." ";
	}

	//头像名
	$large_image_location = $upload_path.$large_image_name.$_SESSION['user_file_ext'];
	$thumb_image_location = $upload_path.$thumb_image_name.$_SESSION['user_file_ext'];

	//无文件夹则创建
	if(!is_dir($upload_dir)){
		mkdir($upload_dir, 0777);
		chmod($upload_dir, 0777);
	}

	//上传的头像<IMG>
	if (file_exists($large_image_location)){
		if(file_exists($thumb_image_location)){
			$thumb_photo_exists = "<img style='float:left;' src=\"".$upload_path.$thumb_image_name.$_SESSION['user_file_ext']."\" alt=\"裁切区域的图像\"/>";
		}else{
			$thumb_photo_exists = "";
		}
	   	$large_photo_exists = "<img style='float:left;margin-right:50px;' src=\"".$upload_path.$large_image_name.$_SESSION['user_file_ext']."\" alt=\"大图\"/>";
	} else {
	   	$large_photo_exists = "";
		$thumb_photo_exists = "";
	}

	if (isset($_POST["upload"])) { 
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$userfile_size = $_FILES['image']['size'];
		$userfile_type = $_FILES['image']['type'];
		$filename = basename($_FILES['image']['name']);
		$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
		
		if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
			
			foreach ($allowed_image_types as $mime_type => $ext) {
				if($file_ext==$ext && $userfile_type==$mime_type){
					$error = "";
					break;
				}else{
					$error = "文件 <strong>".$image_ext."</strong> 不是期望的格式。<br />";
				}
			}
			if ($userfile_size > ($max_file*1048576)) {
				$error.= "图片不要超过 ".$max_file."MB";
			}
			
		}else{
			$error= "请先选择图像";
		}
		if (strlen($error)==0){
			
			if (isset($_FILES['image']['name'])){
				$large_image_location = $large_image_location.".".$file_ext;
				$thumb_image_location = $thumb_image_location.".".$file_ext;
				
				$_SESSION['user_file_ext']=".".$file_ext;
				
				move_uploaded_file($userfile_tmp, $large_image_location);
				chmod($large_image_location, 0777);
				
				$width = getWidth($large_image_location);
				$height = getHeight($large_image_location);
				if ($width > $max_width){
					$scale = $max_width/$width;
					$uploaded = resizeImage($large_image_location,$width,$height,$scale);
				}else{
					$scale = 1;
					$uploaded = resizeImage($large_image_location,$width,$height,$scale);
				}
				if (file_exists($thumb_image_location)) {
					unlink($thumb_image_location);
				}
			}
			header("location:".$_SERVER["PHP_SELF"]);
			exit();
		}
	}

	if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0) {
		$x1 = $_POST["x1"];
		$y1 = $_POST["y1"];
		$x2 = $_POST["x2"];
		$y2 = $_POST["y2"];
		$w = $_POST["w"];
		$h = $_POST["h"];
		$scale = $thumb_width/$w;
		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	}

	//头像
	if ($_GET['action'] == 'face') {
		//修改资料
		_query("UPDATE user SET face='{$thumb_image_location}' WHERE username='{$_SESSION['username']}'");
		//判断是否修改成功
		if (_affected_rows() == 1) {
			//删除原有
			if (file_exists($_html['face']) && $_html['face'] != 'face/default.jpg') {
				unlink($_html['face']);
				}
			if (file_exists($_htmls['face'])) {
				unlink($_htmls['face']);
				}
			mysql_close();
			_alert_back('face-smile','头像修改成功！','mydata.php');
			
		} else {
		mysql_close();
		_alert_back('face-sad','头像修改失败！',null);
		}
	}
	?>
</head>
<body>
	<?
		require 'includes/header.inc.php';
	?>
	<div class="head1"> 
	  <a href="social.php"><img src="images/logo.png"></a>
	</div>
	<div class="head2">
		<img src="images/head2.png">
	</div>


	<div id="body_bg"></div>
	<div id="member_body_area">
    	<div class="member_header">
        	<ul>
            	<li class="myhome"><a href="home.php">我的主页</a></li>
                <li class="mybamboo"><a href="mybamboo.php">我的艺竹</a></li>
                <li class="mycomment"><a href="mycomment.php">我的评论</a></li>
                <li class="mycollect"><a href="mycollect.php">我的收藏</a></li>
                <li class="myfriend"><a href="myfriend.php">我的好友</a></li>
                <li class="mydata h_select"><a href="mydata.php">我的资料</a></li>
            </ul>
        </div>
		<div class="clear"></div>
		<div class="member_left">
			<div class="left_title">我的资料</div>
			<div class="user_data">
        		<img src="<? echo $html_u['face']; ?>" />
            	<div class="user_name"><? echo $html_u['username']; ?></div>
        	</div>
            <div id="sidebar">
                <div class="sidelist">
                    <span><h3>基本信息</h3></span>
                </div>
                <div class="sidelist">
                    <span><h3>更换头像</h3></span>
                </div>
                <div class="sidelist">
                    <span><h3>修改密码</h3></span>
                </div>
            </div>
		</div>
		<div class="member_right">
        	<div class="member_data">
        		<div class="member_title">
        			<p>基本信息</p>
        		</div>
                <div class="member_info">
                    <form method="post" name="basic" action="?action=basic">
                        <ul>
                            <li>
                            	<label>用&nbsp;户&nbsp;&nbsp;名：</label>
                                <input type="text" id="username" name="username" readonly="readonly" value="<? echo $html_u['username']; ?>" />
                            </li>
                            <li>
                            	<label class="sexlabel">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</label>
                                <input type="radio" id="male" name="sex" value="1" <? if($html_u['sex'] == 1){echo 'checked="checked"';} ?> /><label for="male" class="cheng">男</label>
                            	<input type="radio" id="female" name="sex" value="2" <? if($html_u['sex'] == 2){echo 'checked="checked"';} ?> /><label for="female" class="cheng">女</label>
                            	<input type="radio" id="none" name="sex" value="0" <? if($html_u['sex'] == 0){echo 'checked="checked"';} ?> /><label for="none" class="cheng">未知</label>
                            </li>
                            <li>
                            	<label>生&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日：</label>
                                <input type="text" name="birthday" id="birthday" readonly="readonly" value="<? echo $html_u['birthday']; ?>" />
                            </li>
                            <li>
                            	<label>注册时间：<span class="reg_time"><? echo $html_u['reg_time']; ?></span></label>
                            </li>
                            <li>
                            	<label class="content">个人简介：</label>
                                <textarea name="content"><? echo $html_u['content']; ?></textarea>
                            </li>
                            <li>
                            	<input type="submit" class="submit" value="保存" />
                            </li>
                        </ul>
                    </form>
                </div>
	        	<div class="member_title">
	        		<p>联系方式</p>
	        	</div>
                <div class="member_connection">
                	<form method="post" name="connection" action="?action=connection">
                    	<ul>
                        	<li>
                            	<label>电子邮箱：</label>
                                <input type="text" name="email" class="email" value="<? echo $html_u['email']; ?>" />
                                <span class="email_msg"></span>
                            </li>
                            <li>
                            	<label>手&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机：</label>
                                <input type="text" name="phone" class="phone" value="<? echo $html_u['phone']; ?>" />
                                <span class="phone_msg"></span>
                            </li>
                            <li>
                            	<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QQ：</label>
                                <input type="text" name="qq" class="qq" value="<? echo $html_u['qq']; ?>" />
                                <span class="qq_msg"></span>
                            </li>
                            <li>
                            	<input type="submit" class="submit" value="保存" />
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        	<div class="member_data" style="display:none;height:500px">
        		<div class="member_title">
        			<p>更换头像</p>
        		</div>
                <div class="member_face">
                	<?
					if(strlen($large_photo_exists)>0){
						$current_large_image_width = getWidth($large_image_location);
						$current_large_image_height = getHeight($large_image_location);
					?>
					<script type="text/javascript">
					function preview(img, selection) { 
						var scaleX = <?php echo $thumb_width;?> / selection.width; 
						var scaleY = <?php echo $thumb_height;?> / selection.height; 
						$('#thumbnail + div > img').css({ 
							width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
							height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
							marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
							marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
						});
						$('#x1').val(selection.x1);
						$('#y1').val(selection.y1);
						$('#x2').val(selection.x2);
						$('#y2').val(selection.y2);
						$('#w').val(selection.width);
						$('#h').val(selection.height);
					} 
					
					$(document).ready(function () { 
						$('#save_thumb').click(function() {
							var x1 = $('#x1').val();
							var y1 = $('#y1').val();
							var x2 = $('#x2').val();
							var y2 = $('#y2').val();
							var w = $('#w').val();
							var h = $('#h').val();
							if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
								$('#dialog-face').dialog({
									modal: true,
									resizable:false,
									buttons: {
										'确定': function(){
											$(this).dialog('close');
										}
									},
									close:function(){
										}
								});
								return false;
							}else{
								return true;
							}
						});
					}); 
					
					$(window).load(function () { 
						$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
					});
					
					</script>
					<?php }?>
					<form class="face_change" name="photo" enctype="multipart/form-data" action="" method="post">
						<input type="hidden" name="face" value="<? echo $html_u['face'];?>" />
						<input type="file" name="image" size="30" />
						<input class="submit" id="upload1" type="submit" name="upload" value="上传" />
					</form>
					<? 
						if(strlen($large_photo_exists) == 0 && strlen($thumb_photo_exists) ==0 && $html_u['face'] !='face/default.jpg') {
							echo '<div class="old_face">
											<img src='.$_htmls['face'].' style="margin-right:50px;">
											<img src='.$html_u['face'].' class="old_small">
									  </div>
									  <div id="clear"></div>';
						}
					?>
					<?php
					if(strlen($error)>0){
						_alert_back('face-sad','修改错误！',null);
					}
					if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
						echo '<div class="ori_face">'.$large_photo_exists.$thumb_photo_exists.'<div id="clear"></div></div>';
						$_SESSION['random_key']= "";
						$_SESSION['user_file_ext']= "";
					}else{
							if(strlen($large_photo_exists)>0){?>
							<h2 class="cut_note">请拖动鼠标选择裁切区域：</h2>
							<div class="select_face" align="center">
								<img src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" style="float: left; margin-right: 50px;" id="thumbnail" alt="Create Thumbnail" />
								<div class="hidden_box" style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
									<img src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" style="position: relative;" alt="Thumbnail Preview" />
								</div>
								<br style="clear:both;"/>
								<form class="face_save" name="thumbnail" action="?action=face" method="post">
									<input type="hidden" name="x1" value="" id="x1" />
									<input type="hidden" name="y1" value="" id="y1" />
									<input type="hidden" name="x2" value="" id="x2" />
									<input type="hidden" name="y2" value="" id="y2" />
									<input type="hidden" name="w" value="" id="w" />
									<input type="hidden" name="h" value="" id="h" />
									<input class="submit" type="submit" name="upload_thumbnail" value="保存" id="save_thumb" />
								</form>
							</div>
						<hr />
						<?php 	} ?>
					<?php } ?>
				</div>
        	</div>
        	<div class="member_data" style="display:none;height:500px">
        		<div class="member_title">
        			<p>修改密码</p>
        		</div>
                <div class="member_password">
                	<form method="post" name="password" action="?action=password">
                    	<ul>
                        	<li>
                            	<input type="hidden" name="ori_pwd" value="<? echo $html_u['password'];?>" />
                            	<label>原&nbsp;&nbsp;密&nbsp;码：</label>
                                <input type="password" name="old_pwd" class="old_pwd" value="" />
                                <span class="old_msg"></span>
                            </li>
                            <li>
                            	<label>新&nbsp;&nbsp;密&nbsp;码：</label>
                                <input type="password" name="new_pwd" class="new_pwd" value="" />
                                <span class="new_msg"></span>
                            </li>
                            <li>
                            	<label>确认密码：</label>
                                <input type="password" name="re_pwd" class="re_pwd" value="" />
                                <span class="re_msg"></span>
                            </li>
                            <li>
                            	<input type="submit" class="submit" value="确认修改" />
                            </li>
                        </ul>
                    </form>
                </div>
        	</div>
        </div>
    </div>
</body>
</html>