

$(function(){
	
	$(".block").click(function(){
		index = $(".block").index(this);
		$(".hide").eq(index).fadeIn(400);
	})
	
	$(".close").click(function(){
		$(this).parent(".hide").fadeOut(400);
	})

	//左侧导航
	$(".main_nav .sidelist").hover(function(){
		var nav_index = $(".main_nav .sidelist").index(this);
		var nav_pos = nav_index * (-80) - 40;
		if(nav_index == 0){
			$(this).animate({
		 		"background-position-y": "-40px"
			}, 200);

			$(".nav_title").css("background","#112477");
			$(".sidebar").css("border-color","#112477");
		} else if(nav_index == 1){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#ECCBAA");
			$(".sidebar").css("border-color","#ECCBAA");
		} else if(nav_index == 2){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#7B6D61");
			$(".sidebar").css("border-color","#7B6D61");
		} else if(nav_index == 3){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#F8ACC0");
			$(".sidebar").css("border-color","#F8ACC0");
		} else if(nav_index == 4){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#1FA5DD");
			$(".sidebar").css("border-color","#1FA5DD");
		} else if(nav_index == 5){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#C1000A");
			$(".sidebar").css("border-color","#C1000A");
		}
	},function(){
		var nav_index = $(".main_nav .sidelist").index(this);
		var nav_pos = nav_index * (-80);
		if(nav_index == 0){
			$(this).animate({
			 	"background-position-y": "0px"
			}, 200);
		} else{
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);
		}

		$(".nav_title").css("background","#a42c6a");
		$(".sidebar").css("border-color","#a42c6a");
	})
	
	$(".common_user").click(function(){
		art.dialog({
			title:'管理后台提醒',
			content:'对不起，你无权查看该页面！',
			icon:'warning',
			ok: function () {
				return true;
    		}
		})
	})
	
	$(".no_login").click(function(){
		art.dialog({
			title:'管理后台提醒',
			content:'请先登录！',
			icon:'warning',
			ok: function () {
				return true;
    		}
		})
	})
})