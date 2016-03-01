<?
session_start();
//定义个常量，用来指定本页的内容
define('SCRIPT','buy');
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-与我订购</title>
	<?
		require 'includes/title.inc.php';
	?>
	<link rel="stylesheet" type="text/css" href="styles/buy.css" />
	<script type="text/javascript" src="scripts/buy.js"></script>
<script type="text/javascript">
	window.onload=function(){
      var Bd1 = document.getElementById("bd1");
      var Bd2 = document.getElementById("bd2");
      var Bd3 = document.getElementById("bd3");
      Bd2.onclick = function(){
      	Bd1.value++;
      }
      Bd3.onclick = function(){
      	Bd1.value--;
      	if(Bd1.value<1){ 
           Bd1.value=1;
      	}
      }
	}
</script>
</head>
<body>
	<?
		require 'includes/header.inc.php';
	?>
    <?
		require 'includes/head.php';
	?>
	<?
      
	date_default_timezone_set('Asia/Shanghai');
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
	<?    
      if(isset($_GET['ids']))
      	 {
      	  $_deal = _query("SELECT * FROM bamboo WHERE id='{$_GET['ids']}' ORDER BY hit DESC LIMIT 1");
              while($rows_like = _fetch_array_list($_deal)){
							$_clean = array();
							$_clean['username'] = $rows_like['username'];
							$_clean['title'] = $rows_like['title'];
							$_clean['cost'] = $rows_like['cost'];
							$_clean['vipname'] = $html_user['username'] ;
							$_clean['number'] = $_POST['number'];
							$_clean['speak'] = $_POST['speak'];
							_query(
		"INSERT INTO deal (title,cost,vipname,username,number,speak,time) VALUES ('{$_clean['title']}','{$_clean['cost']}','{$_clean['vipname']}','{$_clean['username']}','{$_clean['number']}','{$_clean['speak']}',NOW())"
		                           );
							_alert_back('face-smile','恭喜你，购买成功！','buy_record.php');
						}
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
	    	  <div class="img1">
	    	  <?
						$rs_like = _query("SELECT * FROM bamboo WHERE id='{$_GET['id']}' && check_bamboo=1 ORDER BY hit DESC LIMIT 1");
						while($rows_like = _fetch_array_list($rs_like)){
							$html_like = array();
							$html_like['img'] = $rows_like['img'];
							$html_like['username'] = $rows_like['username'];
							$html_like['title'] = $rows_like['title'];
							$html_like['cost'] = $rows_like['cost'];
						}
	                   echo $html_like['img'];
	          ?>
	          <?
                if($html_like['cost']==0){
                	_alert_back('face-sad','抱歉，该作品暂时无法购买！','javascript:history.go(-1)');
                }
	          ?>
	          <div class="author">
	          	  作者：<?  echo $html_like['username'];?>
	          </div>
	          </div>
	          <?
	          if(!isset($_GET['ids'])){
	          echo '<div class="text-right"><div class="name">名字 : '.$html_like['title'].'</div><div class="price">价格：'.$html_like['cost'].'</div><div class="number">数量：&nbsp&nbsp&nbsp&nbsp<input class="jian" type="button" value="-" id="bd3"/>
              <input class="zhong" type="text" value="1" id="bd1" name="number"/>
              <input class="jia" type="button" value="+" id="bd2"/></div>
              <div class="xian"></div>
              <dd class="beizhu"><p>备注：</p><input class="beizhu1" type="text" name="speak" value=" " /></dd>
              <dd class="payway">支付<div class="payway1"><img src="images/huabei.png" /><p>花呗</p></div> <div class="payway1"><img src="images/xinyong.png" /><p>信用卡</p></div><div class="payway1"><img src="images/zhifu.png" /><p>支付宝</p></div></dd>
              <dd class="submit"><input class="submit1" type="submit" class="submit1" value="提交订单" /></dd></div>';}
              ?>
           </from>
	    </div>
	</div>
</body>
</html>