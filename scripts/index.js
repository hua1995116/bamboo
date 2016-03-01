

$(function() {
	function GetColor(){
		var r = Math.floor(Math.random() * 255).toString(16);
		var g = Math.floor(Math.random() * 255).toString(16);
		var b = Math.floor(Math.random() * 255).toString(16);
		r = r.length == 1 ? "0" + r : r;
		g = g.length == 1 ? "0" + g : g;
		b = b.length == 1 ? "0" + b : b;
		return "#" + r + g + b;
	}

	function GetRandomTime(min_num,max_num){
		var n = Math.floor(Math.random() * (max_num-min_num)) + min_num;
		return n;
	}

	function RandomColor(select,time){
		setInterval(function(){
			$(select).css("background", GetColor());
		},time);
	}

	RandomColor(".colorB1",GetRandomTime(3000,8000));
	RandomColor(".colorB2",GetRandomTime(3000,8000));
	RandomColor(".colorB3",GetRandomTime(3000,8000));
	RandomColor(".colorB4",GetRandomTime(3000,8000));

	$("#nav ul li").hover(function() {
		if (!$("#nav ul").is(":animated") && !$(".box").is(":animated")) {
			var index = $("#nav ul li").index(this);
			var pos = index * 152 + 0;
			$("#nav ul").animate({
				"background-position-x": pos + "px"
			}, 250);

			$("#header").css("background","url(images/bamboo"+index+".png) center top no-repeat");
			$("#body_bg").css("background","url(images/bamboo"+index+".png) center top no-repeat");

			if(index == 0){
				$("#logo").animate({
					"top": "5px"
				}, 200);
				$("#footer").css('background', '#112477');
				$("#nav").css('background', '#112477');
				$("#view a").attr("href","social.php");
			} else if(index == 1){
				$("#logo").animate({
					"top": "0px"
				}, 200);
				$("#footer").css('background', '#53402C');
				$("#nav").css('background', '#ECCBAA');
				$("#view a").attr("href","daily.php");
			} else if(index == 2){
				$("#logo").animate({
					"top": "25px"
				}, 200);
				$("#footer").css('background', '#7B6D61');
				$("#nav").css('background', '#7B6D61');
				$("#view a").attr("href","profession.php");
			} else if(index == 3){
				$("#logo").animate({
					"top": "0px"
				}, 200);
				$("#footer").css('background', '#F8ACC0');
				$("#nav").css('background', '#F8ACC0');
				$("#view a").attr("href","indoor.php");
			} else if(index == 4){
				$("#logo").animate({
					"top": "0px"
				}, 200);
				$("#footer").css('background', '#1FA5DD');
				$("#nav").css('background', '#1FA5DD');
				$("#view a").attr("href","child.php");
			} else if(index == 5){
				$("#logo").animate({
					"top": "0px"
				}, 200);
				$("#footer").css('background', '#C1000A');
				$("#nav").css('background', '#C1000A');
				$("#view a").attr("href","idea.php");
			}

			$(".box").eq(index).siblings().fadeOut(100);
			$(".box").eq(index).fadeIn(300);
		}
	}, function() {
		$("#nav ul").stop(false, true);
		$(".box").stop(false, true);
		$("#logo").stop(false, true);
	});

	$(".view1,.view2,.view3,.view4").hover(function(){
		$(this).css({"cursor": "pointer", "background-color": "rgba(0,0,0,0.75)"});
	},function(){
		$(this).css("background-color","transparent");
	});
})