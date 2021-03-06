<?php	
	class ShowcartAction extends Action{
		public function header(){
			$this->display();
		}
		public function index(){
			//显示address
			$a=M("Address");
			$address=$a->where("uid='{$_SESSION['user']['id']}'")->select();
			
			
			//显示购物车
			$c=M("cart");
			$goodscart=$c->where("uid=".$_SESSION['user']['id'])->select();
			$good=M("goods");
			$alltotal=0;
			 foreach($goodscart as $key=>$value){
				$goods=$good->where("id=".$value['gid'])->find();
				$arr_image=explode("_",$goods['image']);
				$goods['image_first']=$arr_image[0];
				$goods['image_last']=$arr_image[1];
				$goods['num']=$value['num'];
				$total=$goods['qd_price']*$goods['num'];
				$goods['total']=$total;
				$alltotal+=$total;
				$arr[]=$goods;				
			} 
			$this->assign("alltotal",$alltotal);
			$this->assign("goods",$arr);
			$this->assign("address",$address);
			$this->display();
			
			
		}
		//将物品放入购物车
		public function sendcart(){
			$uid=$_SESSION['user']['id'];
			$gid=$_POST['id'];
			$num=$_POST["num"];
			 $good=M("Goods");
			$goods_info=$good->where("id={$gid}")->find();
			if($goods_info['reserve']==0){
				echo 0;
			}else{
			//查看购物车是否存在该商品
			//如果该商品存在，只更新商品数量
				$c=M("Cart");
				$result=$c->where("gid={$gid} AND uid={$uid}")->find();
				 if($result>0){
					$newnum['num']=$result['num']+$num;
					$c->where("gid={$gid} AND uid={$uid}")->save($newnum);
				}else{
					$cartgoods['uid']=$uid;
					$cartgoods['gid']=$gid;
					$cartgoods['num']=$num;
					$c->add($cartgoods);
				}
				$count=$c->where("uid={$uid}")->count();
				$goodscart=$c->where("uid=".$_SESSION['user']['id'])->select();
				$alltotal=0;
				 foreach($goodscart as $key=>$value){
					
					$goods=$good->where("id=".$value['gid'])->find();
					$goods['num']=$value['num'];
					$total=$goods['qd_price']*$goods['num'];
					$goods['total']=$total;
					$alltotal+=$total;
				}
				$show['count']=$count;
				$show['total']=$alltotal;
				echo json_encode($show); 
			} 
		}
		//显示购物车
	
		//删除购物车数据
		public function delete(){
			$gid=$_POST['id'];
			$c=M("cart");
			$goodscart=$c->where("gid=".$gid)->delete();
			if($goodscart>0){
				echo 1;
			}else{
				echo 0;
			}
			//$this->redirect("__APP__/Showcart/goodscart");
		}
			//在购物车修改商品数量
			public function newnum(){
				$newnum['num']=$_POST['num'];
				$gid=explode('-',$_POST['id']);
				$goods=M("Goods");
				//查商品的库存
				$goods_reserve=$goods->where("id=".$gid[0])->find();
				if($_POST['num']>$goods_reserve['reserve']){
					$arr['flag']=1;
					$arr['reserve']=$goods_reserve['reserve'];
					$newnum['num']=$goods_reserve['reserve'];
					echo json_encode($arr);
				}else{
					$arr['flag']=0;
					echo json_encode($arr);
				}
					$c=M("cart");
					$c->where("gid=".$gid[0])->save($newnum);
				
			}
		
	
	
	
	
	
	
	}