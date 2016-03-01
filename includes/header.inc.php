<?php
session_start();
date_default_timezone_set('Asia/Shanghai');
//开始处理登录状态
if ($_GET['action'] == 'login') {
    //引入验证文件
    include 'includes/login.func.php';
    //接受数据
    $_clean = array();
    $_clean['username'] = _check_username($_POST['l_username'],2,16);
    $_clean['password'] = _check_password($_POST['l_password'],5);
    //到数据库去验证
    if ($_rows = _fetch_array("SELECT username FROM user WHERE username='{$_clean['username']}' AND password = '{$_clean['password']}' LIMIT 1")) {
        //登录成功后，记录登录信息
        _setcookies($_rows['username'],$_POST['check']);
        mysql_close();
        _alert_back('face-smile','恭喜你，登录成功！','home.php');
    } else {
        mysql_close();
        _alert_back('face-sad','抱歉，登录失败！',null);
    }
}
?>

<!-- 搜索框 -->
<div id="search_b">
	<div class="search_area">
    	<form action="search.php" method="post" name="search" target="_blank">
            <input class="search_box" type="text" value="搜索作品" name="key" maxlength="10" autocomplete="off">
            <input class="search_submit" type="submit" value="">
    	</form>
    </div>
</div>
<!-- 搜索框完 -->
<!-- 登陆按钮 -->
<?
    if(isset($_SESSION['username'])){
        $_rows = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}' LIMIT 1");
        if($_rows){
            $_html_user['id'] = $_rows['id'];
            $_html_user['username'] = $_rows['username'];
            $_html_user['face'] = $_rows['face'];
            $_html_user['level'] = $_rows['level'];
            $_html_user['type'] = $_rows['type'];
            echo '
                <div id="after_login_b"><a href="home.php"><img src="'.$_html_user['face'].'" class="_face" alt="" /></a>
                <div class="user_operate">
               
                <a href="home.php"><div class="header_name">个人中心</div></a>
            ';
            if($_html_user['level'] == 1){
                echo '<a href="admin.php"><div class="manage">后台管理</div></a>';
            } else {
                if($_html_user['type'] == '普通用户'){
                echo '<a href="mybamboo.php"><div class="up">上传竹工艺</div></a>';
                }else{
                echo '<a href="deal_look.php"><div class="up">查看订单</div></a>';
                }
            }
            echo '<div class="logout">退出</div>'; 
            echo '</div></div>';
        }
    } else{
        echo '<div id="login_b"></div>';
    }
?>

<!--返回顶部-->
<a id="elevator" onclick="return false;" title="回到顶部"></a>

<!--登录框-->
<div id="login_area">
    <form method="post" name="login" action="?action=login">
        <ul>
            <li>
                用户名：<input name="l_username" type="text" autocomplete="off" maxlength="16">
            </li>
            <li>
                密&nbsp;&nbsp;&nbsp;码：<input name="l_password" type="password" maxlength="16">
            </li>
        </ul>
        <input name="check" type="checkbox" checked="checked" value="1" class="remember">
        <span>两周内记住我</span>
        <input name="l_submit" type="submit" value="登录" class="login_sub">
        <div class="tip">还没有帐号？先<a href="register.php">注册</a>吧！</div>
	</form>
</div>