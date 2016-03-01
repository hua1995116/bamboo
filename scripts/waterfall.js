// JavaScript Document

function waterfallInit(json){
	var parent = json.parent;
	var pin = json.pin;
	var successFn = json.successFn;
	var loadImgSrc = json.loadImgSrc;
	var requestUrl = json.requestUrl;
	var requestNum = json.requestNum;
	var style = json.style;
	var ajaxState = true;
	var page = 3;
	ajaxRequest();
	
	window.onscroll=function(){
		if(checkScrollSite() && ajaxState){
			page++;
			ajaxRequest();
			ajaxState = false;
		}
	}
	
	function ajaxRequest(){
		$.ajax({
			type:"GET",
			url:requestUrl,
			data:"page="+page+"&requestNum="+requestNum,
			beforeSend:function(){
				if(page){
					var oParent  =document.getElementById(parent);
					var aPin = getClassObj(oParent,pin);
					var lastPinH = aPin[aPin.length-1].offsetTop+aPin[aPin.length-1].offsetHeight;
					var loadImg = document.createElement('img');
					loadImg.src=loadImgSrc;
					loadImg.id = 'loadImg';
					oParent.appendChild(loadImg);
					loadImg.style.position = 'absolute';
					loadImg.style.top  = lastPinH+50+'px';
					loadImg.style.left = Math.floor((oParent.offsetWidth-loadImg.offsetWidth)/2)+'px';
				}
			},
			success:function(data){
				if(successFn(data)){
					waterfall(parent,pin,style);
				}
			},
			complete:function(){
				if(page){
					document.getElementById(parent).removeChild(document.getElementById('loadImg'));
				}
				ajaxState = true;
			}
		})
	}
	
	/***
	 * 校验滚动条位置
	 * @returns  布尔
	 */
	function checkScrollSite(){
		var srcollTop = document.documentElement.scrollTop || document.body.scrollTop;
		var documentH = document.documentElement.clientHeight;
		return getLastH()<srcollTop+documentH?true:false;
	}
	
	/***
	 * 
	 * @returns  number
	 */
	function getLastH(){
		var oParent  =document.getElementById(parent);
		var aPin = getClassObj(oParent,pin);
		var lastPinH = aPin[aPin.length-1].offsetTop+Math.floor(aPin[aPin.length-1].offsetHeight/2);
		return lastPinH;
	}
}

/***
 * 
 * @param {Object} parent		父级		id
 * @param {Object} pin			具体瀑布流块 class类名
 */
function waterfall(parent,pin,style){
	var oParent  =document.getElementById(parent);
	var aPin = getClassObj(oParent,pin);
	var iPinW = aPin[0].offsetWidth;
	var num = Math.floor(oParent.offsetWidth/iPinW);
	oParent.style.cssText = 'width:'+num*iPinW+'px;margin:0 auto;position:relative;';
	var compareAarr = [];
	for(var i=0;i<aPin.length;i++){
		if (i < num) {
			compareAarr[i] = aPin[i].offsetHeight;
		}else{
			var minH = Math.min.apply({},compareAarr);
			var minKey = getMinKey(compareAarr,minH)
			compareAarr[minKey] += aPin[i].offsetHeight
			setMoveStyle(aPin[i],minH,aPin[minKey].offsetLeft,i,style);
		}
	}
	for(var i=num;i<aPin.length;i++){
		aPin[i].style.position = 'absolute';
	}
}	

/***
 * 设置运动风格
 * @param obj			运动的对象	
 * @param top			运动的 top 值
 * @param left			运动的 left 值
 */
var startNum = 0;
function setMoveStyle(obj,top,left,index,style){
	if(index <= startNum){
		return ;
	}
	var documentW = document.documentElement.clientWidth;
	obj.style.position = 'absolute';		
	switch(style){
		case 1:
		obj.style.top = getTotalH()+'px';
		obj.style.left = Math.floor((documentW-obj.offsetWidth)/2)+'px';
		$(obj).stop().animate({
			top:top,
			left:left
		},500);
		break;
		case 2:
		obj.style.top = top+'px';
		obj.style.left = left+'px';
		obj.style.opacity = 0;
		obj.style.filter = 'alpha(opacity=0)';
		$(obj).stop().animate({
			opacity:1
		},500);
		break;
		case 3:
		obj.style.top = getTotalH()+'px';
		if(index % 2){
			obj.style.left = -obj.offsetWidth+'px';
		}else{
			obj.style.left = documentW+'px';
		}
		$(obj).stop().animate({
			top:top,
			left:left
		},500);
		break;
		case 4:
		obj.style.top = getTotalH()+'px';
		obj.style.left = left+'px';
		$(obj).stop().animate({
			top:top,
			left:left
		},500);
		break;
	}
	startNum  = index; //更新索引
	
}

/**
 * 获得总高度
 * @returns number
 */
function getTotalH(){
	var totalH = document.documentElement.scrollHeight || document.body.scrollHeight;
	return totalH;
}

/****
 * 获取数组最值的键值
 * @param {Object} arr
 * @param {Object} minH
 */
function getMinKey(arr,minH){
	for(key in arr){
		if(arr[key] == minH){
			return key;
		}
	}
}

/***
 * 通过class选择元素
 * @param {Object} parent	 父级
 * @param {Object} className 类名
 */
function getClassObj(parent,className){
	var obj = parent.getElementsByTagName('*');
	var result = [];
	for(var i=0;i<obj.length;i++){
		if(obj[i].className == className){
			result.push(obj[i]);
		}
	}
	return result;
}