<?
session_start();
//引入公共文件
require 'includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>艺竹-首页</title>
	<link rel="shortcut icon" href="images/ico/logo.ico" />
	<link rel="stylesheet" href="styles/dh.css" type="text/css" />
<script>
  window.onload =function(){
  var oDiv1 =document.getElementById('dh1');
  var oDiv2 =document.getElementById('dh2');
  var oDiv3 =document.getElementById('dh3');
  var oDiv4 =document.getElementById('dh4');
  var oDiv5 =document.getElementById('dh5');
  oDiv1.onmouseover= function(){ 
       startMove(this,'opacity',100);
    }
  oDiv1.onmouseout =function(){ 
       startMove(this,'opacity',0);
    }
  oDiv2.onmouseover= function(){ 
       startMove(this,'opacity',100);
    }
  oDiv2.onmouseout =function(){ 
       startMove(this,'opacity',0);
    }
  oDiv3.onmouseover= function(){ 
       startMove(this,'opacity',100);
    }
  oDiv3.onmouseout =function(){ 
       startMove(this,'opacity',0);
    }
  oDiv4.onmouseover= function(){ 
       startMove(this,'opacity',100);
    }
  oDiv4.onmouseout =function(){ 
       startMove(this,'opacity',0);
    }
  oDiv5.onmouseover= function(){ 
       startMove(this,'opacity',100);
    }
  oDiv5.onmouseout =function(){ 
       startMove(this,'opacity',0);
    }
}
//var timer = null;
function startMove(obj,attr,iTarget){ 
  clearInterval(obj.timer);
  obj.timer = setInterval(function(){
  	var icur = 0;
  	if(attr == 'opacity')
  	{
  	   icur = Math.round(parseFloat(getStyle(obj,attr))*100); 
  	}
  	else{ 
   	   var icur = parseInt(getStyle(obj,attr));
  	}
	var speed = (iTarget-icur)/8; 
	speed = speed>0?Math.ceil(speed):Math.floor(speed);
  	if(icur == iTarget){ 
      clearInterval(obj.timer);
  	}
	else{
		if(attr == 'opacity'){ 
            obj.style.filter = 'alpha(opacity:'+(icur + speed)+')';
            obj.style.opacity = (icur + speed)/100;
		}
		else{ 
            obj.style[attr]=icur+speed+'px';
		}
    }
  },30)
}

function getStyle(obj,attr){ 
   if(obj.currentStyle){ 
     return obj.currentStyle[attr];
   }
   else{ 
     return getComputedStyle(obj,false)[attr];
   }
}
</script>
</head>
<body>
         <div class="ddd">
              <a href="index.php"><img src="images/6.png"></a>
         </div>
         <div class="2">
             <div id="dh1"><a href="profession.php"><img src="images/1-1.png"></a></div>
             <div id="dh2"><a href="indoor.php"><img src="images/2-1.png"></a></div>
             <div id="dh3"><a href="social.php"><img src="images/3-1.png"></a></div>
             <div id="dh4"><a href="daily.php"><img src="images/4-1.png"></a></div>
             <div id="dh5"><a href="child.php"><img src="images/5-1.png"></a></div>
         </div>   
           <div class="bottom">
         	<div class="bottom1">版权所有©2015艺竹</div>
         	<div class="bottom2">备案号：浙ICP备00000000号</div>
           </div>
</body>
</html>