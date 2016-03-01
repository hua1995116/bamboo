

$(function(){
	//个人信息选项卡
	var index = 0;
	$(".member_left .sidelist:eq(0)").addClass("hover");
	$(".member_left .sidelist").click(function(){
		index = $(".member_left .sidelist").index(this);
		$(this).addClass("hover").siblings().removeClass("hover");
		$(".member_data").eq(index).show().siblings().hide();
	});

	//邮箱
	$('.email').focus(function(){
		if($(this).siblings('.email_msg').text() != "请输入常用邮箱！"){
			$(this).siblings('.email_msg').text("请输入常用邮箱！");
			}
		$(this).siblings('.email_msg')
				.css({"background":"none","padding":"0","display":"block"});
		})
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.email_msg').text("邮箱不能为空！");
			$(this).siblings('.email_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test($(this).val())){
			$(this).siblings('.email_msg').text("电子邮箱地址不正确！");
			$(this).siblings('.email_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else{
			$(this).siblings('.email_msg').text("");
			$(this).siblings('.email_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
		})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.email_msg').text("请输入常用邮箱！");
		}
	})
	
	//手机
	$('.phone').focus(function(){
		if($(this).siblings('.phone_msg').text() != "请输入常用的手机号码！"){
			$(this).siblings('.phone_msg').text("请输入常用的手机号码！");
			}
		$(this).siblings('.phone_msg')
				.css({"background":"none","padding":"0","display":"block"});
		})
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.phone_msg').text("手机号码不能为空！");
			$(this).siblings('.phone_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else if(!/^[1]{1}[\d]{10}$/.test($(this).val())){
			$(this).siblings('.phone_msg').text("手机号码格式不正确！");
			$(this).siblings('.phone_msg')
				.css({"background":"url(images/reg_check.png) 0 0px no-repeat","padding":"0 0 0 24px"});
			}
		else{
			$(this).siblings('.phone_msg').text("");
			$(this).siblings('.phone_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
	})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.phone_msg').text("请输入常用的手机号码！");
		}
	})
	
	//QQ
	$('.qq').focus(function(){
		if($(this).siblings('.qq_msg').text() != "请输入常用的QQ号码！"){
			$(this).siblings('.qq_msg').text("请输入常用的QQ号码！");
			}
		$(this).siblings('.qq_msg')
				.css({"background":"none","padding":"0","display":"block"});
		})
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.qq_msg').text("QQ号码不能为空！");
			$(this).siblings('.qq_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else if(!/^[1-9]{1}[\d]{4,10}$/.test($(this).val())){
			$(this).siblings('.qq_msg').text("QQ号码格式不正确！");
			$(this).siblings('.qq_msg')
				.css({"background":"url(images/reg_check.png) 0 0px no-repeat","padding":"0 0 0 24px"});
			}
		else{
			$(this).siblings('.qq_msg').text("");
			$(this).siblings('.qq_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
	})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.qq_msg').text("请输入常用的QQ号码！");
		}
	})
	
	//旧密码
	$('.old_pwd').focus(function(){
		if($(this).siblings('.old_msg').text() != "请输入旧密码！"){
			$(this).siblings('.old_msg').text("请输入旧密码！");
			}
		$(this).siblings('.old_msg')
				.css({"background":"none","padding":"0","display":"block"});
		})
	 .blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.old_msg').text("旧密码不能为空！");
			$(this).siblings('.old_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else if($(this).val().length < 5){
			$(this).siblings('.old_msg').text("密码不能小于5位！");
			$(this).siblings('.old_msg')
				.css({"background":"url(images/reg_check.png) 0 0px no-repeat","padding":"0 0 0 24px"});
			}
		else{
			$(this).siblings('.old_msg').text("");
			$(this).siblings('.old_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
	})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.old_msg').text("请输入旧密码！");
		}
	})
	
	//新密码
	$('.new_pwd').focus(function(){
		if($(this).siblings('.new_msg').text() != "请输入新密码！"){
			$(this).siblings('.new_msg').text("请输入新密码！");
			}
		$(this).siblings('.new_msg')
				.css({"background":"none","padding":"0","display":"block"});
		})
	 .blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.new_msg').text("新密码不能为空！");
			$(this).siblings('.new_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else if($(this).val().length < 5){
			$(this).siblings('.new_msg').text("密码不能小于5位！");
			$(this).siblings('.new_msg')
				.css({"background":"url(images/reg_check.png) 0 0px no-repeat","padding":"0 0 0 24px"});
			}
		else{
			$(this).siblings('.new_msg').text("");
			$(this).siblings('.new_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
	})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.new_msg').text("请输入新密码！");
		}
	})
		
	//确认密码
	$('.re_pwd').focus(function(){
		if($(this).siblings('.re_msg').text() != "请输入确认密码！"){
			$(this).siblings('.re_msg').text("请输入确认密码！");
			}
		$(this).siblings('.re_msg')
				.css({"background":"none","padding":"0","display":"block"});
		})
	.blur(function(){
		if($(this).val() == ""){
			$(this).siblings('.re_msg').text("确认密码不能为空！");
			$(this).siblings('.re_msg')
				.css({"background":"url(images/reg_check.png) 0 0 no-repeat","padding":"0 0 0 24px"});
			}
		else if($(this).val() != $('.new_pwd').val()){
			$(this).siblings('.re_msg').text("两次密码不一致！");
			$(this).siblings('.re_msg')
				.css({"background":"url(images/reg_check.png) 0 0px no-repeat","padding":"0 0 0 24px"});
			}
		else{
			$(this).siblings('.re_msg').text("");
			$(this).siblings('.re_msg')
				.css({"background":"url(images/reg_check.png) 0 -22px no-repeat","padding":"0 0 0 24px"});
			}
		})
	.keyup(function(){
		$(this).triggerHandler("blur");
	})
	.focus(function(){
		if($(this.val() == "")){
			$(this).triggerHandler("blur");
		} else {
			$(this).siblings('.re_msg').text("请输入确认密码！");
		}
	})
})