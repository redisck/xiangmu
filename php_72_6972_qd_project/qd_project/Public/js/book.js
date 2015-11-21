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
 
 //图书人气推荐 滚动
        $(function () {
            var sliderBoxWidth = $('.carousel_list > .carousel_li').size() * 699;
            $('.carousel_list').css('width', sliderBoxWidth)
            var paramObj = {
                itemSpace: 699//每次移动的高度或的宽度
        , preId: '#popular_btnPrev' //前一个按钮选择符 可以不指定
        , nextId: '#popular_btnNext'//后一个按钮选择符 可以不指定
        , items: ".carousel_list > .carousel_li"//滚动元素的选择符
        , itemparent: ".carousel_list" //滚动元素父节点的选择符
        , vertical: false  //垂直滚动：true，左右滚动：false；默认false
        , speed: 600      //切换时候的持续时间，数字越大表示越慢
        , pausetm: 8000   //滚动后的停留时间 默认 5s
        , auto: true      //是否自动滚动   默认false
        , overstop: true  //鼠标放上去是否停留 默认 true
            };
            $("#popular_btnPrev,#popular_btnNext").bind('click', function () {

            })

            $(document).scrollShow(paramObj);
        });
		
		

		
		
