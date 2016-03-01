<?php
//基本函数
if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在，请检查!');
}
if (!function_exists('_mysql_string')) {
	exit('_mysql_string()函数不存在，请检查!');
}

//用户名
function _check_username($_string,$_min_num,$_max_num) {
	//去掉两边的空格
	$_string = trim($_string);
	//长度小于2位或者大于16位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('face-sad','用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位',null);
	}
	//限制敏感字符
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('face-sad','用户名不得包含敏感字符',null);
	}
	//限制敏感用户名
	$_mg[0] = '茅梓成';
	//告诉用户，有哪些不能够注册
	foreach ($_mg as $value) {
		$_mg_string .= '[' . $value . ']' . '\n';
	}
	//这里采用的绝对匹配
	if (in_array($_string,$_mg)) {
		_alert_back('face-sad',$_mg_string.'，该敏感用户名不得注册',null);
	}
	//将用户名转义输入
	return _mysql_string($_string);
}

//密码
function _check_password($_string,$_min_num) {
	//判断密码
	if (strlen($_string) < $_min_num) {
		_alert_back('face-sad','密码不得小于'.$_min_num.'位！',null);
	}
	
	//将密码返回
	return sha1($_string);
}


?>