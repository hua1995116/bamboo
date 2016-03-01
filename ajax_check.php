<?php
//引入公共文件
require 'includes/common.inc.php';

$_articleid = $_POST['articleid'];

if($_articleid){
	_query("UPDATE bamboo SET check_bamboo=1 WHERE id='{$_articleid}'");
	echo 1;
} else {
	echo 0;
}
?>