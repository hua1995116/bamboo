

$(document).ready(function()
{
	$('.galleryImage').hover(
		function(){
			$(this).find('img').animate({width:170, height:96, marginTop:10, marginLeft:65}, 200);
		 },
		 function(){
			 $(this).find('img').animate({width:300, height:168, marginTop:0, marginLeft:0},200);
		 });
		 
	$(".galleryContainer").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
});