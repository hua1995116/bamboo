

$(function(){
	//替换标题
	$(".bamboo_list").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
	
	$(".comment_list").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
	
	var $comment_id = $(".comment_id").val();
	var $user_id = $(".user_id").val();
	var $bamboo_id = $(".bamboo_id").val();
	$(".delete").click(function(){
		art.dialog({
			title:'删除提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除吗？',
			icon:'warning',
			ok: function () {
				$.ajax({
					url:"ajax_del_com.php",
					type:"POST",
					data:"commentid="+$comment_id+"&userid="+$user_id+"&bambooid="+$bamboo_id,
					success:function(data){
						art.dialog({
						lock: true,
						background: '#000', 
						opacity: 0.87,
						content: '删除成功！',
						icon: 'face-smile',
						ok: function () {
							location.reload();
						},
						close:function(){
							location.reload();
						}
						})
					}
				})
    		},
    		cancel:true
		})
	})
})