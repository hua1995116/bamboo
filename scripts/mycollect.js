

$(function(){
	//替换标题
	$(".bamboo_list").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
	
	$(".collect_list").hover(function(){
		var $title = $(this).find("input").val();
		$(this).find("img").attr("title",$title);
	})
	
	var $collect_id = $(".collect_id").val();
	var $user_id = $(".user_id").val();
	var $bamboo_id = $(".bamboo_id").val();
	$(".delete").click(function(){
		art.dialog({
			title:'取消收藏提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要取消收藏吗？',
			icon:'warning',
			ok: function () {
				$.ajax({
					url:"ajax_del_col.php",
					type:"POST",
					data:"collectid="+$collect_id+"&userid="+$user_id+"&bambooid="+$bamboo_id,
					success:function(data){
						if(data){
							art.dialog({
							lock: true,
							background: '#000', 
							opacity: 0.87,
							content: '取消收藏成功！',
							icon: 'face-smile',
							ok: function () {
								location.reload();
							},
							close:function(){
								location.reload();
							}
							})
						}
					}
				})
    		},
    		cancel:true
		})
	})
})