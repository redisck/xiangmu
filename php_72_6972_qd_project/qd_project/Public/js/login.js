$(function(){
			var pageW=$(document).width();
			var pageH=$(document).height();
			var width=$(".login_content").width();
			var height=$(".login_content").height();
			$("#login_button").click(function(){
				$("#zhezhao").css("width","100%").css("height","2200px").css("background","#aaaaaa").css("opacity","0.5").fadeIn(1000).css("z-index","2014").next(".login_content").css("left",(pageW-width)/2).css("top","200px").fadeIn(1000).css("z-index","2015");
			});
			$("#username").focus(function(){
				$(".name_hidden").hide().prev().children("#username").css('color','#000').css('font-size','15px').css("font-weight","bold");
			});
			$(".name_hidden").click(function(){
				$(this).hide().prev().children("#username").focus().css("color","#000").css("font-size","15px").css("font-weight","bold");
			});
			$("#username").blur(function(){
				if($(this).val()==""){
					$(".name_hidden").show();
				}
			});
			$("#password").focus(function(){
				$(".p_hidden").hide().prev().children("#password").css('color','#000').css('font-size','15px').css('font-weight','bold');
			});
			$(".p_hidden").click(function(){
				$(this).hide().prev().children("#password").focus().css('color','#000').css("font-size","15px").css("font-weight","bold");
			});
			$("#password").blur(function(){
				if($(this).val()==""){
					$(".p_hidden").show();
				}
			});
			$(".pop_content_opt").click(function(){
				$("#zhezhao").css("display","none").next(".login_content").css("display","none");
			
			})
			
		})