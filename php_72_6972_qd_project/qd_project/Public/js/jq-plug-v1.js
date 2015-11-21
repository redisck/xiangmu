(function($){

    $.fn.treemenucheckbox = function(){
        var _this = $(this);

        $.each(arguments, function(i,val){
            _this.find(val[0]).click(function(){
                $(this).find('span').attr("class",($(this).find('span').attr("class") == "on" ? "off" : "on"))
                _this.find(val[1]).eq(_this.find(val[0]).index(this)).toggle();
            });
        });
    };

    $.fn.FixedBox = function(){
        var _t = this;
        var _y = _t.offset().top;

        $(window).scroll(function(){
            if( document.documentElement.scrollTop >= _y){
                _t.width(_t.width()).css("position", "fixed");
            }else{
                _y = _t.offset().top;
                _t.css("width","auto").css("position", "relative");
            }
        });
    };

//====================================================================================================
// [插件名称] jQuery actabctl
//----------------------------------------------------------------------------------------------------
// [描    述] jQuery actabctl选项卡效果插件，它是基于jQuery类库，实现手动、自动窗口切换功能，
//			 支持自定义设置手动模式、自动模式、单击选择、滑动选择、
// [使用方法] $("#id").actabctl({menu: object, content: object, selectedCss: "on", evt: 0, auto: true, pause: 2000});
//----------------------------------------------------------------------------------------------------
// [更新日期] 2009-1-19
//====================================================================================================

    $.fn.actabctl = function(options){
        //默认值
        var defaults = {
            selectedCss: "on", //选项卡选中样式
            evt: 0,  //默认事件，0表示点击，1表示滑过
            auto: false, //是否自定滑动
            effect: false,
            pause: 4000 //两次滑动暂停时间
        };
        var options = $.extend({}, defaults, options);

        //检测必须条件
        if(!options.menu && !options.content) return;

        var $mobj = $(this).find(options.menu);
        var $cobj = $(this).find(options.content);

        function movement( obj, index ){

            var next = index >= 0 ? (index == $mobj.size() ? 0 : index) : $mobj.index(obj);

            // 隐藏全部选项卡内容并显示与单击相对应的那个选项卡内容
            if(options.effect){
                var _h = $cobj.eq(next).height();
                $cobj.hide().eq(next).css('top', '-'+_h+'px').show().animate({'top': '10px'}, 'fast').animate({'top': '0px'}, 'fast');
            }else{
                $cobj.hide().eq(next).show();
            }

            // 清除全部的菜单样式并选中当前菜单样式
            $mobj.removeClass(options.selectedCss).eq(next).addClass(options.selectedCss);

            if ( options.auto ) {
                timeout = setTimeout(function() {
                    movement(false, next + 1);
                }, options.pause);
            }
        }

        //初始化
        var timeout, delay;
        var evtName = options.evt === 0 ? "click" : options.evt === 1 ? "mouseover" : "click";

        if(options.auto) movement(false, 0);

        $mobj[evtName](function(){
            clearTimeout(timeout);
            var _this_ = this;
            delay = setTimeout(function(){movement(_this_);}, 60);
        }).mouseout(function(){clearTimeout(delay);});
    };

//====================================================================================================
// [插件名称] jQuery flashSlider
//----------------------------------------------------------------------------------------------------
// [描    述] jQuery flashSlider图片展示插件，它是基于jQuery类库，实现了不使用flash也同样可以在
//             页面上展示图片的效果，支持数字导航，纵向滑动和横向滑动，自动滚动和连续滑动
//             可设置滑动速度、是否自动、停顿间隔,自定义容器高度和宽度,支持Jquery的easing效果
//            （更多效果需要easing插件的支持，默认是swing）
// [使用方法] $("#slider").flashSlider();
//----------------------------------------------------------------------------------------------------
// [更新日期] 2010-3-27
//====================================================================================================

    $.fn.flashSlider = function(options) {
        //默认值
        var defaults = {
            controlsShow: true, 	//是否显示数字导航
            customnev	: false, 	//是否自定义导航
            vertical	: 'left', 	//淡入[fade],向上滑动[top],左右滑动[left]
            speed		: 800, 		//滑动速度
            auto		: true,		//是否自定滑动
            pause		: 3000, 	//两次滑动暂停时间
            easing		: "swing", 	//easing效果，默认swing，更多效果需要easing插件支持
            height		: 0, 		//容器高度，不设置自动获取图片高度
            width		: 0,		//容器宽度，不设置自动获取图片宽度
            resize		: false, 	//图片自动调整大小
            delay		: false, 	//图片延迟加载
            char		: '', 		//文字标题绑定
            index		: '' 		//小图索引绑定
        };
        var options = $.extend({}, defaults, options);
        var FS = this;

        //开启图片自动调整大小
        if(options.resize && !options.delay){
            $("img", FS).each(function(i, c){
                var $Ig = new Image();
                $Ig.src = c.src;
                $(c).attr('alt','正在加载中...');
                $Ig.onload = function(){
                    $(c).css({
                        'width' : (this.width < options.width ? this.width : options.width),
                        'height' : (this.height < options.height ? this.height : options.height),
                        'margin-left' : (this.width < options.width ? (options.width - this.width)/2 : 0),
                        'margin-right' : (this.width < options.width ? (options.width - this.width)/2 : 0),
                        'margin-top' : (this.height < options.height ? (options.height - this.height)/2 : 0),
                        'margin-bottom' : (this.height < options.height ? (options.height - this.height)/2 : 0)
                    });
                };
            });
        }

        /*//开启延迟加载图片
         if(options.delay && !options.resize){
         $("img" ,FS).each(function(){
         $(this).attr('fsrc', $(this).attr('src')).removeAttr('src');
         });
         window.onload = function(){
         $("img" ,FS).each(function(){
         $(this).attr('src', $(this).attr('fsrc')).removeAttr('fsrc');
         });
         };
         }*/

        //判断图片少于或等于一张跳出
        if($("img" ,FS).size()<=1) return;

        FS.each(function() {
            var obj = $(this);
            var curr = 1; //当前索引
            var $img = obj.find("img");
            var s = $img.length;
            var w = $img.eq(0).width() || obj.width();
            var h = $img.eq(0).height() || obj.height();
            var $flashelement = $("ul", obj);
            options.height == 0 ? obj.height(h) : obj.height(options.height);
            options.width == 0 ? obj.width(w) : obj.width(options.width);
            obj.css("overflow", "hidden");
            obj.css("position", "relative");
            $flashelement.css('width', s * w);

            if(options.vertical === 'left') $("li", obj).css('float', 'left');
            if(options.vertical === 'top') $img.css('display', 'block');

            if (options.controlsShow) {
                if (options.customnev) {
                    var navbtnhtml = '';
                    for (var i = 0; i < s; i++) {
                        navbtnhtml += '<span>' + (i + 1) + '</span>';
                    }
                    $("#flashnvanum").append(navbtnhtml);
                }else{
                    var navbtnhtml = '<div id="flashnvanum">';
                    for (var i = 0; i < s; i++) {
                        navbtnhtml += '<span>' + (i + 1) + '</span>';
                    }
                    navbtnhtml += '</div>';
                    obj.append(navbtnhtml);
                }
                $("#flashnvanum span").hover(function() {
                    var num = $(this).html();
                    flash(num, true);
                }, function() {
                    timeout = setTimeout(function() {
                        flash((curr / 1 + 1), false);
                    }, options.pause / 4);
                });
            };

            if(options.index !== ''){
                $("#sliderindex").find(options.index)
                    .each(function(i, e){
                        $(e).attr('indexbind', i);
                    })
                    .hover(function() {
                        var num = $(this).attr('indexbind');
                        flash(parseInt(num)+1, true);
                    }, function() {
                        timeout = setTimeout(function() {
                            flash((curr / 1 + 1), false);
                        }, options.pause / 4);
                    });
            }

            function setcurrnum(index) {
                if (options.controlsShow) $("#flashnvanum span").eq(index).addClass('on').siblings().removeClass('on');
                if(options.char !== '') $("#sliderchar").find(options.char).hide().eq(index).show();
                if(options.index !== '') $("#sliderindex").find(options.index).eq(index).addClass('on').siblings().removeClass('on');
            }

            function flash(index, clicked) {
                $flashelement.stop();
                var next = index == s ? 1 : index + 1;
                curr = index - 1;
                setcurrnum((index - 1));

                switch(options.vertical){
                    case 'top':
                        p = ((index - 1) * h * -1);
                        $flashelement.animate({ marginTop: p },options.speed, options.easing);
                        break;
                    case 'left':
                        p = ((index - 1) * w * -1);
                        $flashelement.animate({ marginLeft: p },options.speed, options.easing);
                        break;
                    case 'fade':
                        $flashelement.find('li').hide().eq(index-1).fadeIn('slow').show();
                        break;
                }
                if (clicked) clearTimeout(timeout);
                if (options.auto && !clicked) {
                    timeout = setTimeout(function() {
                        flash(next, false);
                    }, options.speed + options.pause);
                };
            }
            var timeout;
            //初始化
            setcurrnum(0);
            if (options.auto) {
                timeout = setTimeout(function() {
                    flash(2, false);
                }, options.pause);
            };
        });
    };

//====================================================================================================
// [插件名称] Accessible News Slider 滚动插件
//----------------------------------------------------------------------------------------------------
// [插件描述] 间断滚动

// 使用参考[实例]
//    $( "#example_1″ ).accessNews({
//                headline : "Candy Coated",
//                speed : "normal",
//                slideBy : 1
//            });
//
//其中：
//headline：是标题；
//speed ：是速度；
//slideBy ：滚动几个；
//----------------------------------------------------------------------------------------------------
// [更新日期] 2011-09-05
//====================================================================================================

    $.fn.accessNews = function( settings ) {
        settings = $.extend({
            speed : "normal",
            slideBy : 2
        }, settings);
        return this.each(function() {
            $.fn.accessNews.run( $( this ), settings );
        });
    };
    $.fn.accessNews.run = function( $this, settings ) {
        var ul = $( "ul:eq(0)", $this );
        var li = ul.children();
        if ( li.length <= settings.slideBy ) return;

        var $next = $( "[name='next']", $this );
        var $back = $( "[name='back']", $this );
        var liWidth = $( li[0] ).width() + parseInt($( li[0] ).css("margin-left")) + parseInt($( li[0] ).css("margin-right"));
        var animating = false;
        var ulwidth = li.length * liWidth;

        //初始化
        ul.css( "width", ulwidth );
        $next.attr("class","next");

        function scrollflash(s){
            if ( !animating ) {
                animating = true;
                offset = s ? parseInt( ul.css( "left" ) ) - ( liWidth * settings.slideBy ) : parseInt( ul.css( "left" ) ) + ( liWidth * settings.slideBy );
                if ( s && offset + ulwidth > 0 || !s && offset + ulwidth <= ulwidth){
                    ul.animate({
                        left: offset
                    }, settings.speed, function() {
                        if ( s && parseInt( ul.css( "left" ) ) + ulwidth <= liWidth * settings.slideBy ){
                            $next.attr("class","next_"); $back.attr("class","back");
                        }
                        if ( !s && parseInt( ul.css( "left" ) ) == 0 ){
                            $next.attr("class","next"); $back.attr("class","back_");
                        }
                        animating = false;
                    });
                }else{
                    animating = false;
                }
            }
        }

        $next.click(function() { scrollflash(true); });
        $back.click(function() { scrollflash(false); });
    };

//====================================================================================================
// [插件名称] jQuery lazyload
//----------------------------------------------------------------------------------------------------
// [描    述] jQuery lazyload图片延迟加载插件，它是基于jQuery类库，实现了图片根据浏览范围动态加载。

// 使用参考
//$("img").lazyload()
//----------------------------------------------------------------------------------------------------
// [更新日期] 2010-4-12
//====================================================================================================
    $.fn.lazyload = function(options) {
        var settings = {
            threshold    : 0,
            failurelimit : 0,
            event        : "scroll",
            effect       : "show",
            container    : window
        };

        if(options) {
            $.extend(settings, options);
        }

        var elements = this;
        if ("scroll" == settings.event) {
            $(settings.container).bind("scroll", function(event) {

                var counter = 0;
                elements.each(function() {
                    if ($.abovethetop(this, settings) ||
                        $.leftofbegin(this, settings)) {
                        /* Nothing. */
                    } else if (!$.belowthefold(this, settings) &&
                        !$.rightoffold(this, settings)) {
                        $(this).trigger("appear");
                    } else {
                        if (counter++ > settings.failurelimit) {
                            return false;
                        }
                    }
                });

                var temp = $.grep(elements, function(element) {
                    return !element.loaded;
                });
                elements = $(temp);
            });
        }

        this.each(function() {
            var self = this;

            if (undefined == $(self).attr("original")) {
                $(self).attr("original", $(self).attr("src"));
            }

            if ("scroll" != settings.event ||
                undefined == $(self).attr("src") ||
                settings.placeholder == $(self).attr("src") ||
                ($.abovethetop(self, settings) ||
                    $.leftofbegin(self, settings) ||
                    $.belowthefold(self, settings) ||
                    $.rightoffold(self, settings) )) {

                if (settings.placeholder) {
                    $(self).attr("src", settings.placeholder);
                } else {
                    $(self).removeAttr("src");
                }
                self.loaded = false;
            } else {
                self.loaded = true;
            }

            $(self).one("appear", function() {
                if (!this.loaded) {
                    $("<img />")
                        .bind("load", function() {
                            $(self)
                                .hide()
                                .attr("src", $(self).attr("original"))
                                [settings.effect](settings.effectspeed);
                            self.loaded = true;
                        })
                        .attr("src", $(self).attr("original"));
                };
            });

            if ("scroll" != settings.event) {
                $(self).bind(settings.event, function(event) {
                    if (!self.loaded) {
                        $(self).trigger("appear");
                    }
                });
            }
        });

        $(settings.container).trigger(settings.event);

        return this;

    };

    $.belowthefold = function(element, settings) {
        if (settings.container === undefined || settings.container === window) {
            var fold = $(window).height() + $(window).scrollTop();
        } else {
            var fold = $(settings.container).offset().top + $(settings.container).height();
        }
        return fold <= $(element).offset().top - settings.threshold;
    };

    $.rightoffold = function(element, settings) {
        if (settings.container === undefined || settings.container === window) {
            var fold = $(window).width() + $(window).scrollLeft();
        } else {
            var fold = $(settings.container).offset().left + $(settings.container).width();
        }
        return fold <= $(element).offset().left - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        if (settings.container === undefined || settings.container === window) {
            var fold = $(window).scrollTop();
        } else {
            var fold = $(settings.container).offset().top;
        }
        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };

    $.leftofbegin = function(element, settings) {
        if (settings.container === undefined || settings.container === window) {
            var fold = $(window).scrollLeft();
        } else {
            var fold = $(settings.container).offset().left;
        }
        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.extend($.expr[':'], {
        "below-the-fold" : "$.belowthefold(a, {threshold : 0, container: window})",
        "above-the-fold" : "!$.belowthefold(a, {threshold : 0, container: window})",
        "right-of-fold"  : "$.rightoffold(a, {threshold : 0, container: window})",
        "left-of-fold"   : "!$.rightoffold(a, {threshold : 0, container: window})"
    });

    /*
     * 新扩展的posAlign插件
     * 作用：CSS样式的position的垂直定位
     * 调用：$(object).posAlign('baseline[基线] or middle[居中] or top[顶端] or bottom[底部]',{x:横向偏移点, y:纵向偏移点})
     * 类型：返回jQuery对象类型
     */
    $.fn.posAlign = function(v, options){
        var v = v || 'baseline';
        var opt = $.extend({}, {t:this, x:0, y:0}, options);
        var xx = 0, yy = 0;

        switch(v){
            //基线
            case 'baseline':
                var f = $(opt.t).offset();
                xx = f.left;
                yy = f.top;
                break;

            //居中
            case 'middle':
                xx = (document.documentElement.clientWidth/2) - ($(this).get(0).clientWidth/2);
                yy = (document.documentElement.scrollTop + document.documentElement.clientHeight/2) - ($(this).get(0).clientHeight/2);
                break;

            //顶端
            case 'top':
                xx = 0;
                yy = document.documentElement.scrollTop;
                break;

            //底部
            case 'bottom':
                xx = 0;
                yy = document.documentElement.scrollTop + document.documentElement.clientHeight - $(this).get(0).clientHeight;
                break;
            default :
                alert('posAlign: \u53C2\u6570\u9519\u8BEF!');
                return;
        }

        return $(this).css({'top': yy + opt.y + "px", 'left': xx + opt.x + 'px'});
    };


    $.fn.hoverForIE6=function(option){
        var s=$.extend({
                current:"hover",delay:10
            }
            ,option||{});
        $.each(this,function(){
            var timer1=null,timer2=null,flag=false;
            $(this).bind("mouseover",function(){
                if (flag){
                    clearTimeout(timer2);
                }
                else{
                    var _this=$(this);
                    timer1=setTimeout(function(){
                            _this.addClass(s.current);
                            flag=true;
                        }
                        ,s.delay);
                }
            }).bind("mouseout",function(){
                    if (flag){
                        var _this=$(this);
                        timer2=setTimeout(function(){
                                _this.removeClass(s.current);
                                flag=false;
                            }
                            ,s.delay);
                    }
                    else{
                        clearTimeout(timer1);
                    }
                })
        })
    };
	
	
	(function($){
        $.fn.extend({
            Scroll:function(opt,callback){
                //参数初始化
                if(!opt) var opt={};
                var _this=this.eq(0).find("ul:first");
                var lineH=_this.find("li:first").height(), //获取行高
                    line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), //每次滚动的行数，默认为一屏，即父容器高度
                    speed=opt.speed?parseInt(opt.speed,10):500, //卷动速度，数值越大，速度越慢（毫秒）
                    timer=opt.timer?parseInt(opt.timer,10):3000; //滚动的时间间隔（毫秒）
                if(line==0) line=1;
                var upHeight=0-line*lineH;
                //滚动函数
                scrollUp=function(){
                    _this.animate({
                        marginTop:upHeight
                    },speed,function(){
                        for(i=1;i<=line;i++){
                            _this.find("li:first").appendTo(_this);
                        }
                        _this.css({marginTop:0});
                    });
                }
                //鼠标事件绑定
                _this.hover(function(){
                    clearInterval(timerID);
                },function(){
                    timerID=setInterval("scrollUp()",timer);
                });
                timerID=setInterval("scrollUp()",timer);
            }
        })
    })(jQuery);



    (function(a){
        a.fn.vTicker=function(b){
            var c={
                speed:700,pause:4000,showItems:3,animation:"",mousePause:true,isPaused:false,direction:"up",height:0
            };
            var b=a.extend(c,b);
            moveUp=function(g,d,e){
                if(e.isPaused){
                    return
                }
                var f=g.children("ul");
                var h=f.children("li:first").clone(true);
                if(e.height>0){
                    d=f.children("li:first").height()
                }
                f.animate({
                        top:"-="+d+"px"
                    }
                    ,e.speed,function(){
                        a(this).children("li:first").remove();
                        a(this).css("top","0px")
                    });
                if(e.animation=="fade"){
                    f.children("li:first").fadeOut(e.speed);
                    if(e.height==0){
                        f.children("li:eq("+e.showItems+")").hide().fadeIn(e.speed)
                    }
                }
                h.appendTo(f)
            };
            moveDown=function(g,d,e){
                if(e.isPaused){
                    return
                }
                var f=g.children("ul");
                var h=f.children("li:last").clone(true);
                if(e.height>0){
                    d=f.children("li:first").height()
                }
                f.css("top","-"+d+"px").prepend(h);
                f.animate({
                        top:0
                    }
                    ,e.speed,function(){
                        a(this).children("li:last").remove()
                    });
                if(e.animation=="fade"){
                    if(e.height==0){
                        f.children("li:eq("+e.showItems+")").fadeOut(e.speed)
                    }
                    f.children("li:first").hide().fadeIn(e.speed)
                }
            };
            return this.each(function(){
                var f=a(this);
                var e=0;
                f.css({
                    overflow:"hidden",position:"relative"
                }).children("ul").css({
                        position:"absolute"//,margin:0,padding:0
                    }).children("li").css({
                        //margin:0,padding:0
                    });
                if(b.height==0){
                    f.children("ul").children("li").each(function(){
                        if(a(this).height()>e){
                            e=a(this).height()
                        }
                    });
                    f.children("ul").children("li").each(function(){
                        a(this).height(e)
                    });
                    f.height(e*b.showItems)
                }
                else{
                    f.height(b.height)
                }
                var d=setInterval(function(){
                        if(b.direction=="up"){
                            moveUp(f,e,b)
                        }
                        else{
                            moveDown(f,e,b)
                        }
                    }
                    ,b.pause);
                if(b.mousePause){
                    f.bind("mouseenter",function(){
                        b.isPaused=true
                    }).bind("mouseleave",function(){
                            b.isPaused=false
                        })
                }
            })
        }
    })(jQuery);
	
	
	
	
	
	
//共用滚动插件
(function($) {
    $.fn.scrollShow = function(options){
        //默认配置
        var defaults = {                
            vertical:       false  //垂直滚动
            ,speed:         800//滚动速度，越大越慢
            ,auto:            false//自动
            ,pausetm:        5000//自动的时候停止时间
            ,preId:         false //前滚的选择符 如 #prebtn
            ,nextId:        false //后滚的选择符 如 #nextbtn
            ,items:         false //滚动的元素 如 #scroll li
            ,itemparent:     false //滚动元素的外层 #scroll ul
            ,itemSpace:     200//宽度或者高度
            ,overstop:      true //鼠标放上去的时候停止滚动
            ,callback:      function(){} //回调函数，滚动停止后
            
        };        
        var options = $.extend(defaults, options);
        if(!options.items || !options.itemparent )return;
        var callback = options.callback;
        var timeout = null;      
        var moveObj1 = null;
        var moveObj2 = null;
        var scrolllock = false;//防止多次点击，滚动的时候加锁
        if(options.vertical){
              moveObj1 = {marginTop: -options.itemSpace};
              moveObj2 = {marginTop: 0};        
        }else{
              moveObj1 = {marginLeft: -options.itemSpace};
              moveObj2 = {marginLeft: 0};
          
        }
        //往前滚
        function ___pre(){   
            //加锁
            if(scrolllock)return;
            scrolllock = true;
            
            //将最后一个孩子节点移动到最前面了，防止右移动的时候出现空白
            callback($(options.items + ":last-child")); 
            $(options.items + ':last-child').prependTo(options.itemparent); 
            // 将移动过来的节点，推到可视范围外        
            $(options.items + ":first-child").css(moveObj1).animate(moveObj2,options.speed,function(){scrolllock = false;
    
            });   
            
        };
        //往后滚
        function ___next(){      
            //加锁
            if(scrolllock)return;
            scrolllock = true;
            callback($(options.items + ":nth-child(2)"));          
            //第一步 将第一个元素慢慢移动到界外   第二步 将第一个元素加到最后
            $(options.items + ":first-child").animate(moveObj1,options.speed,function(){
                setTimeout(function(){$(options.items + ":first-child").css(moveObj1).appendTo(options.itemparent).css(moveObj2);               scrolllock = false;},200);
 
                   
            }); 
        };
        
        //设置前后按钮的点击事件
        if(options.preId){
            $(options.preId).click(function(){
                if(timeout)clearInterval(timeout);
                ___pre();
                timeout = setInterval(___next,options.pausetm);
                
            });
        }
        if(options.nextId){
            $(options.nextId).click(function(){ 
               if(timeout)clearInterval(timeout);
                ___next();
                timeout = setInterval(___next,options.pausetm);
            });
        }
        
        //如果是自动运行  
        if(options.auto){;
            timeout = setInterval(___next,options.pausetm);
            //鼠标放上去是否停止滚动
            if(options.overstop){
                //设置鼠标在上面的时候去掉计时器
                $(options.itemparent).hover(function(){
                     if(timeout)clearInterval(timeout);
                },function(){
                     if(timeout)clearInterval(timeout);
                     timeout = setInterval(___next,options.pausetm);
                });
            }
        };    
    };
})(jQuery);
function $id(id) {
    return document.getElementById(id);
}


//特卖活动 滚动
$(function(){
    var sliderPicWidth = $('#focusBox > #focusPics > .child').size() * 204;
    $('#focusBox > #focusPics').css('width',sliderPicWidth)
    var paramObjs = {
         itemSpace:204//每次移动的高度或的宽度
        ,preId:'#btnPrev' //前一个按钮选择符 可以不指定
        ,nextId:'#btnNext'//后一个按钮选择符 可以不指定
        ,items:"#focusBox > #focusPics > .child"//滚动元素的选择符
        ,itemparent:"#focusBox > #focusPics" //滚动元素父节点的选择符
        ,vertical:false  //垂直滚动：true，左右滚动：false；默认false
        ,speed:600      //切换时候的持续时间，数字越大表示越慢
        ,pausetm:5000   //滚动后的停留时间 默认 5s
        ,auto:true      //是否自动滚动   默认false
        ,overstop:false  //鼠标放上去是否停留 默认 true
    };
    $(document).scrollShow(paramObjs);
})



//特卖活动 滚动
/*$(function(){
    var sliderPicWidth = $('#focusBox2 > #focusPics2 > .child').size() * 1000;
    $('#focusBox2 > #focusPics2').css('width',sliderPicWidth)
    var paramObjs = {
         itemSpace:1000//每次移动的高度或的宽度
        ,preId:'#carousel_btnPrev' //前一个按钮选择符 可以不指定
        ,nextId:'#carousel_btnNext'//后一个按钮选择符 可以不指定
        ,items:"#focusBox2 > #focusPics2 > .child"//滚动元素的选择符
        ,itemparent:"#focusBox2 > #focusPics2" //滚动元素父节点的选择符
        ,vertical:false  //垂直滚动：true，左右滚动：false；默认false
        ,speed:600      //切换时候的持续时间，数字越大表示越慢
        ,pausetm:5000   //滚动后的停留时间 默认 5s
        ,auto:true      //是否自动滚动   默认false
        ,overstop:false  //鼠标放上去是否停留 默认 true
    };
    $(document).scrollShow(paramObjs);
})*/


})(jQuery);

/*上下百叶窗*/
function changelist(ulid){
    var con=jQuery(""+ulid+" li");
    for(var i=0;i<con.length;i++){
        con[i].onmouseover = function (){
            for(var i=0;i<con.length;i++){
                if(this!=con[i]){
                    var divs=con[i].getElementsByTagName("div");
                    divs[0].style.display="block";
                    divs[1].style.display="none";
                }
                else{
                    var divs=con[i].getElementsByTagName("div");
                    divs[0].style.display="none";
                    divs[1].style.display="block";
                }
            }
        }
    }

}
