

$(function(){
	$(".collect_list").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
})