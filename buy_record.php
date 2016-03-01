<?
/**
* TestGuest Version1.0
* ================================================
* Copy 2015-2017 
* Web: 
* ================================================
* Author: hu
* 2015-4-13
*/
session_start();
//定义个常量，用来指定本页的内容
define('SCRIPT','buy_record');
//引入公共文件
require 'includes/common.inc.php';
if($_GET['action']=='delete')
{   
    $_delename=$_POST['delename'];
    _query("DELETE FROM `deal` WHERE title='{$_delename}' AND vipname='{$_SESSION['username']}' LIMIT 1"); 
if(_affect_row()==1){
    _location('删除成功','buy_record.php');
}
}
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

    <div id="body_area">
        <?
            require 'includes/left_nav.inc.php';
        ?>
        <div id="body_r">

<div class="main">
        <div class="mainhead">
             <div class="mainname">产品</div>
             <div class="mainnumber">价格</div>
             <div class="mainauthor">作者</div>
             <div class="mainprice">数量</div>
             <div class="mainextra">备注</div>
             <div class="maintime">时间</div>
        </div>


    <?
    //获取订单信息
    $_html_record = array();
    if(!!isset($_SESSION['username'])){
        $_record = _query("SELECT * FROM deal WHERE vipname='{$_SESSION['username']}' ORDER BY time DESC LIMIT 5");
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
    } else {
        _alert_back('error','请先登录！','index.php');
    }
    ?>
</div>




        </div>
    </div>
</body>
</html>