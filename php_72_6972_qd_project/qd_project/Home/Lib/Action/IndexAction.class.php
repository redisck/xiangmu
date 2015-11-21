<?php

class IndexAction extends Action {
    public function index(){
		$classify_image=get_classify_image();
		$classify=D('Index')->get_father_classify();
		/**限时促销*/
		$sail_info=D("Index")->get_time_sail_info();
		foreach($sail_info as $key=>$value){
			$arr=explode("_",$sail_info[$key]['image']);
			$sail_info[$key]['image_first']=$arr[0];
			$sail_info[$key]['image_last']=$arr[1];
		}
			//保存开始时间
		$_SESSION['start_time']=$sail_info[0]['start_time'];
			//保存结束时间
		$_SESSION['end_time']=$sail_info[0]['end_time'];
			//计算折扣
		$sail_info_rebate=round(($sail_info[0]['rebate_price'] / $sail_info[0]['price'])*10,2);
			//计算差价
		$this->diff_price=number_format($sail_info[0]['price']-$sail_info[0]['rebate_price'],2);
		$this->rebate=$sail_info_rebate; //折扣
		foreach($sail_info as $key=>$value){
			$sail_info[$key]['md5']=md5($sail_info[$key]['goods_id']);
		}
		$this->assign("sail_info",$sail_info);
		/*限时促销结束*/
		
		/**热卖榜*/
		$hot_sail_book=D('Index')->get_hot_search_book();
		$hot_sail_plaything=D('Index')->get_hot_search_plaything();
		$this->assign("hot_sail_book",$hot_sail_book);
		$this->assign("hot_sail_plaything",$hot_sail_plaything);
		
		
		
		
		
		/**图书*/
		//新书上架
		$new_book=D('Index')->get_new_book();
		$this->assign("new_book",$new_book);
		
		//重磅推荐
		$weight_book=D("Index")->get_weight_book();
		$this->assign("weight_book",$weight_book);
		
		/**周边*/
		$plaything=D("Index")->get_plaything();
		$this->assign("plaything",$plaything);
		
		/*顶部幻灯片*/
		$ad=M("Ad");
		$ad_list=$ad->where('type="首页幻灯片"')->order('status desc')->limit(4)->select();
		foreach($ad_list as $key=>$value){
				$arr=explode("_",$ad_list[$key]['image']);
				$ad_list[$key]['image_first']=$arr[0];
				$ad_list[$key]['image_last']=$arr[1];
		}
		$this->assign("ad_list",$ad_list);
		/*底部广告*/
		$ad_bottom=$ad->where('type="首页底部广告"')->order('status desc')->find();
		$arr=explode("_",$ad_bottom['image']);
		$ad_bottom['image_first']=$arr[0];
		$ad_bottom['image_last']=$arr[1];
		$this->assign("ad_bottom",$ad_bottom);
		
		
		$this->assign("classify",$classify);
		$this->display();
		
    }
	public function ajax_sail_time(){
		$diff[]=$_SESSION['start_time']-time();
		$diff[]=$_SESSION['end_time']-time();
		echo json_encode($diff);
	}
	public function header(){
		$this->display();
	}
	public function footer(){
		$this->display();
	}
}