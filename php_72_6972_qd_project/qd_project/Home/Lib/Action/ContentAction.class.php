<?php
	class ContentAction extends Action{
		public function index(){
			$this->now=time();
			$this->md5_id=md5($_GET['id']);
			$goods=M("Goods");

			//右侧分类
			$classify=M("Classify");
			$classify_father=$classify->where("id={$_GET['classify_id']}")->find();
			$this->assign("classify_father",$classify_father);
			if($classify_father['pid']==1){
				$book_classes=$classify->where('pid=1')->select();
				foreach($book_classes as $key=>$value){
					if($value['id']==$_GET['classify_id']){
						$book_classes[$key]['on']=true;
					}
				}
				$this->assign("book_classes",$book_classes);
			}else{
				$play_classes=$classify->where('pid=2')->select();
				foreach($play_classes as $key=>$value){
					if($value['id']==$_GET['classify_id']){
						$play_classes[$key]['on']=true;
					}
				}
				$this->assign("play_classes",$play_classes);
			}
		
			
			//商品
			$goods_info=$goods->where("id={$_GET['id']}")->find();
			foreach($goods_info as $key=>$value){
				$arr=explode("_",$goods_info['image']);
				$goods_info['image_first']=$arr[0];
				$goods_info['image_last']=$arr[1];
				$goods_info['rebate']=round(($goods_info['qd_price']/$goods_info['price'])*10,2);
				$goods_info['rebate_money']=$goods_info['price']-$goods_info['qd_price'];
			}
			if($goods_info['qd_id']==1 && $classify_father['pid']==1){
				//起点热卖榜
				$qd_hot_book=D("Book")->get_qd_hot_book();
				$this->assign("qd_hot_book",$qd_hot_book);
			
			}elseif($goods_info['qd_id']==0 && $classify_father['pid']==1){
				//传统馆热卖榜
				$tr_hot_book=D("Book")->get_tr_hot_book();
				$this->assign("tr_hot_book",$tr_hot_book);
			}
			
			//显示评论
			$c=M('comment');
			$u=M('user');
			$comment=$c->where("goods_id=".$_GET['id'])->order('time')->select();
			foreach($comment as $key=>$val){
				$username=$u->where("id=".$val['user_id'])->getField('username');
				$content[$key]['username']=$username;
				$content[$key]['content']=$val['content'];
				$content[$key]['time']=date("Y-m-d H:i:s",$val['time']);
			}
			$this->assign("comment",$content);
			$this->assign("goods_info",$goods_info);
			$this->display();
		}
		public function ajax_reserve(){
			 $goods=M("Goods");
			$goods_info=$goods->where("id={$_POST['id']}")->find();
			if($goods_info['reserve']>=$_POST['num']){
				echo $goods_info['reserve'];
			}else{
				echo 0;
			}  
			
		}
		public function header(){
			$this->display();
		}
		//插入评论
		public function insertcomment(){

			 $data['goods_id']=$_POST['gid'];
			$data['user_id']=$_SESSION['user']['id'];
			$data['content']=$_POST['content'];
			$data['time']=time();
			$c=M("comment");
			$o=M("order");
			$res=$o->where("user_id={$data['user_id']}")->select();
			foreach($res as $key =>$val){
				$str=$str.$val['goods_id'].",";
			}
			$str=explode(',',$str);
			$ordergoodsids=in_array($data['goods_id'],$str);
			if($ordergoodsids){
				$result=$c->add($data);
			}
			$lastcomment=$c->where('id='.$result)->find();
			$u=M("user");
			$lastcomment['username']=$u->where("id=".$lastcomment['user_id'])->getField('username');
			$lastcomment['content']=$lastcomment['content'];
			$lastcomment['time']=date("Y-m-d H:i:s",$lastcomment['time']);
			if($ordergoodsids){
				
				echo json_encode($lastcomment);
			}else{
			
				echo 0;
			}
			
		}
		
		
		
		
		
	}