

$(function(){

	$(".hide_nav_block").hover(function() {
		$(".hide_nav").animate({"left":"0"}, 200);
	},function(){
		$(".hide_nav").animate({"left":"-180px"}, 200);
	});

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

			$(".nav_title").css("background","#513E2C");
			$(".sidebar").css("border-color","#513E2C");
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
})