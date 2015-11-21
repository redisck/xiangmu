<?php
	class SearchAction extends Action{
		public function index(){
			//分类
			$classify=M("Classify");
			$book_classes=$classify->where('pid=1')->select();
			foreach($book_classes as $key=>$value){
				$arr[]=$value['id'];
			}
			$id=implode(",",$arr);
			$this->assign("book_classes",$book_classes);
			//图书列表
			$goods=M("Goods");
			if(isset($_GET['search_name']) && isset($_GET['search_classify'])){
			$map['name']=array('like',"%{$_GET['search_name']}%");
			$map['classify_id']=array('in',$id);
			//导入分页类
			import('ORG.Util.Page');
			$count=$goods->where($map)->count();
			$page=new Page($count,20);
			$book_list=$goods->where($map)->limit($page->firstRow.','.$page->listRows)->select();
			}
			if(isset($_GET['condition']) && isset($_GET['search_name'])){
				if($_GET['condition']==1){
					$map['name']=array('like',"%{$_GET['search_name']}%");
					$map['classify_id']=array('in',$id);
					//导入分页类
					import('ORG.Util.Page');
					$count=$goods->where($map)->count();
					$page=new Page($count,20);
					$book_list=$goods->where($map)->limit($page->firstRow.','.$page->listRows)->select();
				}
				if($_GET['condition']==2){
					$map['author']=array('like',"%{$_GET['search_name']}%");
					$map['classify_id']=array('in',$id);
					//导入分页类
					import('ORG.Util.Page');
					$count=$goods->where($map)->count();
					$page=new Page($count,20);
					$book_list=$goods->where($map)->limit($page->firstRow.','.$page->listRows)->select();
				}
				if($_GET['condition']==3){
					$map['press']=array('like',"%{$_GET['search_name']}%");
					$map['classify_id']=array('in',$id);
					//导入分页类
					import('ORG.Util.Page');
					$count=$goods->where($map)->count();
					$page=new Page($count,20);
					$book_list=$goods->where($map)->limit($page->firstRow.','.$page->listRows)->select();
				}
			}
			foreach($book_list as $key=>$value){
				$arr=explode("_",$book_list[$key]['image']);
				$book_list[$key]['image_first']=$arr[0];
				$book_list[$key]['image_last']=$arr[1];
				$book_list[$key]['rebate']=round($book_list[$key]['qd_price']/$book_list[$key]['price'],2)*10;
			}

			$this->show=$page->show();
			$this->count_list=$count;
			$this->firstRow=$page->firstRow+1;
			$this->listRows=$page->listRows;
			$this->assign("book_list",$book_list);
			$this->display();
		}
	}