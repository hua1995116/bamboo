<?
session_start();
//定义个常量，用来指定本页的内容
define('SCRIPT','buy');
//引入公共文件
require 'includes/common.inc.php';
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="}Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>艺竹-订购记录</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<?
   require 'includes/title.inc.php';
?>
<link rel="stylesheet" type="text/css" href="styles/buy_record.css" />
</head>
<body>
    <?
		require 'includes/header.inc.php';
	?>
    <?
		require 'includes/head.php';
	?>
	<? 
	if(!!isset($_SESSION['username'])){
		$rows_user = _fetch_array("SELECT * FROM user WHERE username='{$_SESSION['username']}'");
		//获取用户信息
		$html_user = array();
		$html_user['id'] = $rows_user['id'];
		$html_user['username'] = $rows_user['username'];
		$html_user['face'] = $rows_user['face'];
		$html_user['birthday'] = $rows_user['birthday'];
		$html_user['email'] = $rows_user['email'];
		$html_user['content'] = $rows_user['content'];
		$html_user['bamboo_num'] = $rows_user['bamboo_num'];
	} else {
		_alert_back('error','请先登录！','index.php');
	}
    ?>
	<div id="body_area">
		<?
	        require 'includes/left_nav.inc.php';
	    ?>
	    <div id="body_r"> 
	    	<form class="toutou" method="post" name="from" action="buy.php?ids=<? echo $_GET['id']; ?>">
	    	  <div class="back" id="zzz" onclick="aaa()">
	    	  	  <a href="javascript:history.go(-1);" >返回</a>
	    	  </div>
	    <?
                $_record = _query("SELECT * FROM deal WHERE username='{$_SESSION['username']}' ORDER BY time DESC LIMIT 5");
            while($_buy_record = mysql_fetch_array($_record,MYSQL_ASSOC)){
            $_html_record['title'] = $_buy_record['title'];
            $_html_record['cost'] = $_buy_record['cost'];
            $_html_record['username'] = $_buy_record['username'];
            $_html_record['number'] = $_buy_record['number'];
            $_html_record['speak'] = $_buy_record['speak'];
            $_html_record['time'] = $_buy_record['time'];
    //得到图片
            $_img = _query("SELECT * FROM bamboo WHERE title='{$_html_record['title']}' ");
            $_html_img =_fetch_array_list($_img);
            $_html_record['img'] =  $_html_img['img'];
    //输出在这里
        echo 
             
             '<div class="neirong">'.
             '<div class="photo">'.$_html_record['img'].'</div>'.
             '<div class="title">'.'<a href="#">'.$_html_record['title'].'</a>'.'</div>'.
             '<div class="cost">'.$_html_record['cost'].'</div>'.
             '<div class="username">'.'<a href="#">'.$_html_record['username'].'</a>'.'</div>'.
             '<div class="number">'.$_html_record['number'].'</div>'.
             '<div class="speak">'.$_html_record['speak'].'</div>'.
             '<div class="time">'.$_html_record['time'].'</div>'.
             '<div class="delete">'.
             '<form method="post" action="?action=delete">'.
             '<input type="hidden" value="'.$_html_record['title'].'" name="delename" />'.
             '<input class="delete1" type="submit" name="dele" value="删除" />'.
             '</form>'.
             '</div>'.
             '</div>';
        }		 
	    	 ?>
           </from>
	    </div>
	</div>
</body>
</html>