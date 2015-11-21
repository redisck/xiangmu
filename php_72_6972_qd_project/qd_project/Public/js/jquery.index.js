
$(document).ready(function()
{
    //setCurrentNav("图书");
    
    attachMoveEvent();
    
   // initFlash();
 //  swapImage();
});

function attachMoveEvent() {

    // rec
    var recprefix = "rec";

    var divRecParent = $("div.grid_center_510.hot_recommend>div.con.jcarousel_container");    
    var prevRec = divRecParent.find("div.jcarousel_prev_level.jcarousel_prev");
    var nextRec = divRecParent.find("div.jcarousel_prev_level.jcarousel_next");   

    
    prevRec.click(function()
    {
        //movePrev(recprefix);
        swapPreRec("rec");
    });
    
    nextRec.click(function()
    {
        //moveNext(recprefix);
        swapNextRec("rec");
    });
     swapNextRec("rec");
  
    
    // newbook
    var newbookprefix = "newbook";
    
    var divNewBookParent = $("div.grid_center_510.new_books>div.con.jcarousel_container");    
    var prevNewBook = divNewBookParent.find("div.jcarousel_prev_level.jcarousel_prev");
    var nextNewBook = divNewBookParent.find("div.jcarousel_prev_level.jcarousel_next");    
    
    prevNewBook.click(function()
    {
         swapPreRec("newbook");
    });
    
    nextNewBook.click(function()
    {
      swapNextRec("newbook");
    });
     swapNextRec("newbook");
     
     $(".grid_center_510.hot_recommend .item_list").mouseover(function(){ stopPlay("rec");}).mouseout(function(){ setAutoPlay("rec");});
     setAutoPlay("rec");
     $(".grid_center_510.new_books .item_list").mouseover(function(){stopPlay("newbook");}).mouseout(function(){setAutoPlay("newbook");});
     setAutoPlay("newbook");
}

var autohandler= new Object();
function setAutoPlay(prefix)
{
    autohandler[prefix]=setInterval(function(){ swapNextRec(prefix);},5000);
}
function stopPlay(prefix)
{
   clearInterval(autohandler[prefix]);
}

function swapImage()
{
     $('.slide').smallslider({
            onImageStop:false,
            switchEffect:'ease',
            switchEase: 'easeOutSine',
            switchPath: 'up',
            switchMode: 'hover',
            textSwitch:2,
            textPosition: 'top',
            textAlign:'center',
            autoStart:true,
            onImageStop:true ,
            showText:false,
            buttonOffsetY:-2,
            buttonOffsetX:12,
            buttonSpace:0
            });

}

    
    
function swapNextRec(prefix)
{
   var pagesize=3;
    var list=$("div.item_list>div.item_box[name='"+prefix+"']");
    var cur=$("#hdnPos_"+ prefix ).val();   
    cur =parseInt(cur );
    if( (cur + pagesize)> list.length)
    {
        cur =0;
    }
    $(list.filter(":visible")).hide(); 
    $(list.slice(cur,cur+pagesize)).show(); 
    $("#hdnPos_" +prefix).val(cur +pagesize );

}

function swapPreRec(prefix)
{
 var pagesize=3;
    var list=$("div.item_list>div.item_box[name='"+prefix+"']");
    var cur=$("#hdnPos_" +prefix).val();
    cur =parseInt(cur );
	cur=cur - 2 * pagesize ;
    if( (cur  )< 0)
    {
        var len=list.length;
        var mod=len % pagesize ;
        if( mod  ==0)
        {
            cur =len -pagesize ;
        }
        else 
        {
            cur =len -mod ;
        }
    }
    $(list.filter(":visible")).hide(); 
    $(list.slice(cur ,cur+ pagesize )).show();
    $("#hdnPos_" +prefix ).val(cur +pagesize);
}

 function AuthorShow(authorWorks,author){
   
     for (i = 1; j = document.getElementById("author" + i); i++) {
         j.className = "";
     }
     document.getElementById(author).className = "on";
     
     for (i = 1; j = document.getElementById("AuthorWorks_" + i); i++) {
         j.style.display = "none";
     }
     document.getElementById(authorWorks).style.display = "block";
     
    switch(author){
    
      case "author1":
         $("#author1 a:eq(0)").css("color","#c30d23");
         $("#author2 a:eq(0)").css("color","#404040");
         $("#author3 a:eq(0)").css("color","#404040");
         break;
      case "author2":
         $("#author1 a:eq(0)").css("color","#404040");
         $("#author2 a:eq(0)").css("color","#c30d23");
         $("#author3 a:eq(0)").css("color","#404040");
         break;
      case "author3":
         $("#author1 a:eq(0)").css("color","#404040");
         $("#author2 a:eq(0)").css("color","#404040");
         $("#author3 a:eq(0)").css("color","#c30d23");
         break;
    }
 }


 function ShowBoutique()
        {
 
            document.getElementById("ABoutique").className="title on";
           document.getElementById("ASale").className="title";
           document.getElementById("Boutique").style.display="block";
           document.getElementById("Sale").style.display="none";
        }
