

$(function(){
	$('.galleryImage').hover(
		function(){
			$(this).find('img').animate({width:165, height:110, marginTop:10, marginLeft:52},200);
		 },
		 function(){
			 $(this).find('img').animate({width:270, height:180, marginTop:0, marginLeft:0},200);
		 });
		 
	$(".galleryContainer").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})

	$(".new_msg").click(function(){
		art.dialog({
			title:'推广消息',
			content:document.getElementById('new_area'),
			id:'22'
		})
	})
	
	//删除评论
	$(".delete_new").click(function(){
		var $newid = $(this).siblings(".delete_id").val();
		var index = $(".delete_new").index(this);
		art.dialog({
			title:'删除提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除该消息吗？',
			icon:'question',
			ok: function () {
				$.ajax({
					url:"ajax_del_new.php",
					type:"POST",
					data:"newid="+$newid,
					success:function(data){
						if(data){
							$(".delete_new").eq(index).css("background","#545454").text("已删除");
						}
					}
				})
    		},
    		cancel:true
		})
	})
})