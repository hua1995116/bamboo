

$(function(){
	var $friend_id = $(".friend_id").val();
	var $user_id = $(".user_id").val();
	$(".del_friend").click(function(){
		art.dialog({
			title:'删除好友提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除该好友吗？',
			icon:'warning',
			ok: function () {
				$.ajax({
					url:"ajax_del_friend.php",
					type:"POST",
					data:"friendid="+$friend_id+"&userid="+$user_id,
					success:function(data){
						if(data){
							art.dialog({
							lock: true,
							background: '#000', 
							opacity: 0.87,
							content: '删除好友成功！',
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