function ShowSale()
        {
     
            document.getElementById("ABoutique").className="title";
           document.getElementById("ASale").className="title on";
           document.getElementById("Sale").style.display="block";
           document.getElementById("Boutique").style.display="none";
        }

 function menuTag(menu) {
       
         if (menu == "weekMenu") {
             document.getElementById(menu).className="on"
             document.getElementById("monthMenu").className = "";
             document.getElementById("tagsWeek").style.display = "block";
             document.getElementById("tagsMonth").style.display = "none";
             document.getElementById("weekList").style.display = "block";
             document.getElementById("monthList").style.display = "none";
             
              for (i = 0; j = document.getElementById("UI" + i); i++) {
                 j.style.display = "none";
             }
              document.getElementById("UI0").style.display = "block";
             
         } else if (menu == "monthMenu") {
             document.getElementById(menu).className="on";
             document.getElementById("weekMenu").className = "";
             document.getElementById("tagsWeek").style.display = "none";
             document.getElementById("tagsMonth").style.display = "block";
             document.getElementById("weekList").style.display = "none";
             document.getElementById("monthList").style.display = "block";
             
              for (i = 0; j = document.getElementById("UI" + i); i++) {
                 j.style.display = "none";
             }
              document.getElementById("UI6").style.display = "block";
         }
     
     }
function selectTag(showContent, selfObj,tages) {
         // 操作标签
       
         var tag;
         if (tages == "1") {
             document.getElementById("weekList").style.display = "block";
             document.getElementById("monthList").style.display = "none";
             tag = document.getElementById("tagsWeek").getElementsByTagName("li");
             $("#tagsWeek li a").css("color","#404040");
         } else if (tages == "2") {

              document.getElementById("weekList").style.display = "none";
              document.getElementById("monthList").style.display = "block";
              tag = document.getElementById("tagsMonth").getElementsByTagName("li");
              $("#tagsMonth li a").css("color","#404040");
         }
         var taglength = tag.length;
         for (i =0; i < taglength; i++) {
             tag[i].className = "";
         }
         selfObj.parentNode.className = "on";
        
        
         // 操作内容  
         for (i = 0; j = document.getElementById("UI" + i); i++) {
             j.style.display = "none";
         }
         document.getElementById(showContent).style.display = "block";
         $("#"+showContent+" li:eq(0) .show-text").hide();
         $("#"+showContent+" li:eq(0) .show-pic").show();
         
          $(selfObj).css("color","rgb(37, 172, 223)");

     }  
     

 function Bestsellers(Bestsellers,BestsellersDiv){
    
   switch(Bestsellers){
     
       case "Bestsellers1":
          document.getElementById("Bestsellers1").className="on";
          $("#Bestsellers1 a:eq(0)").css("color","#25acdf");
          $("#Bestsellers2 a:eq(0)").css("color","#333333");
          $("#Bestsellers3 a:eq(0)").css("color","#333333");
          document.getElementById("Bestsellers2").className="";
          document.getElementById("Bestsellers3").className="";
          document.getElementById("BestsellersDiv1").style.display="block";
          document.getElementById("BestsellersDiv2").style.display="none";
          document.getElementById("BestsellersDiv3").style.display="none";
       break;
       case "Bestsellers2":
          document.getElementById("Bestsellers1").className="";
          document.getElementById("Bestsellers2").className="on";
          document.getElementById("Bestsellers3").className="";
          
           $("#Bestsellers1 a:eq(0)").css("color","#333333");
          $("#Bestsellers2 a:eq(0)").css("color","#25acdf");
          $("#Bestsellers3 a:eq(0)").css("color","#333333");
          document.getElementById("BestsellersDiv1").style.display="none";
          document.getElementById("BestsellersDiv2").style.display="block";
          document.getElementById("BestsellersDiv3").style.display="none";
       break;
       case "Bestsellers3":
          document.getElementById("Bestsellers1").className="";
          document.getElementById("Bestsellers2").className="";
          document.getElementById("Bestsellers3").className="on";
           $("#Bestsellers1 a:eq(0)").css("color","#333333");
          $("#Bestsellers2 a:eq(0)").css("color","#333333");
          $("#Bestsellers3 a:eq(0)").css("color","#25acdf");
          document.getElementById("BestsellersDiv1").style.display="none";
          document.getElementById("BestsellersDiv2").style.display="none";
          document.getElementById("BestsellersDiv3").style.display="block";
       break;
   
   }
   
 }
     
      function qidianNewBook(showContent, selfObj) {
         // 操作标签
         var tag = document.getElementById("qidianNewBook").getElementsByTagName("li");
         var taglength = tag.length;
         for (i = 0; i < taglength; i++) {
             tag[i].className = "";
         }
         selfObj.parentNode.className = "on";
        
         // 操作内容  
         for (i = 0; j = document.getElementById("ctl00_cphContent_lbl" + i); i++) {
             j.style.display = "none";
         }
         document.getElementById("ctl00_cphContent_" +showContent).style.display = "block";

     }  
      function FinishBook(showContent, selfObj) {
         // 操作标签
         var tag = document.getElementById("FinishBook").getElementsByTagName("li");
         var taglength = tag.length;
         for (i = 0; i < taglength; i++) {
             tag[i].className = "";
         }
         selfObj.parentNode.className = "on";
        
         // 操作内容  
         for (i = 0; j = document.getElementById("ctl00_cphContent_Finish" + i); i++) {
             j.style.display = "none";
         }
         document.getElementById("ctl00_cphContent_" +showContent).style.display = "block";

     }  

