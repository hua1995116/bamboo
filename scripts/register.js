

$(function(){
	var $sum = 0;
	var $sum1 = 0;
	var $sum2 = 0;
	var $sum3 = 0;
	var $sum4 = 0;
	var $sum5 = 0;
	//验证码刷新
	$('#code').click(function(){
		$('#code').attr("src","code.php?tm="+Math.random());
		$('._code').focus();
		return false;
 	});
	$('#_change a').click(function(){
		$('#code').attr("src","code.php?tm="+Math.random());
		$('._code').focus();
		return false;
 	});
	//检测用户名
	$('.input_username').focus(function(){
		if($(this).siblings(".username_msg").text() != "请输入用户名！"){
			$(this).siblings(".username_msg").text("请输入用户名！");
			}
		$(this).siblings(".username_msg")
			.css({"background":"none","padding":"0","display":"block"});
		 $sum1 = 0;
		})	
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.username_msg').text("用户名不能为空！");
			$(this).siblings('.username_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum1 = 0;
			}
		else if($(this).val().length < 2){
			$(this).siblings('.username_msg').text("用户名不能小于2位！");
			$(this).siblings('.username_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum1 = 0;
			}
		else if(/[<>\'\"\ ]/.test($(this).val())){
			$(this).siblings('.username_msg').text("用户名不得包含特殊字符！");
			$(this).siblings('.username_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum1 = 0;
			} 
		else{
			$.ajax({
				url:"ajax_username.php",
				type:"POST",
				data:"username="+$(this).val(),
				success:function(data){
					if(data){
						$('.input_username').siblings('.username_msg').text("该用户名已经存在！");
						$('.input_username').siblings('.username_msg')
							.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
						$sum1 = 0;
						}
					else{
						$('.input_username').siblings('.username_msg').text("");
						$('.input_username').siblings('.username_msg')
							.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
						$sum1 = 1;
						}
					}
				});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
		})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.username_msg').text("请输入用户名！");
		}
	})
	//检测密码
	$('.input_password').focus(function(){
		if($(this).siblings('.password_msg').text() != "密码长度5-16位！"){
			$(this).siblings('.password_msg').text("密码长度5-16位！");
			}
		$(this).siblings('.password_msg')
				.css({"background":"none","padding":"0","display":"block"});
		$sum2 = 0;
		});
	$('.input_password').blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.password_msg').text("密码不能为空！");
			$(this).siblings('.password_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum2 = 0;
			}
		else if($(this).val().length < 5){
			$(this).siblings('.password_msg').text("密码不能小于5位！");
			$(this).siblings('.password_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum2 = 0;
			}
		else{
			$(this).siblings('.password_msg').text("");
			$(this).siblings('.password_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			$sum2 = 1;
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
		})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.password_msg').text("密码长度5-16位！");
		}
	})
	//检测确认密码
	$('.input_repassword').focus(function(){
		if($(this).siblings('.repassword_msg').text() != "请再次输入密码！"){
			$(this).siblings('.repassword_msg').text("请再次输入密码！");
			}
		$(this).siblings('.repassword_msg')
				.css({"background":"none","padding":"0","display":"block"});
		$sum3 = 0;
		})
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.repassword_msg').text("确认密码不能为空！");
			$(this).siblings('.repassword_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum3 = 0;
			}
		else if($(this).val() != $('.input_password').val()){
			$(this).siblings('.repassword_msg').text("两次密码不一致！");
			$(this).siblings('.repassword_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum3 = 0;
			}
		else{
			$(this).siblings('.repassword_msg').text("");
			$(this).siblings('.repassword_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			$sum3 = 1;
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
		})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.repassword_msg').text("请再次输入密码！");
		}
	})
	//检测邮箱
	$('.input_email').focus(function(){
		if($(this).siblings('.email_msg').text() != "请输入常用的邮箱！"){
			$(this).siblings('.email_msg').text("请输入常用的邮箱！");
		}
		$(this).siblings('.email_msg')
				.css({"background":"none","padding":"0","display":"block"});
		$sum4 = 0;
		})
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.email_msg').text("邮箱不能为空！");
			$(this).siblings('.email_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum4 = 0;
			}
		else if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test($(this).val())){
			$(this).siblings('.email_msg').text("邮箱地址不正确！");
			$(this).siblings('.email_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			$sum4 = 0;
			}
		else{
			$(this).siblings('.email_msg').text("");
			$(this).siblings('.email_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			$sum4 = 1;
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
	})
	.focus(function(){
		$(this).triggerHandler("blur");
	})
	//检测验证码
	$('.input_code').focus(function(){
		if($(this).siblings('.code_msg').text() != "请输入验证码！"){
			$(this).siblings('.code_msg').text("请输入验证码！");
			}
		$(this).siblings('.code_msg')
				.css({"background":"none","padding":"0","display":"block"});
		$sum5 = 0;
		})
	.blur(function(){
		$.ajax({
			url:"ajax_code.php",
			type:"POST",
			data:"code="+$(this).val(),
			success:function(data){
				if(data){
					$('.input_code').siblings('.code_msg').text("");
					$('.input_code').siblings('.code_msg')
						.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
					$sum5 = 1;
					}
				else{
					$('.input_code').siblings('.code_msg').text("验证码不正确！");
					$('.input_code').siblings('.code_msg')
						.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
					$sum5 = 0;
					}
				}
			});
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
		})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.code_msg').text("请输入验证码！");
		}
	})
	//提交
	$('.reg_sub').click(function(){
		$sum = $sum1 + $sum2 + $sum3 + $sum4 + $sum5;
		if($sum != 5){
			$(this).siblings('.sub_msg')
				.css({"display":"block","background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"})
				.fadeOut(4000);
			return false;
		}
	});	

	$(".main_nav .sidelist").hover(function(){
		var nav_index = $(".main_nav .sidelist").index(this);
		var nav_pos = nav_index * (-80) - 40;
		if(nav_index == 0){
			$(this).animate({
		 		"background-position-y": "-40px"
			}, 200);

			$(".nav_title").css("background","#112477");
			$(".sidebar").css("border-color","#112477");
		} else if(nav_index == 1){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#513E2C");
			$(".sidebar").css("border-color","#513E2C");
		} else if(nav_index == 2){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#7B6D61");
			$(".sidebar").css("border-color","#7B6D61");
		} else if(nav_index == 3){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#F8ACC0");
			$(".sidebar").css("border-color","#F8ACC0");
		} else if(nav_index == 4){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#1FA5DD");
			$(".sidebar").css("border-color","#1FA5DD");
		} else if(nav_index == 5){
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);

			$(".nav_title").css("background","#C1000A");
			$(".sidebar").css("border-color","#C1000A");
		}
	},function(){
		var nav_index = $(".main_nav .sidelist").index(this);
		var nav_pos = nav_index * (-80);
		if(nav_index == 0){
			$(this).animate({
			 	"background-position-y": "0px"
			}, 200);
		} else{
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);
		}

		$(".nav_title").css("background","#a42c6a");
		$(".sidebar").css("border-color","#a42c6a");
	});
})