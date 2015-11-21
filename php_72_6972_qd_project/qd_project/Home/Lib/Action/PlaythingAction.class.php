<?php
	class PlaythingAction extends Action{
		public function header(){
			$this->display();
		}
		public function index(){
			//分类
			$classify=M("Classify");
			$play_classes=$classify->where('pid=2')->select();
			foreach($play_classes as $key=>$value){
				$arr[]=$value['id'];
			}
			$pid=implode(",",$arr);
			$this->assign("play_classes",$play_classes);
			
			//商品
			$goods=M("Goods");
			if(!isset($_GET['classify_id'])){
				import('ORG.Util.Page');// 导入分页类
				$count=$goods->where(array('classify_id'=>array('in',$arr)))->count();
				$page=new Page($count,9);
				$plaything=$goods->where(array('classify_id'=>array('in',$arr)))->limit($page->firstRow.','.$page->listRows)->select();
				foreach($plaything as $key=>$value){
					$arr=explode("_",$plaything[$key]['image']);
					$plaything[$key]['image_first']=$arr[0];
					$plaything[$key]['image_last']=$arr[1];
					$plaything[$key]['rebate']=round($plaything[$key]['qd_price']/$plaything[$key]['price'],2)*10;
					$plaything[$key]['truncate']=truncate($plaything[$key]['name'],30);
				}
				$this->count_list=$count;
				$this->firstRow=$page->firstRow+1;
				$listRows=$this->firstRow+$page->listRows-1;
				if($listRows>$count){
					$this->listRows=$count;
				}else{
					$this->listRows=$listRows;
				}
				$this->show=$page->show();
				$this->assign("plaything",$plaything);
			}else{
				import('ORG.Util.Page');// 导入分页类
				$count=$goods->where("classify_id={$_GET['classify_id']}")->count();
				$page=new Page($count,9);
				$plaything=$goods->where("classify_id={$_GET['classify_id']}")->limit($page->firstRow.','.$page->listRows)->select();
				foreach($plaything as $key=>$value){
					$arr=explode("_",$plaything[$key]['image']);
					$plaything[$key]['image_first']=$arr[0];
					$plaything[$key]['image_last']=$arr[1];
					$plaything[$key]['rebate']=round($plaything[$key]['qd_price']/$plaything[$key]['price'],2)*10;
					$plaything[$key]['truncate']=truncate($plaything[$key]['name'],30);
				}
				$this->count_list=$count;
				$this->firstRow=$page->firstRow+1;
				$listRows=$this->firstRow+$page->listRows-1;
				if($listRows>$count){
					$this->listRows=$count;
				}else{
					$this->listRows=$listRows;
				}
				$this->show=$page->show();
				$this->assign("plaything",$plaything);
			}
			
			/**热卖榜*/
			$hot_sail_book=D('Index')->get_hot_search_book();
			$hot_sail_plaything=D('Index')->get_hot_search_plaything();
			$this->assign("hot_sail_book",$hot_sail_book);
			$this->assign("hot_sail_plaything",$hot_sail_plaything);
			
			
			$this->display();
		}
	}
