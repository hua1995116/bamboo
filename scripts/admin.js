// JavaScript Document

$(function(){
	$("table tr:nth-child(odd)").css("background-color","#aaa");
	
	//审核橙果
	$(".check").click(function(){
		var $articleid = $(this).siblings(".article_id").val();
		index = $(".check").index(this);
		$.ajax({
			url:"ajax_check.php",
			type:"POST",
			data:"articleid="+$articleid,
			success:function(data){
				if(data){
					$(".check").eq(index).removeClass("check").addClass("checked").text("已审核");
				}
			}
		})
	})
	
	//删除艺竹
	$(".delete").click(function(){
		var $articleid = $(this).siblings(".article_id").val();
		var $userid = $(this).siblings(".user_id").val();
		var index = $(".delete").index(this);
		art.dialog({
			title:'删除提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除该艺竹吗？',
			icon:'question',
			ok: function () {
				$.ajax({
					url:"ajax_del.php",
					type:"POST",
					data:"articleid="+$articleid+"&userid="+$userid,
					success:function(data){
						if(data){
							$(".delete").eq(index).css("background","#545454").text("已删除");
						}
					}
				})
    		},
    		cancel:true
		})
	})
	
	//删除评分
	$(".delete_star").click(function(){
		var $articleid = $(this).siblings(".article_id").val();
		var $starid = $(this).siblings(".star_id").val();
		var index = $(".delete_star").index(this);
		art.dialog({
			title:'删除提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除该评分吗？',
			icon:'question',
			ok: function () {
				$.ajax({
					url:"ajax_del_star.php",
					type:"POST",
					data:"starid="+$starid+"&articleid="+$articleid,
					success:function(data){
						if(data){
							$(".delete_star").eq(index).css("background","#545454").text("已删除");
						}
					}
				})
    		},
    		cancel:true
		})
	})
	
	//删除评论
	$(".delete_com").click(function(){
		var $commentid = $(this).siblings(".comment_id").val();
		var $userid = $(this).siblings(".user_id").val();
		var $articleid = $(this).siblings(".article_id").val();
		var index = $(".delete_com").index(this);
		art.dialog({
			title:'删除提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除该评论吗？',
			icon:'question',
			ok: function () {
				$.ajax({
					url:"ajax_del_com.php",
					type:"POST",
					data:"commentid="+$commentid+"&userid="+$userid+"&bambooid="+$articleid,
					success:function(data){
						if(data){
							$(".delete_com").eq(index).css("background","#545454").text("已删除");
						}
					}
				})
    		},
    		cancel:true
		})
	})
	
	//禁言用户
	$(".gag").click(function(){
		var $userid = $(this).siblings(".user_id").val();
		var index = $(".gag").index(this);
		art.dialog({
			title:'禁言提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要禁言该用户吗？',
			icon:'question',
			ok: function () {
				$.ajax({
					url:"ajax_gag.php",
					type:"POST",
					data:"userid="+$userid,
					success:function(data){
						if(data){
							$(".gag").eq(index).text("取消禁言").removeClass(".gag").addClass(".del_gag");
						}
					}
				})
    		},
    		cancel:true
		})
	})
	
	//取消禁言用户
	$(".del_gag").click(function(){
		var $userid = $(this).siblings(".user_id").val();
		var index = $(".del_gag").index(this);
		$.ajax({
			url:"ajax_del_gag.php",
			type:"POST",
			data:"userid="+$userid,
			success:function(data){
				if(data){
					$(".del_gag").eq(index).text("禁言").removeClass(".del_gag").addClass(".gag");
				}
			}
		})
	})
	
	//删除用户
	$(".delete_user").click(function(){
		var $userid = $(this).siblings(".user_id").val();
		var index = $(".delete_user").index(this);
		art.dialog({
			title:'删除提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要删除该用户吗？',
			icon:'question',
			ok: function () {
				$.ajax({
					url:"ajax_del_user.php",
					type:"POST",
					data:"userid="+$userid,
					success:function(data){
						if(data){
							$(".delete_user").eq(index).css("background","#545454").text("已删除");
						}
					}
				})
    		},
    		cancel:true
		})
	});

})