<?php
	class OrderAction extends Action{
		public function index(){
			$o=M("order");
			$a=M("address");
			$g=M('goods');
			$ordercount=$o->where("user_id=".$_SESSION['user']['id'])->count();
			$this->assign("ordercount",$ordercount);
			$noordercount=$o->where("status=0 and user_id=".$_SESSION['user']['id'])->count();
			$this->assign('noordercount',$noordercount);
			$yesordercount=$o->where("status=1 and user_id=".$_SESSION['user']['id'])->count();
			$this->assign('yesordercount',$yesordercount);
			$status=$_GET["status"];
			if($status==null){
			//显示订单
			
			$showorder=$o->where("user_id=".$_SESSION['user']['id'])->select();
			//取出收件人
			foreach($showorder as $key=>$value){
				$receiver=$a->where("id=".$value['address_id'])->getField("receiver");
				$showorder[$key]['receiver']=$receiver;
				$goodsname=$g->field("name")->where("id in ({$value['goods_id']})")->select();
				foreach($goodsname as $k=>$val){
					$goodsarr[]=$val['name'];
				}
				//dump($goodsarr);
				$goodsname=truncate(implode(',',$goodsarr));
				
				$showorder[$key]['goodsname']=$goodsname;
				
			}
			$this->assign('showorder',$showorder);
			$this->display();
			}else if($status==0){
				//显示订单
				$showorder=$o->where("status={$status} and user_id={$_SESSION['user']['id']}")->select();
				//取出收件人
				foreach($showorder as $key=>$value){
					$receiver=$a->where("id=".$value['address_id'])->getField("receiver");
					$showorder[$key]['receiver']=$receiver;
					$goodsname=$g->field("name")->where("id in ({$value['goods_id']})")->select();
					foreach($goodsname as $k=>$val){
						$goodsarr[]=$val['name'];
					}
					//dump($goodsarr);
					$goodsname=truncate(implode(',',$goodsarr));
					
					$showorder[$key]['goodsname']=$goodsname;
					
				}
				$this->assign('showorder',$showorder);
				$this->display();
		}else if($status==1){
			//显示订单
			$showorder=$o->where("status={$status} and user_id={$_SESSION['user']['id']}")->select();
			//取出收件人
			foreach($showorder as $key=>$value){
				$receiver=$a->where("id=".$value['address_id'])->getField("receiver");
				$showorder[$key]['receiver']=$receiver;
				$goodsname=$g->field("name")->where("id in ({$value['goods_id']})")->select();
				foreach($goodsname as $k=>$val){
					$goodsarr[]=$val['name'];
				}
				//dump($goodsarr);
				$goodsname=truncate(implode(',',$goodsarr));
				
				$showorder[$key]['goodsname']=$goodsname;
				
			}
			$this->assign('showorder',$showorder);
			$this->display();
		}
		
		}
			
		//插入新订单
		public function insert(){
			if($_POST['address']==null){
			
				$this->error('请先填写地址哦亲');
			}
			
			if($_POST['address']==0){
				if( $_POST['new_address']==null || $_POST['receiver']==null || $_POST['phone']==null || $_POST['zipcode']==null){
					$this->error("请填写详细的新地址");
				}
			$data['uid']=$_SESSION['user']['id'];
			$data['area']=$_POST['s_province'].$_POST['s_city'].$_POST['s_county'];
			$data['address']=$_POST['new_address'];
			$data['receiver']=$_POST['receiver'];
			$data['phone']=$_POST['phone'];
			$data['zipcode']=$_POST['zipcode'];
			$address=M("address");
			$result=$address->add($data);
			if($result){
				$ordergoods=$_POST['cartgoods'];
				$ordergoodsid=implode(',',$ordergoods);
				$c=M("cart");
				$goodsnum=$c->where("uid={$_SESSION['user']['id']} and gid in ({$ordergoodsid})")->select();
				 foreach($goodsnum as $key=>$value){
					$ordergoodsnum[]=$value['num'];

				} 
				$ordergoodsnum=implode(',',$ordergoodsnum);
				$name=time();
				$time=time();
				$data['name']=$name;
				$data['user_id']=$_SESSION['user']['id'];
				$data['goods_id']=$ordergoodsid;
				$data['address_id']=$result;
				$data['goods_num']=$ordergoodsnum;
				$data['time']=$time;
				$data['price']=$_POST['ordertotalprice'];
				$o=M("order");
				$order=$o->add($data);
				$c=M("cart");
				if($order>0){
					//如果下单成功 则删除购物车的商品
					$delgoods=$c->execute("delete from qd_cart where gid in ({$ordergoodsid})");
					$reserveid=explode(',',$ordergoodsid);
					$reservenum=explode(',',$ordergoodsnum);
					foreach($reserveid as $key=>$value){
						$result=$c->execute("update qd_goods set reserve=reserve-{$reservenum[$key]} where id={$value}");
					}
					$this->success("下单成功","__APP__/Showcart/index");
				}else{
					$this->error("加入订单失败");
				}

			}
			
			}else{
	
			$ordergoods=$_POST['cartgoods'];
				$ordergoodsid=implode(',',$ordergoods);
				$c=M("cart");
				$goodsnum=$c->where("uid={$_SESSION['user']['id']} and gid in ({$ordergoodsid})")->select();
				 foreach($goodsnum as $key=>$value){
					$ordergoodsnum[]=$value['num'];

				} 
				$ordergoodsnum=implode(',',$ordergoodsnum);
				
				$addressid=$_POST['address'];
				$name=time();
				$time=time();
				$data['name']=$name;
				$data['user_id']=$_SESSION['user']['id'];
				$data['goods_id']=$ordergoodsid;
				$data['address_id']=$addressid;
				$data['goods_num']=$ordergoodsnum;
				$data['time']=$time;
				$data['price']=$_POST['ordertotalprice'];
				$o=M("order");
				$order=$o->add($data);
				$c=new Model();
	
				if($order>0){
					//如果下单成功 则删除购物车的商品
					$delgoods=$c->execute("delete from qd_cart where gid in ({$ordergoodsid})");
					$reserveid=explode(',',$ordergoodsid);
					$reservenum=explode(',',$ordergoodsnum);
					foreach($reserveid as $key=>$value){
						$result=$c->execute("update qd_goods set reserve=reserve-{$reservenum[$key]} where id={$value}");
					}
					$this->success("下单成功","__APP__/Showcart/index");
				}else{
					$this->error("加入订单失败");
				}			

			}
			
			
		}
		public function orderShow(){
			$order=new Model();
			$order_detail=$order->query("select o.name,o.id,o.goods_id,o.goods_num,o.time,o.price,a.receiver,a.phone,a.area,a.address from qd_order as o,qd_address as a where o.address_id=a.id and o.name=".$_POST['name']);
			foreach($order_detail as $value){
				$arr['name']=$value['name'];
				$arr['goods_id']=$value['goods_id'];
				$arr['goods_num']=explode(",",$value['goods_num']);
				$arr['time']=$value['time'];
				$arr['price']=$value['price'];
				$arr['receiver']=$value['receiver'];
				$arr['phone']=$value['phone'];
				$arr['address']=$value['area'].$value['address'];
			}
			$goods=M("Goods");
			$map['id']=array('in',"{$arr['goods_id']}");
			$goods_list=$goods->field('id,classify_id,name,qd_price')->where($map)->select();
			$arr['goods']=$goods_list;
			foreach($arr['goods'] as $key=>$value){
				$arr['goods'][$key]['num']=$arr['goods_num'][$key];
			}
			unset($arr['goods_num']);
			unset($arr['goods_id']);
			echo json_encode($arr);
		}
		
		
	}