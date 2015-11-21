<?php
	class ListAction extends Action{
		public function header(){
			$this->display();
		}
		public function index(){
			//分类
			$classify=M("Classify");
			$classify_father=$classify->where("id={$_GET['classify_id']}")->find();
			$this->assign("classify_father",$classify_father);
			$book_classes=$classify->where('pid=1')->select();
			foreach($book_classes as $key=>$value){
				if($value['id']==$_GET['classify_id']){
					$book_classes[$key]['on']=true;
				}
			}
			$this->assign("book_classes",$book_classes);
			
			//图书列表
			$goods=M("Goods");
			import('ORG.Util.Page');// 导入分页类
			$count=$goods->where("classify_id={$_GET['classify_id']}")->count();
			$page=new Page($count,20);
			if($_GET['order']=="reserve"){
				$book_list=$goods->where("classify_id={$_GET['classify_id']}")->order('reserve asc')->limit($page->firstRow.','.$page->listRows)->select();
			}elseif($_GET['price']){
				$book_list=$goods->where("classify_id={$_GET['classify_id']}")->order('qd_price desc')->limit($page->firstRow.','.$page->listRows)->select();
			}else{
				$book_list=$goods->where("classify_id={$_GET['classify_id']}")->limit($page->firstRow.','.$page->listRows)->select();
			}
			foreach($book_list as $key=>$value){
				$arr=explode("_",$book_list[$key]['image']);
				$book_list[$key]['image_first']=$arr[0];
				$book_list[$key]['image_last']=$arr[1];
				$book_list[$key]['rebate']=round($book_list[$key]['qd_price']/$book_list[$key]['price'],2)*10;
			}
			//查询每本书的类别
			
			$this->show=$page->show();
			//总条数
			$this->count_list=$count;
			$this->firstRow=$page->firstRow+1;
			$this->listRows=$page->listRows;
			$this->assign("book_list",$book_list);
			$this->display();
		}
		public function footer(){
			$this->display();
		}
	}