

$(function(){
	// 搜索框
	$('.search_box').focus(function(){
		$('.search_area form').css("border-color","#2A3424")
		var $focus_value = $(this).val();
		if($focus_value == "搜索艺竹"){
			$(this).val("");
			$(this).css("color","#fff");
		}
	});
	$('.search_box').blur(function(){
		$('.search_area form').css("border-color","#2A3424")
		var $blur_value = $(this).val();
		if($blur_value == ""){
			$(this).val(this.defaultValue);
			$(this).css("color","#ccc");
		}
	});

	// 右侧图标切换
	var body_w = $("body").width();
	var icon_left = body_w/2+450+50;
	$("#search_b,#login_b,#after_login_b,#elevator").css('left', icon_left+'px');

	$("#search_b").hover(function(){
		if(!$(".search_area").is(":animated")){
			$(".search_area").fadeIn(150);
		}
	},function(){
		$(".search_area").fadeOut(150);
	});

	$("#after_login_b").hover(function(){
		if(! $(".user_operate").is(":animated")){
			$(".user_operate").fadeIn(150)
		}
	},function(){
		$(".user_operate").fadeOut(150)
	})

	//登录框
	$('#login_b').click(function(){
		art.dialog({
			title:'登录艺竹',
			content:document.getElementById('login_area'),
			id:'1'
		})
	});

	//退出提醒
	$('.logout').click(function(){
		art.dialog({
			title:'退出提醒',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content:'真的要退出吗？',
			icon:'warning',
			ok: function () {
				window.location.href="logout.php";
    		},
    		cancel:true
		})
	});

	//返回顶部
	$(window).scroll(function(){
		var scrolltop=$(this).scrollTop();		
		if(scrolltop>=100){		
			$("#elevator").show();
		}else{
			$("#elevator").hide();
		}

		if(scrolltop > 292){
		 	$(".content_title").css({"position":"fixed","top":"170px"});
		} else {
			$(".content_title").css("position","inherit");
		}
	});
	$("#elevator").click(function(){
		$("html,body").animate({scrollTop: 0}, 500);	
	});

})