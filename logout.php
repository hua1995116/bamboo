<?php
session_start();
//引入公共文件
require 'includes/common.inc.php';
   date_default_timezone_set('Asia/Shanghai');
unset($_SESSION['username']);
_location('null','index.php');
?>