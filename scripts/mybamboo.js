

$(function(){
	//替换标题
	$(".bamboo_list").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
	
	$(".bamboo_list").hover(function(){
		$(this).find(".modify").show();
	},function(){
		$(this).find(".modify").hide();
	})
})