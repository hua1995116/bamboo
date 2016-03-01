<?
if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在，请检查!');
}
if (!function_exists('_mysql_string')) {
	exit('_mysql_string()函数不存在，请检查!');
}

function _check_post_title($_string,$_min,$_max) {
	if (mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max) {
		_alert_back('face-sad','标题不得小于'.$_min.'位或者大于'.$_max.'位！',null);
	}
	if ($_string == '请在此输入标题') {
		_alert_back('face-sad','标题不合法！请重新输入。',null);
	}
	return $_string;
}

function _check_post_content($_string,$_num) {
	if (mb_strlen($_string,'utf-8') < $_num) {
		_alert_back('face-sad','内容不得小于'.$_num.'位！',null);
	}
	return $_string;
}

//检测个人简介
function _check_content($_string,$_num) {
	if (mb_strlen($_string,'utf-8') > $_num) {
		_alert_back('face-sad','简介不得多于'.$_num.'字！',null);
	}
	return $_string;
}

//检测邮箱
function _check_email($_string,$_min_num,$_max_num) {
	//参考bnbbs@163.com
	//[a-zA-Z0-9_] => \w
	//[\w\-\.] 163.
	//\.[\w+] .com.com.com.net.cn
	//正则挺起来比较麻烦，但是你理解了，就很简单了。
	//如果听起来比较麻烦，就直接套用
	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		_alert_back('face-sad','邮件格式不正确！',null);
	}
	if (strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('face-sad','邮件长度不合法！',null);
	}	
	return _mysql_string($_string);
}

//检测手机
function _check_phone($_string) {
	if (empty($_string)) {
		return null;
	} else {
		//15868131120
		if (!preg_match('/^[1]{1}[\d]{10}$/',$_string)) {
			_alert_back('face-sad','手机号码不正确！',null);
		}
	}
	return _mysql_string($_string);
}

//检测QQ
function _check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		//123456
		if (!preg_match('/^[1-9]{1}[\d]{4,10}$/',$_string)) {
			_alert_back('face-sad','QQ号码不正确！',null);
		}
	}
	return _mysql_string($_string);
}

//密码
function _check_password($_first_pass,$_end_pass,$_min_num) {
	//判断密码
	if (strlen($_first_pass) < $_min_num) {
		_alert_back('face-sad','密码不得小于'.$_min_num.'位！',null);
	}
	//密码和密码确认必须一致
	if ($_first_pass != $_end_pass) {
		_alert_back('face-sad','新密码和确认密码不一致！',null);
	}
	//将密码返回
	return sha1($_first_pass);
}

//修改密码
function _check_modify_password($_old_pass,$_con_pass,$_new_pass,$_min_num) {
	//判断密码
	if (strlen($_new_pass) < $_min_num) {
		_alert_back('face-sad','密码不得小于'.$_min_num.'位！',null);
	}
	//密码和密码确认必须一致
	if (sha1($_con_pass) != $_old_pass) {
		_alert_back('face-sad','旧密码不正确！',null);
	}
	//将密码返回
	return sha1($_new_pass);
}
?>