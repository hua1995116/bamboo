jQuery.cookie = function(b, j, m) {
	if (typeof j != "undefined") {
		m = m || {};
		if (j === null) {
			j = "";
			m.expires = -1
		}
		var e = "";
		if (m.expires && (typeof m.expires == "number" || m.expires.toUTCString)) {
			var f;
			if (typeof m.expires == "number") {
				f = new Date();
				f.setTime(f.getTime() + (m.expires * 24 * 60 * 60 * 1000))
			} else {
				f = m.expires
			}
			e = "; expires=" + f.toUTCString()
		}
		var l = m.path ? "; path=" + (m.path) : "";
		var g = m.domain ? "; domain=" + (m.domain) : "";
		var a = m.secure ? "; secure" : "";
		document.cookie = [b, "=", encodeURIComponent(j), e, l, g, a].join("")
	} else {
		var d = null;
		if (document.cookie && document.cookie != "") {
			var k = document.cookie.split(";");
			for (var h = 0; h < k.length; h++) {
				var c = jQuery.trim(k[h]);
				if (c.substring(0, b.length + 1) == (b + "=")) {
					d = decodeURIComponent(c.substring(b.length + 1));
					break
				}
			}
		}
		return d
	}
};
$(function() {
	anisee.init.searchs();
	anisee.init.scrolls();
	anisee.init.returns();
	anisee.init.preview();
	anisee.init.comment()
});
anisee = {};
anisee.ctrl = {
	prev: function() {
		try {
			var a = parseInt(param[0]),
				c = parseInt(param[1]) - 1;
			if (c > -1) {
				location.href = urlinfo.replace("<from>", a).replace("<pos>", c)
			} else {
				alert("没有上一集了哦")
			}
		} catch (b) {}
	},
	next: function() {
		try {
			var a = parseInt(param[0]),
				c = parseInt(param[1]) + 1;
			if (VideoListJson[a][1].length > c) {
				location.href = urlinfo.replace("<from>", a).replace("<pos>", c)
			} else {
				alert("没有下一集了哦")
			}
		} catch (b) {}
	},
	fav: function() {
		ctrl = navigator.userAgent.toLowerCase().indexOf("mac") != -1 ? "Command/Cmd" : "CTRL";
		try {
			window.external.addFavorite(location.href + "#", document.title)
		} catch (b) {
			try {
				window.sidebar.addPanel(document.title, location.href + "#", "")
			} catch (a) {
				alert("您可以尝试通过快捷键 " + ctrl + " + D 加入到收藏夹!")
			}
		}
		return false
	},
	chat: function() {
		$("html,body").animate({
			scrollTop: $("#comment").offset().top + 1
		})
	},
	feed: function() {
		window.open("feedback.html?&re=" + location.pathname.replace("/", ""))
	}
};
anisee.data = {
	sort: function(e, d, f) {
		if (f.className.indexOf("_on") == -1) {
			if (e == 0) {
				document.getElementById("desc_" + d).className = "desc";
				f.className = "asc asc_on"
			} else {
				document.getElementById("asc_" + d).className = "asc";
				f.className = "desc desc_on"
			}
			document.getElementById("play_" + d).innerHTML = "<ul>" + document.getElementById("play_" + d).getElementsByTagName("ul")[0].innerHTML.toLowerCase().split("</li>").reverse().join("</li>").substring(5) + "</li></ul>"
		}
	},
	open: function(b, a) {
		if (b.className == "") {
			b.className = "on";
			if ($("#play_" + a).find("li").length > 30) {
				$("#play_" + a).height("auto")
			}
			b.innerHTML = "收起"
		} else {
			b.className = "";
			if ($("#play_" + a).find("li").length > 30) {
				$("#play_" + a).height("195px")
			}
			b.innerHTML = "展开"
		}
	},
	tips: function(c, b, d, a) {
		a = a || 300;
		b = b || 0;
		d = d || 150;
		var f;
		if (!document.getElementById("tip")) {
			var e = $('<div id="tip"><div id="tip_shadow" class="tip_right"><div id="tip_out"><s id="tip_arrow"><i></i></s><div id="tip_content"></div></div></div></div>');
			$("body").append(e)
		}
		c.mouseover(function(h) {
			var g = this;
			f && clearTimeout(f);
			f = setTimeout(function() {
				$("#tip_content").html('<div class="tip_cover"><img src="' + $(g).attr("i") + '" /><br />' + $(g).text() + "</div>");
				$("#tip").show("fast");
				var i = 180;
				var l = $(g).offset().top - (i - 14) / 2;
				var k = $(g).offset().left;
				k = b == 1 ? k + d : k - d;
				document.getElementById("tip_shadow").className = b == 1 ? "tip_left" : "tip_right";
				var j = (i - 28) / 2;
				$("#tip_arrow").css({
					top: j + "px"
				});
				$("#tip").css({
					top: l + "px",
					left: k + "px"
				})
			}, a)
		}).mouseout(function() {
			f && clearTimeout(f);
			$("#tip").hide()
		})
	},
	update: function(a) {
		$.post("/" + sitePath + "inc/ajax.asp?action=hit&id=" + a)
	}
};
anisee.score = {
	texts: ["超酷", "好看", "一般", "无聊", "差劲"],
	vid: {},
	data: {},
	get: function() {
		$.getJSON("/" + sitePath + "inc/score.asp?rnd=" + Math.random(), {
			g: 1,
			id: this.vid
		}, function(a) {
			anisee.score.data = a;
			anisee.score.format()
		})
	},
	send: function(a) {
		$.get("/" + sitePath + "inc/score.asp?rnd=" + Math.random(), {
			g: 0,
			id: this.vid,
			s: a
		}, function(b) {
			if (b == 1) {
				alert("评分已提交，非常感谢您的参与！")
			} else {
				if (b == 0) {
					alert("囧,-_-|||，您已经评过分了哦？明天再来吧……")
				} else {
					alert("非常抱歉，评分失败,请稍候重试！")
				}
			}
		})
	},
	hasSend: function() {
		var a = $.cookie("voted_" + this.vid);
		$.cookie("voted_" + this.vid, this.vid);
		if (a == null || a == "") {
			return false
		} else {
			return ("," + a + ",").indexOf("," + this.vid + ",") == -1 ? false : true
		}
	},
	format: function() {
		var g = this.data;
		var f = g.t;
		var d = [];
		var c = Math.max.apply(Math, g.s);
		var b = 46;
		var h = g.t > 0 ? ((g.s[0] + 2 * g.s[1] + 3 * g.s[2] + 4 * g.s[3] + 5 * g.s[4]) / f * 2).toFixed(1) : "0.0";
		h = h.substring(0, 3);
		d.push('<div class="score_avg"><span><em>' + h + "</em><i>" + h + "</i></span></div>");
		d.push('<div class="score_total">评分<span>' + g.t + '</span>人</br>点击<span id="hit"></span>次</div>');
		d.push('<ul class="score_list">');
		for (var e = 0; e <= 4; e++) {
			var a = c > 0 ? (b * g.s[4 - e] / c).toFixed(0) : 0;
			d.push("<li><span>" + anisee.score.texts[e] + '</span><i style="width:' + a + 'px"></i> <em>' + g.s[4 - e] + "人</em></li>")
		}
		d.push("</ul>");
		$("#score_content").html(d.join(""));
		$.get("/" + sitePath + "inc/ajax.asp?action=get&id=" + this.vid, function(i) {
			$("#hit").html(i)
		})
	},
	init: function(a) {
		this.vid = a;
		this.get();
		var b = 26;
		$("#star_current_rating").css("width", 0);
		$("#starlist > li").click(function() {
			if (!anisee.score.hasSend()) {
				var c = $(this).attr("i");
				anisee.score.send(c);
				$("#star_current_rating").css({
					width: b * c
				});
				anisee.score.data.t++;
				anisee.score.data.s[c - 1]++;
				anisee.score.format();
				$("#starlist").html("");
				$("#star_desc").html("评分已提交，" + c + "星，" + anisee.score.texts[5 - c])
			} else {
				alert("囧,-_-|||，您已经评过分了哦？明天再来吧……")
			}
		});
		$("#starlist > li").hover(function() {
			var c = $(this).attr("i");
			$("#star_tip").show();
			$("#star_tip_arrow").css("left", b * c - 20 + "px");
			$("#star_desc").html(c + "星，" + anisee.score.texts[5 - c])
		}, function() {
			$("#star_tip").hide()
		})
	}
};
anisee.turn = {
	closed: false,
	timer: null,
	show: true,
	off: function() {
		var b = this;
		$(".turn").addClass("off").text("开灯");
		$("#lighter").height($(document).height());
		$("#lighter").fadeTo(200, 0.95, function() {
			b.closed = true;
			$(document).bind("keydown", "esc", function() {
				b.on()
			});
			$(this).dblclick(function() {
				b.on()
			});
			$(this).mousemove(function() {
				if (b.show === false) {
					$(".turn").show();
					b.show = true
				}
				b.timer && clearTimeout(b.timer);
				b.timer = setTimeout(function() {
					$(".turn").hide();
					b.show = false
				}, 3000)
			})
		})
	},
	on: function() {
		var b = this;
		$("#lighter").fadeOut(300, function() {
			b.timer && clearTimeout(b.timer);
			b.closed = false;
			$(this).unbind("dblclick mousemove");
			$(".turn").removeClass("off").text("关灯").show()
		})
	},
	init: function() {
		var b = this;
		$("body").append('<div id="lighter"></div>');
		$(".turn").bind("click", function() {
			b.closed == false ? b.off() : b.on()
		})
	}
};
anisee.wide = {
	target: "#player iframe,#player .playbar",
	status: false,
	init: function() {
		var b = this;
		$(".wide").click(function() {
			if (!$(b.target).is(":animated")) {
				if (b.status == false) {
					b.status = true;
					$(b.target).animate({
						width: "960px"
					});
					$(".wide").text("标屏")
				} else {
					b.status = false;
					$(b.target).animate({
						width: "648px"
					});
					$(".wide").text("宽屏")
				}
			}
		})
	}
};
eval(function(h, b, j, f, g, i) {
	g = function(a) {
		return (a < b ? "" : g(parseInt(a / b))) + ((a = a % b) > 35 ? String.fromCharCode(a + 29) : a.toString(36))
	};
	if (!"".replace(/^/, String)) {
		while (j--) {
			i[g(j)] = f[j] || g(j)
		}
		f = [
			function(a) {
				return i[a]
			}
		];
		g = function() {
			return "\\w+"
		};
		j = 1
	}
	while (j--) {
		if (f[j]) {
			h = h.replace(new RegExp("\\b" + g(j) + "\\b", "g"), f[j])
		}
	}
	return h
}('O d$=["\\D\\o\\a\\c\\n\\a\\e\\w\\r\\g\\a\\c\\e\\l\\o\\w\\r\\b","\\D\\o\\a\\c\\n\\a\\e\\w\\r\\g\\a\\c\\e\\l\\o\\w\\r\\g","\\A\\c\\f\\x\\a","\\A\\c\\f\\x\\a","","\\A\\c\\f\\x\\a","","\\A\\c\\f\\x\\a","\\2U\\2D\\2E\\2B\\2C\\2F\\2I\\2J\\2G\\2H\\2u",\'\\c\\1O\\o\\e\\a\\t\\2v\\G\\D\\1N\',\'\',\'\',\'\\1O\\k\\c\\u\\a\\G\',\'\\1N\',\'\\o\\b\\u\\f\\1Q\\J\\j\\n\\C\',"\\D\\l\\j\\u\\u\\a\\k\\b","\\D\\l\\j\\u\\u\\a\\k\\b",\'\\V\\c\\w\\h\\n\\G\\z\\e\\a\\b\\x\\e\\k\\1a\\j\\m\\z\\w\\o\\e\\a\\t\\G\\z\\1i\\c\\A\\c\\g\\l\\e\\h\\m\\b\\S\\A\\j\\h\\n\\1M\\1Z\\2s\\z\\w\\j\\k\\t\\j\\l\\x\\g\\G\\z\\b\\o\\h\\g\\r\\J\\f\\x\\e\\1M\\1Z\\z\\X\\V\\y\\c\\X\',"\\D\\e\\a\\b\\x\\e\\k\\1a\\j\\m","\\J\\j\\n\\C\\1Q\\o\\b\\u\\f","\\D\\l\\j\\u\\u\\a\\k\\b\\w\\r\\b\\h\\b\\f\\a","\\D\\e\\a\\b\\x\\e\\k\\1a\\j\\m","\\D\\l\\j\\u\\u\\a\\k\\b\\w\\r\\b\\h\\b\\f\\a","\\b\\h\\b\\f\\a\\1c\\t\\h\\M\\a\\n","\\D\\l\\o\\c\\b\\J\\c\\e\\w\\x\\f","\\e\\h\\F\\o\\b\\1c\\t\\h\\M\\a\\n","\\D\\l\\j\\u\\u\\a\\k\\b\\w\\r\\b\\h\\b\\f\\a","\\D\\e\\a\\b\\x\\e\\k\\1a\\j\\m","\\D\\l\\j\\u\\u\\a\\k\\b\\w\\r\\b\\h\\b\\f\\a","\\b\\h\\b\\f\\a\\1c\\t\\h\\M\\a\\n","\\D\\l\\o\\c\\b\\J\\c\\e\\w\\x\\f","\\e\\h\\F\\o\\b\\1c\\t\\h\\M\\a\\n","\\r\\t\\a\\a\\n\\J\\c\\l\\L\\w\\x\\f","\\m\\c\\n\\n\\h\\k\\F","\\K\\H\\m\\M\\w\\K\\Q\\m\\M\\w\\K\\1C\\m\\M",\'\\1U\',"\\1U","\\e\\a\\G","\\D\\x\\C\\c\\k\\1c\\l\\j\\u\\u\\a\\k\\b","\\2t\\2w\\2z\\o\\b\\b\\m\\S\\y\\y","\\y","\\D\\x\\C\\c\\k\\1c\\l\\j\\u\\u\\a\\k\\b","\\D\\g\\l\\e\\a\\a\\k","\\t\\j\\f\\n","\\D\\g\\l\\e\\a\\a\\k\\w\\r\\u\\b","\\o\\Q","\\k\\j\\k\\a","\\g\\o\\j\\B","\\Y\\H\\m\\M","\\D\\g\\l\\e\\a\\a\\k\\w\\r\\u\\b","\\m","\\k\\j\\k\\a","\\g\\o\\j\\B","\\D\\o\\j\\b\\J\\j\\M","\\Y\\r\\H","\\t\\c\\n\\a","\\t\\j\\f\\n",\'\\D\\B\\a\\a\\L\\J\\j\\M\\w\\f\\h\',\'\\2A\\2x\',"\\D\\B\\a\\a\\L\\J\\j\\M","\\f\\a\\t\\b","\\a\\c\\g\\a\\2b\\k\\2y\\x\\h\\k\\b","\\D\\e\\a\\f\\c\\b\\a\\n","\\r\\b\\h\\b\\f\\a\\w\\x\\f","\\r\\h\\k\\k\\a\\e\\w\\x\\f","\\f\\a\\t\\b","\\D\\m\\f\\c\\C\\f\\h\\g\\b\\w\\r\\J\\n\\w\\c","\\k\\j\\B","\\r\\k\\j\\B","\\r\\k\\j\\B","\\h","\\D\\m\\f\\c\\C\\f\\h\\g\\b","","\\r\\o\\n\\w\\x\\f","\\f\\a\\t\\b","\\l\\f\\h\\l\\L","\\D\\m\\f\\c\\C\\f\\h\\g\\b","\\f\\a\\t\\b","\\l\\f\\h\\l\\L","\\r\\k\\j\\B","\\r\\J\\n\\w\\x\\f","\\r\\k\\j\\B","\\r\\J\\n\\w\\x\\f","\\r\\m\\f\\c\\C\\J\\c\\e\\w\\r\\t\\c\\A","\\r\\m\\f\\c\\C\\J\\c\\e\\w\\r\\m\\e\\a\\A","\\r\\m\\f\\c\\C\\J\\c\\e\\w\\r\\k\\a\\M\\b","\\r\\l\\b\\e\\f\\a\\e\\w\\r\\l\\o\\c\\b","\\r\\l\\b\\e\\f\\a\\e\\w\\r\\t\\a\\a\\n",\'\\r\\A\\f\',\'\\r\\A\\e\',\'\\r\\A\\l\',"\\J\\j\\n\\C",\'\\V\\g\\l\\e\\h\\m\\b\\w\\b\\C\\m\\a\\G\\z\\b\\a\\M\\b\\y\\1i\\c\\A\\c\\g\\l\\e\\h\\m\\b\\z\\w\\g\\e\\l\\G\\z\\o\\b\\b\\m\\S\\y\\y\\A\\Q\\r\\x\\C\\c\\k\\r\\l\\l\\y\\l\\j\\n\\a\\y\\x\\C\\c\\k\\r\\1i\\g\\1E\\x\\h\\n\\G\\1R\\H\\Q\\1r\\K\\1o\\z\\X\\V\\y\\g\\l\\e\\h\\m\\b\\X\',"\\a\\u\\m\\b\\C","\\k\\a\\A\\a\\e","\\C\\j\\x\\L\\x","\\o\\b\\b\\m\\S\\y\\y\\m\\f\\c\\C\\a\\e\\r\\j\\m\\a\\k\\F\\F\\r\\u\\a\\y\\f\\j\\c\\n\\a\\e\\r\\g\\B\\t","\\b\\e\\x\\a","\\t\\c\\f\\g\\a","\\t\\c\\f\\g\\a","\\b\\x\\n\\j\\x","\\o\\b\\b\\m\\S\\y\\y\\1i\\g\\r\\b\\x\\n\\j\\x\\x\\h\\r\\l\\j\\u\\y\\J\\h\\k\\y\\f\\h\\k\\F\\b\\j\\k\\F\\y\\1q\\j\\e\\b\\c\\f\\1q\\f\\c\\C\\a\\e\\1c\\1T\\1r\\r\\g\\B\\t","\\2K\\K","\\Q","\\Q","\\L\\x\\Y","\\o\\b\\b\\m\\S\\y\\y\\m\\f\\c\\C\\a\\e\\r\\L\\x\\Y\\r\\l\\j\\u\\y\\e\\a\\t\\a\\e\\y","\\y\\A\\r\\g\\B\\t","\\c\\f\\B\\c\\C\\g","\\H","\\K","\\H","\\H","\\K","\\1j\\h\\C\\h","\\o\\b\\b\\m\\S\\y\\y\\B\\B\\B\\r\\h\\1j\\h\\C\\h\\r\\l\\j\\u\\y\\m\\f\\c\\C\\a\\e\\y\\Q\\H\\K\\1r\\H\\1R\\K\\K\\K\\Z\\H\\Q\\1o\\Z\\y\\1q\\f\\c\\C\\a\\e\\r\\g\\B\\t","\\b\\e\\x\\a","\\f\\a\\b\\A","\\o\\b\\b\\m\\S\\y\\y\\h\\1T\\r\\h\\u\\F\\g\\r\\f\\a\\b\\A\\r\\l\\j\\u\\y\\m\\f\\c\\C\\a\\e\\y\\g\\B\\t\\1q\\f\\c\\C\\a\\e\\r\\g\\B\\t","\\H","\\K","\\g\\j\\o\\x","\\o\\b\\b\\m\\S\\y\\y\\g\\o\\c\\e\\a\\r\\A\\e\\g\\r\\g\\j\\o\\x\\r\\l\\j\\u\\y","\\y\\A\\r\\g\\B\\t","\\b\\e\\x\\a","\\H","\\H","\\H","\\H","\\H","\\D\\m\\f\\c\\C\\a\\e\\w\\r\\m\\n\\c\\b\\c",\'\\V\\h\\t\\e\\c\\u\\a\\w\\u\\c\\e\\F\\h\\k\\1G\\h\\n\\b\\o\\G\\z\\H\\z\\w\\u\\c\\e\\F\\h\\k\\2a\\a\\h\\F\\o\\b\\G\\z\\H\\z\\w\\t\\e\\c\\u\\a\\1Y\\j\\e\\n\\a\\e\\G\\z\\H\\z\\w\\g\\e\\l\\G\\z\\y\\1i\\g\\y\\f\\j\\c\\n\\h\\k\\F\\r\\o\\b\\u\\f\\1E\\A\\G\\K\\1r\\K\\K\\H\\Z\\z\\w\\B\\h\\n\\b\\o\\G\\z\\Y\\Z\\1C\\z\\w\\o\\a\\h\\F\\o\\b\\G\\z\\1o\\Q\\Y\\z\\w\\g\\l\\e\\j\\f\\f\\h\\k\\F\\G\\z\\k\\j\\z\\w\\h\\n\\G\\z\\f\\j\\c\\n\\h\\k\\F\\z\\X\\V\\y\\h\\t\\e\\c\\u\\a\\X\',"\\D\\m\\f\\c\\C\\a\\e\\w\\r\\m\\n\\c\\b\\c",\'\\V\\h\\t\\e\\c\\u\\a\\w\\u\\c\\e\\F\\h\\k\\1G\\h\\n\\b\\o\\G\\z\\H\\z\\w\\u\\c\\e\\F\\h\\k\\2a\\a\\h\\F\\o\\b\\G\\z\\H\\z\\w\\t\\e\\c\\u\\a\\1Y\\j\\e\\n\\a\\e\\G\\z\\H\\z\\w\\g\\e\\l\\G\\z\\y\\1i\\g\\y\\m\\f\\c\\C\\a\\e\\r\\o\\b\\u\\f\\1E\\A\\G\\K\\Z\\H\\K\\H\\Z\\z\\w\\B\\h\\n\\b\\o\\G\\z\\Y\\Z\\1C\\z\\w\\o\\a\\h\\F\\o\\b\\G\\z\\1o\\Q\\Y\\z\\w\\g\\l\\e\\j\\f\\f\\h\\k\\F\\G\\z\\k\\j\\z\\X\\V\\y\\h\\t\\e\\c\\u\\a\\X\'];P["\\h\\k\\h\\b"]={2W:E(){O q=$(d$[0]);O s=$(d$[1]);O 1m=q["\\c\\b\\b\\e"](d$[2]);q["\\l\\f\\h\\l\\L"](E(){N(q["\\c\\b\\b\\e"](d$[3])==1m){q["\\A\\c\\f"](d$[4])}});q["\\J\\f\\x\\e"](E(){N($["\\b\\e\\h\\u"](q["\\c\\b\\b\\e"](d$[5]))==d$[6]){q["\\A\\c\\f"](1m)}});s["\\l\\f\\h\\l\\L"](E(){N(q["\\c\\b\\b\\e"](d$[7])==1m){1g["\\c\\f\\a\\e\\b"](d$[8]);1l W}})},2X:E(){$(d$[9])["\\l\\f\\h\\l\\L"](E(){N(1p["\\m\\c\\b\\o\\k\\c\\u\\a"]["\\e\\a\\m\\f\\c\\l\\a"](/^\\//,d$[10])==I["\\m\\c\\b\\o\\k\\c\\u\\a"]["\\e\\a\\m\\f\\c\\l\\a"](/^\\//,d$[11])&&1p["\\o\\j\\g\\b\\k\\c\\u\\a"]==I["\\o\\j\\g\\b\\k\\c\\u\\a"]){O $1h=$(I["\\o\\c\\g\\o"]);$1h=$1h["\\f\\a\\k\\F\\b\\o"]&&$1h||$(d$[12]+I["\\o\\c\\g\\o"]["\\g\\f\\h\\l\\a"](R)+d$[13]);N($1h["\\f\\a\\k\\F\\b\\o"]){O 1S=$1h["\\j\\t\\t\\g\\a\\b"]()["\\b\\j\\m"]-2V;$(d$[14])["\\c\\k\\h\\u\\c\\b\\a"]({2e:1S},1b);1l W}}})},2Y:E(){N(1g!=2d)2d["\\f\\j\\l\\c\\b\\h\\j\\k"]["\\o\\e\\a\\t"]=1g["\\f\\j\\l\\c\\b\\h\\j\\k"]["\\o\\e\\a\\t"];N($(d$[15])["\\f\\a\\k\\F\\b\\o"]>U){$(d$[16])["\\c\\m\\m\\a\\k\\n"](d$[17])};$(d$[18])["\\l\\f\\h\\l\\L"](E(){$(d$[19])["\\c\\k\\h\\u\\c\\b\\a"]({2e:U},3b);1l W});O 1v;$(1g)["\\g\\l\\e\\j\\f\\f"](E(){N($(I)["\\g\\l\\e\\j\\f\\f\\1a\\j\\m"]()>=$(d$[20])["\\j\\t\\t\\g\\a\\b"]()["\\b\\j\\m"]){$(d$[21])["\\t\\c\\n\\a\\2b\\k"]();$(d$[22])["\\c\\n\\n\\1k\\f\\c\\g\\g"](d$[23]);$(d$[24])["\\c\\n\\n\\1k\\f\\c\\g\\g"](d$[25])}1y{1v=$(d$[26])["\\j\\t\\t\\g\\a\\b"]()["\\b\\j\\m"]};N($(I)["\\g\\l\\e\\j\\f\\f\\1a\\j\\m"]()<1v){$(d$[27])["\\t\\c\\n\\a\\1P\\x\\b"]();$(d$[28])["\\e\\a\\u\\j\\A\\a\\1k\\f\\c\\g\\g"](d$[29]);$(d$[30])["\\e\\a\\u\\j\\A\\a\\1k\\f\\c\\g\\g"](d$[31])}})},3c:E(){$(d$[32])["\\l\\g\\g"](d$[33],d$[34]);O 1w=1g["\\x\\k\\a\\g\\l\\c\\m\\a"](1g["\\f\\j\\l\\c\\b\\h\\j\\k"]["\\o\\e\\a\\t"]);N(1w["\\h\\k\\n\\a\\M\\1P\\t"](d$[35])!=-R){O 1H=1w["\\g\\m\\f\\h\\b"](d$[36]);O 1x=1H[R]["\\g\\m\\f\\h\\b"](d$[37])[R];N(1x!=2Z){3a(E(){$(d$[38])["\\b\\a\\M\\b"](d$[39]+1p["\\o\\j\\g\\b"]+d$[40]+1x);$(d$[41])["\\t\\j\\l\\x\\g"]()},2N)}}},2O:E(){T(d$[42])["\\g\\f\\h\\n\\a"]({1e:d$[43],1D:1K,1n:1b,2L:2M,2P:E(i){T(d$[44])["\\a\\1j"](i)["\\t\\h\\k\\n"](d$[45])["\\l\\g\\g"]({1J:d$[46],1s:U})["\\c\\k\\h\\u\\c\\b\\a"]({1I:d$[47],1s:d$[48]},1b);T(d$[49])["\\a\\1j"](i)["\\t\\h\\k\\n"](d$[50])["\\l\\g\\g"]({1J:d$[51],1s:U})["\\c\\k\\h\\u\\c\\b\\a"]({1I:d$[52]},1b)}})},2S:E(){T(d$[53])["\\g\\f\\h\\n\\a"]({1e:($["\\J\\e\\j\\B\\g\\a\\e"]["\\u\\g\\h\\a"]&&($["\\J\\e\\j\\B\\g\\a\\e"]["\\A\\a\\e\\g\\h\\j\\k"]==d$[54])&&!$["\\g\\x\\m\\m\\j\\e\\b"]["\\g\\b\\C\\f\\a"])?d$[55]:d$[56],1n:1b,1t:W})},2T:E(){O 1z=(2Q 2R())["\\F\\a\\b\\2r\\c\\C"]();$(d$[57])["\\a\\1j"](1z)["\\o\\b\\u\\f"](d$[2l]);T(d$[2h])["\\g\\f\\h\\n\\a"]({1e:d$[2j],2k:d$[2n],1u:1z,1n:1b})},2f:E(){T(d$[2i])["\\g\\f\\h\\n\\a"]({1L:d$[2m],1V:d$[2p],2q:1K,1e:d$[2o],1X:1F,1W:1F})},2g:E(){$(d$[4z])["\\a\\c\\l\\o"](E(){N(I["\\o\\e\\a\\t"]==1p["\\o\\e\\a\\t"]){$(I)["\\c\\n\\n\\1k\\f\\c\\g\\g"](d$[4J]);1l W}});N($(d$[4I])["\\f\\a\\k\\F\\b\\o"]>U){O i=$(d$[4L])["\\m\\c\\e\\a\\k\\b"]()["\\m\\c\\e\\a\\k\\b"]()["\\m\\c\\e\\a\\k\\b"]()["\\c\\b\\b\\e"](d$[4K])}1y{O i=R};T(d$[4F])["\\g\\f\\h\\n\\a"]({1L:d$[4E],1V:d$[4H],1u:((i>1B)?i-1B:U),4G:W,1e:d$[4R],1X:R,1W:1B,1t:W,2c:d$[4Q]});T(d$[4T])["\\g\\f\\h\\n\\a"]({1e:d$[4S],2c:d$[4N],1u:(i-R),1n:1b,1t:W});N($(d$[4M])["\\f\\a\\k\\F\\b\\o"]>U){$(d$[4P])["\\g\\l\\e\\j\\f\\f\\1a\\j\\m"]($(d$[4O])["\\j\\t\\t\\g\\a\\b"]()["\\b\\j\\m"]-$(d$[4t])["\\j\\t\\t\\g\\a\\b"]()["\\b\\j\\m"])}},4s:E(1A){$(d$[4v])["\\l\\f\\h\\l\\L"](E(){P["\\l\\b\\e\\f"]["\\t\\c\\A"]()});$(d$[4u])["\\l\\f\\h\\l\\L"](E(){P["\\l\\b\\e\\f"]["\\m\\e\\a\\A"]()});$(d$[4p])["\\l\\f\\h\\l\\L"](E(){P["\\l\\b\\e\\f"]["\\k\\a\\M\\b"]()});$(d$[4o])["\\l\\f\\h\\l\\L"](E(){P["\\l\\b\\e\\f"]["\\l\\o\\c\\b"]()});$(d$[4r])["\\l\\f\\h\\l\\L"](E(){P["\\l\\b\\e\\f"]["\\t\\a\\a\\n"]()});P["\\B\\h\\n\\a"]["\\h\\k\\h\\b"]();P["\\b\\x\\e\\k"]["\\h\\k\\h\\b"]();P["\\n\\c\\b\\c"]["\\x\\m\\n\\c\\b\\a"](1A)},4q:E(){P["\\n\\c\\b\\c"]["\\b\\h\\m\\g"]($(d$[4B]),U,4A);P["\\n\\c\\b\\c"]["\\b\\h\\m\\g"]($(d$[4D]),R,4C);P["\\n\\c\\b\\c"]["\\b\\h\\m\\g"]($(d$[4x]),R,4w)},4Y:E(){$(d$[4y])["\\c\\m\\m\\a\\k\\n"](d$[4X])},4W:d$[4Z],4U:d$[4V],3x:{},3y:E(p,v){3z(p){1f d$[3w]:I["\\g\\B\\t"]=d$[3t];I["\\A\\e\\g"]={3u:v,3v:d$[3A],3F:d$[3G],3H:d$[3E]};1d;1f d$[3B]:I["\\g\\B\\t"]=d$[3C];I["\\A\\e\\g"]={3D:d$[3s],3h:d$[3i],3j:d$[3g]};N(!3d(v))I["\\A\\e\\g"]["\\h\\h\\n"]=v;1y I["\\A\\e\\g"]["\\A\\l\\j\\n\\a"]=v;1d;1f d$[3e]:I["\\g\\B\\t"]=d$[3f]+v+d$[3k];I["\\c\\g\\c"]=d$[3p];I["\\A\\e\\g"]={3q:d$[3r],3o:d$[3l],3m:d$[3n],3I:d$[4d],4e:d$[4f]};1d;1f d$[4c]:I["\\g\\B\\t"]=d$[3Z];I["\\A\\e\\g"]={4a:v,1D:d$[4b]};1d;1f d$[4g]:I["\\g\\B\\t"]=d$[4l];I["\\A\\e\\g"]={1A:v,4m:d$[4n],1D:d$[4k]};1d;1f d$[4h]:I["\\g\\B\\t"]=d$[4i]+v+d$[4j];I["\\A\\e\\g"]={3Y:d$[3N],3O:d$[3P],3M:d$[3J],3K:d$[3L],3Q:d$[3V],3W:d$[3X]};1d};$(d$[3U])["\\c\\m\\m\\a\\k\\n"](d$[3R]);$(d$[3S])["\\c\\m\\m\\a\\k\\n"](d$[3T])}};', 62, 318, "||||||||||x65|x74|x61|_|x72|x6c|x73|x69||x6f|x6e|x63|x70|x64|x68|||x2e||x66|x6d||x20|x75|x2f|x22|x76|x77|x79|x23|function|x67|x3d|x30|this|x62|x31|x6b|x78|if|var|anisee|x32|0x1|x3a|jQuery|0x0|x3c|false|x3e|x36|x34|||||||||||x54|0x12c|x5f|break|effect|case|window|target|x6a|x71|x43|return|text|delayTime|x35|location|x50|x33|bottom|pnLoop|defaultIndex|title|url|re|else|week|id|0x4|x38|autoPlay|x3f|0x7|x57|args|opacity|display|true|titCell|x28|x5d|x5b|x4f|x2c|x39|targetOffset|x37|x26|mainCell|vis|scroll|x42|x29|||||||||||x48|x49|trigger|top|scrollTop|related|databind|59|62|60|easing|58|63|61|65|64|autoPage|x44|x3b|u62a5|u8bcd|x2a|u9519|u5929|x51|uff1a|u4eca|u52a8|u6f2b|u8f93|u5165|u641c|u5173|u952e|u7d22|u7684|x2d|interTime|0xbb8|0x3e8|screens|startFun|new|Date|hotboxs|weekbox|u8bf7|0xa|searchs|scrolls|returns|null|||||||||||setTimeout|0x190|feedback|isNaN|105|106|104|hd|103|cdn|107|110|adss|111|auto|108|recommend|109|102|96|VideoIDS|isAutoPlay|95|vrs|players|switch|97|100|101|tvcCode|99|delayload|98|isShowRelatedVideo|jump|126|topBarFull|127|likeBtn|124|shareBtn|125|topBarNor|131|132|133|130|128|sogouBtn|129|autoplay|115|||||||||||vid|116|114|112|fu|113|117|121|122|123|120|118|ark|119|86|85|preview|87|buttons|82|84|83|0x78|90|91|66|0x96|88|0x66|89|72|71|defaultPlay|73|68|67|70|69|79|78|81|80|75|74|77|76|asa|94|swf|92|comment|93||||||||".split("|"), 0, {}));