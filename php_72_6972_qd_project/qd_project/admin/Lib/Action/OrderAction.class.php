<?php
	class OrderAction extends CommonAction{
		public function index(){
			$this->init();
			$where[]=" u.id=o.user_id  ";
			if(isset($_POST['ordername']) && $_POST['ordername'] !==""){
				$where[]="name=".$_POST['ordername'];
			}
			if(isset($_POST['buyuser']) && $_POST['buyuser']!==""){
				$user=M("User");
				$username['username']=$_POST['buyuser'];
				$uid=$user->where($username)->select();
				$where[]="user_id=".$uid[0]['id'];
			}
			if(isset($_POST['nosend']) && $_POST['nosend']!==""){
			
				$where[]="status=".$_POST['nosend'];
			}
			$where=implode("  and  ",$where);
			//显示订单
			$order=new Model();
			import('ORG.Util.Page'); 
			$o=M("order");
			$count=$o->count();

			$page=new Page($count,10);
			$show=$page->show();
			$orders=$order->query("select u.username,o.* from qd_user as u ,qd_order as o where {$where} limit {$page->firstRow},{$page->listRows}");
			
			foreach($orders as $key=>$value){
				$orders[$key]['time']=date("Y-m-d H:i:s",$orders[$key]['time']);
			}
			$this->assign('page',$show);
			$this->assign("orders",$orders);
			$this->display();
		}
			
			
			
			//显示订单详情
		public function detail(){
			$this->init();
			$orderid=$_GET['id'];
			//dump($orderid);
			//订单表值
			$order=M("order");
			$orders=$order->where("id=".$orderid)->select();
			$num=explode(',',$orders[0]['goods_num']);
			//下单人
			$user=M("user");
			$users=$user->where("id=".($orders[0]['user_id']))->getField('username');
			//地址表值
			$address=M("address");
			$addresses=$address->where("id=".($orders[0]['address_id']))->select();
			//订单中多个商品
			$goodid=$orders[0]['goods_id'];
			
			$good=new Model;
			
			$goods=$good->query("select name,qd_price,image from qd_goods where id in ({$goodid})");
			foreach($goods as $key=>$val){
				$goods[$key]['num']=$num[$key];
				$arr=explode('_',$val['image']);
				$goods[$key]['path1']=$arr[0];
				$goods[$key]['path2']=$arr[1];
				$goods[$key]['root']=C('Goods_image_path');
			}
			
			//发送值
			$this->assign("goods",$goods);
			$this->assign("orders",$orders);
			$this->assign("users",$users);
			$this->assign("addresses",$addresses);
			$this->display();
			
			
		}
		
		
		
		//改变订单状态
		public function changestatus(){
			$this->init();
			$name=$_POST['name'];
			$o=M("order");
			$status['status']=1;
			$result=$o->where("name=".$name)->save($status);
			if($result>0){
				echo 1;
			}else{
				echo 0;
			}
			
		}
		
	
	
	}