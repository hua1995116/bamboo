

$(function(){
	var $check_cookie = $(".check_cookie").val();
	if($check_cookie == 0){
		$(".add_friend").click(function(){
			art.dialog({
				lock: true,
				background: '#000', 
				opacity: 0.87,
				content: '请先登录',
				icon: 'face-sad',
				ok: function () {
				},
				close:function(){
				}
			})
		})
	} else {
		var $userid = $(".userid").val();
		var $beuserid = $(".beuserid").val();
		$(".add_friend").click(function(){
			$.ajax({
				url:"ajax_friend.php",
				type:"POST",
				data:"userid="+$userid+"&beuserid="+$beuserid,
				success:function(data){
					if(data){
						$(".add_friend").hide();
						$(".add_friend").siblings(".has_friend").show();
					} else {
						return false;
					}
				}
			})
		})
	}
})