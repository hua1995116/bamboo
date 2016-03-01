

$(function(){

	//滚动条
	$(window).scroll(function(){
		 var vtop=$(document).scrollTop();
		 if(vtop > 0){
		 	$(".title_area").css({"position":"fixed","top":"170px"});
		 } else {
			 $(".title_area").css("position","inherit");
		}
	})

	//展示评分
	$(".see_score,.score_show").click(function(){
		art.dialog({
			title:'历史评分',
			content:document.getElementById('score_his_area'),
			id:'10'
		})
	})
	$(".star_his_model,.star_his_color,.star_his_material,.star_his_fashion").raty({
		path : 'images',
		size : 16,
		starHalf : 'star-half.png',
		starOff : 'star-off.png',
		starOn : 'star-on.png',
		number : 5,
		readOnly : true,
		hints : ["差","下","中","良","优"],
		space: false,
		score : function(){
			return $(this).attr('data-score');
		}
	});

	//联系作者
	$('.contact').click(function(){
		art.dialog({
			title:'联系作者',
			content:document.getElementById('contact_area'),
			id:'12'
		})
	})
	$('.contact_body textarea').focus(function(){
		$(this).css("border-color","#a42c6a")
		var $focus_value = $(this).val();
		if($focus_value == "在此输入要对他说的话，不能超过100个字"){
			$(this).val("");
		}
	});
	$('.contact_body textarea').blur(function(){
		$(this).css("border-color","#000")
		var $blur_value = $(this).val();
		if($blur_value == ""){
			$(this).val(this.defaultValue);
		}
	});
	
	//举报
	$('.accuse').click(function(){
		art.dialog({
			title:'举报该橙果',
			content:document.getElementById('accuse_area'),
			id:'2'
		})
	});
	
	//举报理由
	$('.accuse_reason textarea').focus(function(){
		$(this).css("border-color","#ff6113")
		var $focus_value = $(this).val();
		if($focus_value == "请输入举报理由"){
			$(this).val("");
		}
	});
	$('.accuse_reason textarea').blur(function(){
		$(this).css("border-color","#000")
		var $blur_value = $(this).val();
		if($blur_value == ""){
			$(this).val(this.defaultValue);
		}
	});

	//左侧导航
	var bamboo_type = $(".bamboo_type").val();
	if(bamboo_type == 2){
		$(".nav_title").css("background","#513E2C");
		$(".sidebar").css("border-color","#513E2C");
		$(".title_area").css("background","#513E2C");
		$("._msg").css("border-color","#513E2C");
		$("#header").css("background","url(images/bamboo1.png) center top no-repeat");
		$("#body_bg").css("background","url(images/bamboo1.png) center top no-repeat");
		$("#logo").css("top", "0px");
	} else if(bamboo_type == 3){
		$(".nav_title").css("background","#7B6D61");
		$(".sidebar").css("border-color","#7B6D61");
		$(".title_area").css("background","#7B6D61");
		$("._msg").css("border-color","#7B6D61");
		$("#header").css("background","url(images/bamboo2.png) center top no-repeat");
		$("#body_bg").css("background","url(images/bamboo2.png) center top no-repeat");
		$("#logo").css("top", "25px");
	} else if(bamboo_type == 4){
		$(".nav_title").css("background","#F8ACC0");
		$(".sidebar").css("border-color","#F8ACC0");
		$(".title_area").css("background","#F8ACC0");
		$("._msg").css("border-color","#F8ACC0");
		$("#header").css("background","url(images/bamboo3.png) center top no-repeat");
		$("#body_bg").css("background","url(images/bamboo3.png) center top no-repeat");
		$("#logo").css("top", "0px");
	} else if(bamboo_type == 5){
		$(".nav_title").css("background","#1FA5DD");
		$(".sidebar").css("border-color","#1FA5DD");
		$(".title_area").css("background","#1FA5DD");
		$("._msg").css("border-color","#1FA5DD");
		$("#header").css("background","url(images/bamboo4.png) center top no-repeat");
		$("#body_bg").css("background","url(images/bamboo4.png) center top no-repeat");
		$("#logo").css("top", "0px");
	} else if(bamboo_type == 6){
		$(".nav_title").css("background","#C1000A");
		$(".sidebar").css("border-color","#C1000A");
		$(".title_area").css("background","#C1000A");
		$("._msg").css("border-color","#C1000A");
		$("#header").css("background","url(images/bamboo5.png) center top no-repeat");
		$("#body_bg").css("background","url(images/bamboo5.png) center top no-repeat");
		$("#logo").css("top", "0px");
	} else{
		$(".nav_title").css("background","#112477");
		$(".sidebar").css("border-color","#112477");
		$(".title_area").css("background","#112477");
		$("._msg").css("border-color","#112477");
		$("#header").css("background","url(images/bamboo0.png) center top no-repeat");
		$("#body_bg").css("background","url(images/bamboo0.png) center top no-repeat");
		$("#logo").css("top", "5px");
	}

	var nav_select = (bamboo_type-1)*(-166);
	$(".main_nav .sidelist").eq(bamboo_type-1).css({'background':'url(images/left_select.png) '+nav_select+'px 0 no-repeat'});

	// 左侧导航
	$(".main_nav .sidelist").hover(function(){
		var nav_index = $(".main_nav .sidelist").index(this);
		var nav_pos = nav_index * (-80) - 40;
		if(nav_index == 0){
			$(this).animate({
		 		"background-position-y": "-40px"
			}, 200);

			$(".nav_title").css("background","#112477");
			$(".sidebar").css("border-color","#112477");
			$(".title_area").css("background","#112477");
			$("._msg").css("border-color","#112477");
		} else if(nav_index == 1){
			if(nav_index == bamboo_type-1){
				$(this).animate({
				 	"background-position-y": "-40px"
				}, 200);
			} else{
				$(this).animate({
				 	"background-position-y": nav_pos + "px"
				}, 200);
			}

			$(".nav_title").css("background","#513E2C");
			$(".sidebar").css("border-color","#513E2C");
			$(".title_area").css("background","#513E2C");
			$("._msg").css("border-color","#513E2C");
		} else if(nav_index == 2){
			if(nav_index == bamboo_type-1){
				$(this).animate({
				 	"background-position-y": "-40px"
				}, 200);
			} else{
				$(this).animate({
				 	"background-position-y": nav_pos + "px"
				}, 200);
			}

			$(".nav_title").css("background","#7B6D61");
			$(".sidebar").css("border-color","#7B6D61");
			$(".title_area").css("background","#7B6D61");
			$("._msg").css("border-color","#7B6D61");
		} else if(nav_index == 3){
			if(nav_index == bamboo_type-1){
				$(this).animate({
				 	"background-position-y": "-40px"
				}, 200);
			} else{
				$(this).animate({
				 	"background-position-y": nav_pos + "px"
				}, 200);
			}

			$(".nav_title").css("background","#F8ACC0");
			$(".sidebar").css("border-color","#F8ACC0");
			$(".title_area").css("background","#F8ACC0");
			$("._msg").css("border-color","#F8ACC0");
		} else if(nav_index == 4){
			if(nav_index == bamboo_type-1){
				$(this).animate({
				 	"background-position-y": "-40px"
				}, 200);
			} else{
				$(this).animate({
				 	"background-position-y": nav_pos + "px"
				}, 200);
			}

			$(".nav_title").css("background","#1FA5DD");
			$(".sidebar").css("border-color","#1FA5DD");
			$(".title_area").css("background","#1FA5DD");
			$("._msg").css("border-color","#1FA5DD");
		} else if(nav_index == 5){
			if(nav_index == bamboo_type-1){
				$(this).animate({
				 	"background-position-y": "-40px"
				}, 200);
			} else{
				$(this).animate({
				 	"background-position-y": nav_pos + "px"
				}, 200);
			}

			$(".nav_title").css("background","#C1000A");
			$(".sidebar").css("border-color","#C1000A");
			$(".title_area").css("background","#C1000A");
			$("._msg").css("border-color","#C1000A");
		}
	},function(){
		var nav_index = $(".main_nav .sidelist").index(this);
		var nav_pos = nav_index * (-80);
		if(nav_index == bamboo_type-1){
			$(this).animate({
			 	"background-position-y": "0px"
			}, 200);
		} else{
			$(this).animate({
			 	"background-position-y": nav_pos + "px"
			}, 200);
		}

		if(bamboo_type == 2){
			$(".nav_title").css("background","#513E2C");
			$(".sidebar").css("border-color","#513E2C");
			$(".title_area").css("background","#513E2C");
			$("._msg").css("border-color","#513E2C");
		} else if(bamboo_type == 3){
			$(".nav_title").css("background","#7B6D61");
			$(".sidebar").css("border-color","#7B6D61");
			$(".title_area").css("background","#7B6D61");
			$("._msg").css("border-color","#7B6D61");
		} else if(bamboo_type == 4){
			$(".nav_title").css("background","#F8ACC0");
			$(".sidebar").css("border-color","#F8ACC0");
			$(".title_area").css("background","#F8ACC0");
			$("._msg").css("border-color","#F8ACC0");
		} else if(bamboo_type == 5){
			$(".nav_title").css("background","#1FA5DD");
			$(".sidebar").css("border-color","#1FA5DD");
			$(".title_area").css("background","#1FA5DD");
			$("._msg").css("border-color","#1FA5DD");
		} else if(bamboo_type == 6){
			$(".nav_title").css("background","#C1000A");
			$(".sidebar").css("border-color","#C1000A");
			$(".title_area").css("background","#C1000A");
			$("._msg").css("border-color","#C1000A");
		} else{
			$(".nav_title").css("background","#112477");
			$(".sidebar").css("border-color","#112477");
			$(".title_area").css("background","#112477");
			$("._msg").css("border-color","#112477");
		}
	});


	// 文章与评论切换
	$(".back_list,.back_article").hover(function() {
		$(this).find("img").animate({left:"-10px"}, 100);
	}, function() {
		$(this).find("img").animate({left:"0"}, 100);
	});

	$(".to_info").hover(function() {
		$(this).find("img").animate({left:"10px"}, 100);
	}, function() {
		$(this).find("img").animate({left:"0"}, 100);
	});

	var content = $("#detail");
	var comment = $("#info");
	
	$(".to_info").click(function(){
		$('body,html').animate({scrollTop:0},300,function(){
			comment.show(0,function(){
				content.animate({marginLeft:-720},300);
				comment.animate({marginLeft:0},300,function(){
					content.hide();
				});
			});
		});
	});
	$(".see_comment").click(function(){
		$('body,html').animate({scrollTop:0},300,function(){
			comment.show(0,function(){
				content.animate({marginLeft:-720},300);
				comment.animate({marginLeft:0},300,function(){
					content.hide();
					$('body,html').animate({scrollTop:500},300)
				});
			});
		});
	})
	
	$(".back_article").click(function(){
		$('body,html').animate({scrollTop:0},300,function(){
			content.show(0,function(){
				content.animate({marginLeft:0},300);
				comment.animate({marginLeft:720},300,function(){
					comment.hide();
				});
			});
		});
	});

	//收藏
	$(".collect").click(function(){
		var $this = $(this);
		var $uid = $(".userid").val();
		var $cid = $(".bambooid").val();
		$.ajax({
			url:"ajax_collect.php",
			type:"POST",
			data:"uid="+$uid+"&cid="+$cid,
			success:function(data){
				if(data){
					$this.hide();
					$this.siblings('.collect_has').show();
					$sum_collect = $(".info_collect span strong");
					$sum_collect_val = parseInt($(".info_collect span strong").text());
					$sum_collect_val += 1;
					$sum_collect.text($sum_collect_val);
				}
			}
		})
		return false;
	});
	$(".no_reg_col").click(function(){
		art.dialog({
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content: '请先登录',
			icon: 'warning',
			ok:true
		})
	});

	//评分
	function trans_level(level){
		var score;
		if(level == "优"){
			score = 90;
		} else if(level == "良"){
			score = 80;
		} else if(level == "中"){
			score = 70;
		} else if(level == "下"){
			score = 60;
		} else if(level == "差"){
			score = 50;
		} else {
			score = 0;
		}
		return score;
	}
	$(".star_input_model").raty({
		path : 'images',
		size : 32,
		starHalf : 'star-half-big.png',
		starOff : 'star-off-big.png',
		starOn : 'star-on-big.png',
		target : '#hint_input_model',
		targetKeep : true,
		number : 5,
		hints : ["差","下","中","良","优"],
		space: false
	})
	$(".star_input_color").raty({
		path : 'images',
		size : 32,
		starHalf : 'star-half-big.png',
		starOff : 'star-off-big.png',
		starOn : 'star-on-big.png',
		target : '#hint_input_color',
		targetKeep : true,
		number : 5,
		hints : ["差","下","中","良","优"],
		space: false
	})
	$(".star_input_material").raty({
		path : 'images',
		size : 32,
		starHalf : 'star-half-big.png',
		starOff : 'star-off-big.png',
		starOn : 'star-on-big.png',
		target : '#hint_input_material',
		targetKeep : true,
		number : 5,
		hints : ["差","下","中","良","优"],
		space: false
	})
	$(".star_input_fashion").raty({
		path : 'images',
		size : 32,
		starHalf : 'star-half-big.png',
		starOff : 'star-off-big.png',
		starOn : 'star-on-big.png',
		target : '#hint_input_fashion',
		targetKeep : true,
		number : 5,
		hints : ["差","下","中","良","优"],
		space: false
	})
	$(".score_submit").click(function(){
		$_bambooid = $(".bambooid").val();
		$_userid = $(".userid").val();
		var $score_model = trans_level($("#hint_input_model").text());
		var $score_color = trans_level($("#hint_input_color").text());
		var $score_material = trans_level($("#hint_input_material").text());
		var $score_fashion = trans_level($("#hint_input_fashion").text());
		if($score_model != 0 && $score_color != 0 && $score_material != 0 && $score_fashion != 0){
			$.ajax({
				url:"ajax_star.php",
				type:"POST",
				data:"score_model="+$score_model+"&score_color="+$score_color+"&score_material="+$score_material+"&score_fashion="+$score_fashion+"&bambooid="+$_bambooid+"&userid="+$_userid,
				success:function(data){
					if(data){
						$(".score_input").fadeOut(300,function(){
							$(".score").empty();
							$(".score").replaceWith(data);
							$(".detail_title p").show();
							$(".score_show").animate({left:"40"},300);
							$(".all_score").animate({left:"-200"},300);
							$(".info").animate({left:"80"},300);
						})
					}
				}
			})
		} else {
			art.dialog({
				lock: true,
				background: '#000', 
				opacity: 0.87,
				content: '请完成所有评分再提交！',
				icon: 'warning',
				ok:true
			})
		}
		return false;
	})

	//评论
	$(".no_reg_com").click(function(){
		art.dialog({
			lock: true,
			background: '#000', 
			opacity: 0.87,
			content: '请先登录',
			icon: 'warning',
			ok:true
		})
	})
	$('.comment_reply input.submit').click(function(){
		$textarea = $(this).siblings('.comment_reply textarea');
		if($textarea.val().length < 5){
			art.dialog({
			title:'提示',
			content:'评论不得少于5个字！',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			icon:'face-sad',
			ok:true
			})
			return false;
		}else if($textarea.val().length > 140){
			art.dialog({
			title:'提示',
			content:'评论不得多于140个字！',
			lock: true,
			background: '#000', 
			opacity: 0.87,
			icon:'face-sad',
			ok:true
			})
			return false;
		}else{
			var $userid = $(this).siblings('.userid').val();
			var $bambooid = $(this).siblings('.bambooid').val();
			var $content = $(this).siblings('textarea').val();
			$.ajax({
				url:"ajax_comment.php",
				type:"POST",
				data:"userid="+$userid+"&bambooid="+$bambooid+"&content="+$content,
				success:function(data){
					if(data){
						$textarea.siblings('span').text("发表评论成功！")
							.show()
							.fadeOut(3000);
						$textarea.val('');
					$('.comment_list_title').after(data);
					$comment_sum = parseInt($('.comment_list_title span').text());
					$comment_sum += 1;
					$('.comment_list_title span').text($comment_sum);
					$('.no_comment').hide();
					}
				}
			})
			return false;
		}
	});
	
	//控制评论数量
	var $comment_num = $(".comment_num").val();
	if($comment_num <= 5){
		$(".showmore").hide();
	}
	//点击显示剩余评论
	$(".showmore").click(function(){
		$(".comment_hide_floor").show();
		$(this).text("已经没有了！");
	});

})