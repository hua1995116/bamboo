<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-注册</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/register.css" type="text/css" />
	<script src="scripts/register.js" type="text/javascript"></script>
	<?
	if(isset($_SESSION['username'])){
		_alert_back('error','你已登录！如仍需注册，请退出后再进入此页！','index.php');
	}
	?>
	<?
	//判断提交
	if ($_GET['action'] == 'register') {
		//为了防止恶意注册，跨站攻击
		_check_code($_POST['code'],$_SESSION['code']);
		//引入验证文件
		include 'includes/register.func.php';
		//创建一个空数组，用来存放提交过来的合法数据
		$_clean = array();
		$_clean['username'] = _check_username($_POST['username'],2,16);
		$_clean['password'] = _check_password($_POST['password'],$_POST['repassword'],5);
		$_clean['email'] = _check_email($_POST['email'],2,40);
		$_clean['phone'] = $_POST['phone'];
		$_clean['content'] = $_POST['content'];
		$_clean['qq'] = $_POST['qq'];
		$_clean['type'] = $_POST['type'];
		//在新增之前，要判断用户名是否重复
		_is_repeat("SELECT username FROM user WHERE username='{$_clean['username']}' LIMIT 1");
		//新增用户  //在双引号里，直接放变量是可以的，比如$_username,但如果是数组，就必须加上{} ，比如 {$_clean['username']}
		_query(
		"INSERT INTO user (username,password,email,reg_time,qq,phone,content,type) VALUES 
		                  ('{$_clean['username']}',
		                   '{$_clean['password']}',
		                   '{$_clean['email']}',
		                   NOW(),
		                   '{$_clean['qq']}',
		                   '{$_clean['phone']}',
		                   '{$_clean['content']}',
		                   '{$_clean['type']}')"
		);
		if (_affected_rows() == 1) {
			mysql_close();
			$_SESSION['username'] = $_clean['username'];
			_alert_back('face-smile','恭喜你，注册成功！','home.php');
		} else {
			mysql_close();
			_alert_back('face-sad','抱歉，注册失败！','register.php');
		}
	}
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

		<?
	        require 'includes/left_nav.inc.php';
	    ?>
	    <div id="body_r">
	    	<div id="reg_l">
	            <div class="reg_title">欢迎加入艺竹</div>
	            <div class="reg_title_right">如已有账号&nbsp;&nbsp;请点击右下角登录</div>
	            <div class="reg_form">
	                <form method="post" name="member" action="register.php?action=register">
	                    <ul>
	                        <li>
	                        	<span class="_note">用&nbsp;&nbsp;户&nbsp;&nbsp;名:</span>
	                        	<input type="text" name="username" class="_text input_username" maxlength="16" />
	                            <span class="username_msg"></span>
	                        </li>
	                        <li>
	                        	<span class="_note">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:</span>
	                            <input type="password" name="password" class="_text input_password" maxlength="16" />
	                            <span class="password_msg"></span>
	                        </li>
	                        <li>
	                        	<span class="_note">确认密码:</span>
	                            <input type="password" name="repassword" class="_text input_repassword" maxlength="16" />
	                            <span class="repassword_msg"></span>
	                        </li>
	                        <li>
	                        <span class="_note">用户类型</span>
	                        <select class="type" name="type">
                            <option value='0' selected>请选择用户类型</option>
                            <option value='普通用户'>普通用户</option>
                            <option value='厂家用户'>厂家用户</option>
                            </select>
                            </li>
                            <li>
                            <span class="_note">个人介绍:</span>
                            <input type="text" name="content" class="_text input_content" maxlength="40" />
                            </li>
	                        <li>
	                        	<span class="_note">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱:</span>
	                            <input type="email" name="email" class="_text input_email" maxlength="40" />
	                            <span class="email_msg"></span>
	                        </li>
	                        <li>
                                <span class="_note">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话:</span>
                                <input type="phone" name="phone" class="_text input_phone" maxlength="40" />
                            </li>
                            <li>
                                <span class="_note">Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q:</span>
                                <input type="text" name="qq" class="_text input_qq" maxlength="40" />
                            </li>
	                        	<div class='reg_separation'></div>
	                        <li>
	                        	<span class="_note_code">验&nbsp;证&nbsp;码:</span>
	                            <input type="text" name="code" class="_code input_code" maxlength="4" />
	                            <span class="code_msg"></span>
	                            <img src="code.php" id="code" title="看不清？点击刷新" />
	                            <span id="_change"><a href="#">换一张</a></span>
	                        </li>
	                        <input type="submit" class="reg_sub" value="确认注册" />
	                        <span class="sub_msg">请检查错误内容！</span>
	                    </ul>
	                </form>
	            </div>
	        </div>
	        <div id="reg_r">
	        	<div class="public_t">
	            	<p>信息注册</p>
	                <p>请填写注册必填信息提交</p>
	            </div>
	            <div class="public_m">
	            	<p>完善个人档</p>
	                <p>进入个人中心，完善资料</p>
	            </div>
	            <div class="public_b">
	            	<p>完成注册</p>
	                <p>尽情体验艺竹的乐趣</p>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>