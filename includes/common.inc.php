<?
//设置字符集编码
//header('Content-Type: text/html; charset=utf-8');
ob_start();
//拒绝PHP低版本
if (PHP_VERSION < '4.1.0') {
	exit('Version is to Low!');
}

//引入公共函数库
require 'includes/function.inc.php';

//数据库连接
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "hyf";
$dbdata = "bamboo";

//数据库库初始化
$conn = mysql_connect($dbhost,$dbuser,$dbpass) or die("不能连接数据库服务器：".mysql_error());
mysql_select_db($dbdata,$conn) or die("不能选择数据库：".mysql_error());
mysql_query("set names utf8");
?>