function qidianShop(showContent, selfObj) {
         // 操作标签
         var tag = document.getElementById("qidianShop").getElementsByTagName("li");
         var taglength = tag.length;
         for (i = 0; i < taglength; i++) {
             tag[i].className = "";
         }
        selfObj.parentNode.className = "on";
        
         // 操作内容  
         for (i = 0; j = document.getElementById("ctl00_cphContent_lblQidianShop" + i); i++) {
             j.style.display = "none";
         }
         document.getElementById("ctl00_cphContent_" +showContent).style.display = "block";

     }  
     
function BookSalesCharts(Distinguish){

   if(Distinguish=="week"){
   
       document.getElementById("week").className="on";
       document.getElementById("month").className="";
       document.getElementById("weekdiv").style.display="block";
       document.getElementById("monthdiv").style.display="none";
   }else if(Distinguish=="month"){
   
       document.getElementById("month").className="on";
       document.getElementById("week").className="";
       document.getElementById("weekdiv").style.display="none";
       document.getElementById("monthdiv").style.display="block";
   }
}
 $(document).ready(function(){    
         
            $("#monthList li").each(function(){                
                $(this).mouseover(function(){                  
                    $("#monthList li .show-pic").hide();
                    $("#monthList li .show-text").show();  
                    $(this).children("[class*=text]").hide();
                    $(this).children("[class*=pic]").show();
                })                        
            }); 
              $("#monthList li:eq(0) .show-text").hide();
		    $("#monthList li:eq(0) .show-pic").show();
		    
            $("#weekList li").each(function(){        
                       
                $(this).mouseover(function(){         
                    $("#weekList li .show-pic").hide();
                    $("#weekList li .show-text").show();  
                    $(this).children("[class*=text]").hide();
                    $(this).children("[class*=pic]").show();

                })            
            }); 
                $("#weekList li:eq(0) .show-pic").show();
                $("#weekList li:eq(0) .show-text").hide();
		   
		    
          $("#weekdiv li").each(function(){                
            $(this).mouseover(function(){   
				 $("#weekdiv li .show-pic").hide(); 
				$("#weekdiv li .show-text").show(); 
                $(this).children("[class*=text]").hide();
                $(this).children("[class*=pic]").show();
            })                       
        }); 
		$("#weekdiv li:eq(0) .show-text").hide();
		$("#weekdiv li:eq(0) .show-pic").show();
		
        $("#monthdiv li:eq(0) .show-text").hide();
		$("#monthdiv li:eq(0) .show-pic").show();
        
          $("#monthdiv li").each(function(){                
            $(this).mouseover(function(){         
                $("#monthdiv li .show-pic").hide(); 
				$("#monthdiv li .show-text").show();           
                $(this).children("[class*=text]").hide();
                $(this).children("[class*=pic]").show();
            })                         
        }); 
    });

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
        })

