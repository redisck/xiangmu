<?php
	class GoodsAction extends CommonAction{
		/**
			图书列表
		*/
		public function book(){
			$this->init();
			$start_time=date("Y-m-d",time()+86400); //获取限时促销开始时间
			$end_time=date("Y-m-d",time()+86400+86400);  //限时促销结束时间
			$this->assign("end_time",$end_time);
			$this->assign("start_time",$start_time);
			$classify=M('Classify');
			$classify_book=$classify->where(array('pid'=>1))->select();//遍历图书的所有类型
			foreach($classify_book as $value){
				$array[]=$value['id'];
			}
			
			$goods=M("Goods");
			import('ORG.Util.Page');//实例化分页类
			if(!isset($_POST['classify_id']) && !isset($_POST['qd_id']) && !isset($_POST['book_intr']) && !isset($_POST['name'])){
				$count=$goods->where(array('status'=>0,'classify_id'=>array('in',$array)))->count();
				$page=new Page($count,12);
				$this->show=$page->show();
				$goods_list=$goods->where(array('status'=>0,'classify_id'=>array('in',$array)))->limit($page->firstRow.','.$page->listRows)->select();
				//获取书的类别
				foreach($goods_list as $key=>$value){
					foreach($classify_book as $v){
						if($value['classify_id']==$v['id']){
							$goods_list[$key]['class_name']=$v['name'];
						}
					}
				}
			}else{
				//搜索开始
				$where[] = "status=0";
				 if(isset($_POST['classify_id']) && $_POST['classify_id'] != '')
					$where[] = 'classify_id='.$_POST['classify_id'];
				if(isset($_POST['qd_id']) && $_POST['qd_id'] != '')
					$where[] = 'qd_id='.$_POST['qd_id'];
					$where[]='classify_id in ('.implode(",",$array).')'; 
				if(isset($_POST['book_intr']) && $_POST['book_intr'] != '')
					$where[] = "{$_POST['book_intr']}=1";
				if(isset($_POST['name']) && $_POST['name'] != '')
					$where[] = "name like '%{$_POST['name']}%'";
				$where = implode(' AND ' , $where);
				$count=$goods->where($where)->count();
				$page=new Page($count,12);
				$goods_list=$goods->where($where)->limit($page->firstRow.','.$page->listRows)->select();
				foreach($goods_list as $key=>$value){
						foreach($classify_book as $v){
							if($value['classify_id']==$v['id']){
								$goods_list[$key]['class_name']=$v['name'];
							}
						}
					}
				$this->show=$page->show();
				}
			
			
			$this->assign("goods_list",$goods_list);
			$this->assign("classify_book",$classify_book);
			//$this->assign("goods_list",$goods_list);
			$this->display();
		}
		public function addBook(){
			$this->init();
			$classify=M('Classify');
			$this->classify_book=$classify->where(array('pid'=>1))->select();
			$this->display();
		}
		public function doAddBook(){
			$this->init();
		   if(empty($_POST['name']) || empty($_POST['classify_id']) || !isset($_POST['qd_id']) || empty($_POST['price'])
				|| empty($_POST['qd_price']) || empty($_POST['reserve']) || empty($_FILES['image']) || empty($_POST['description']) ){
					echo "<script>alert('信息填写不正确')</script>";
					$this->redirect('Goods/addBook');
				} 
			$image_root=C('Goods_image_path');
			$image_common=C('Goods_image_common');
			//组装上传路径
			//$upload_path=$image_root.'/'.$image_common;
			//echo $upload_path;
			$date_dir=date("Y-m");
			if(!file_exists($image_root.'/'.$date_dir)){
				mkdir($image_root.'/'.$date_dir);
				mkdir($image_root.'/'.$date_dir.'/common/');
				mkdir($image_root.'/'.$date_dir.'/big/');
				mkdir($image_root.'/'.$date_dir.'/small/');
				mkdir($image_root.'/'.$date_dir.'/middle/');
			}
			import('ORG.Net.UploadFile');
			$upload=new UploadFile();
			$upload->maxSize=C('Goods_image_max');
			$upload->allowExts=C('allowExts');
			$upload->savePath=$image_root.'/'.$date_dir.'/common/';
			if(!$upload->upload()){
				echo "<script>alert('上传失败')</script>";
				$this->redirect('Goods/addBook');
			}
				//获取上传信息
				$info=$upload->getUploadFileInfo();
				$save_path=$info[0]['savepath'];
				$save_name=$info[0]['savename'];
			//真正的上传路径
			$upload_path=$save_path.$save_name;
			
			//调用生成缩略图函数
			thumb_images($upload_path); 
			$goods_add=M("Goods");
			$_POST['image']=$date_dir."_".$save_name;
			$data=$_POST;
			$res=$goods_add->add($data);
			if($res){
				echo "<script>alert('添加成功')</script>";
				$this->redirect('Goods/book');
			}else{
				$this->error('添加失败');
			}
		}
		
		//书籍删除
		public function deleteBook(){
			$this->init();
			$goods=M('Goods');
			$data['status']=1;
			$delete=$goods->where(array('id'=>$_GET['id']))->save($data);
			 if($delete){
					$this->redirect('Goods/book');
			}else{
					echo "<script>alert('删除失败')</script>";
					$this->redirect('Goods/book');
			} 
			
		}
		//书籍修改
		public function editBook(){
			$this->init();
			$goods=M('Goods');
			$goods_info=$goods->where(array('id'=>$_GET['id']))->select();
			$goods_info=D('Goods')->get_book_class($goods_info,1);
			$all_classes=D('Goods')->get_classes(1);
			foreach($all_classes as $key=>$value){
				if($value['id']==$goods_info[0]['classify_id']){
					$all_classes[$key]['access']=true;
				}
			}
			$this->assign("all_classes",$all_classes);
			$this->assign("info",$goods_info[0]);
			$this->display();
		}
		public function doEditBook(){
			if(!isset($_POST['new_book']))
				$_POST['new_book']=0;
			if(!isset($_POST['serialize_book']))
				$_POST['serialize_book']=0;
			if(!isset($_POST['end_book']))
				$_POST['end_book']=0;
			if(!isset($_POST['author_book']))
				$_POST['author_book']=0;
			if(!isset($_POST['hot_search']))
				$_POST['hot_search']=0;
			if(!isset($_POST['rq_book']))
				$_POST['rq_book']=0;
			$goods=M('Goods');
			$data=$_POST;
			if($goods->where(array('id'=>$_GET['id']))->save($data)){
				$this->success('修改成功',U('Goods/book'));
			}else{
				$this->error('修改失败');
			}
		}
		//玩具页
		public function plaything(){
			$this->init();
			$classify=M('Classify');
			$classify_plaything=$classify->where(array('pid'=>2))->select();//遍历玩具的所有类型
			foreach($classify_plaything as $value){
				$array[]=$value['id'];
			}
			$pid=implode(",",$array);
			
			$goods=M("Goods");
			import('ORG.Util.Page');//实例化分页类
			if(!isset($_POST['classify_id']) && !isset($_POST['book_intr']) && !isset($_POST['name'])){
				$count=$goods->where(array('status'=>0,'classify_id'=>array('in',$array)))->count();
				$page=new Page($count,12);
				$this->show=$page->show();
				$goods_list=$goods->where(array('status'=>0,'classify_id'=>array('in',$array)))->limit($page->firstRow.','.$page->listRows)->select();
				//获取书的类别
				foreach($goods_list as $key=>$value){
					foreach($classify_plaything as $v){
						if($value['classify_id']==$v['id']){
							$goods_list[$key]['class_name']=$v['name'];
						}
					}
				}
				foreach($goods_list as $key=>$value){
					$goods_list[$key]['truncate']=truncate($goods_list[$key]['name'],$len=10);
				}
			}else{
				$where[] = "status=0";
				$where[]="classify_id in ({$pid})";
				 if(isset($_POST['classify_id']) && $_POST['classify_id'] != '')
					$where[] = 'classify_id='.$_POST['classify_id'];
				if(isset($_POST['book_intr']) && $_POST['book_intr'] != '')
					$where[] = "{$_POST['book_intr']}=1";
				if(isset($_POST['name']) && $_POST['name'] != '')
					$where[] = "name like '%{$_POST['name']}%'";
				$where = implode(' AND ' , $where);
				$count=$goods->where($where)->count();
				$page=new Page($count,12);
				$goods_list=$goods->where($where)->limit($page->firstRow.','.$page->listRows)->select();
				foreach($goods_list as $key=>$value){
						foreach($classify_plaything as $v){
							if($value['classify_id']==$v['id']){
								$goods_list[$key]['class_name']=$v['name'];
							}
						}
					}
				foreach($goods_list as $key=>$value){
					$goods_list[$key]['truncate']=truncate($goods_list[$key]['name'],$len=10);
				}
				$this->show=$page->show();
			
			}
	
			$this->assign("classify_plaything",$classify_plaything);
			$this->assign("goods_list",$goods_list);
			$this->display();
		}
		//添加玩具
		public function addPlaything(){
			$this->init();
			$goods=M("Goods");
			$this->classify_list=D("Goods")->get_classes(2);
			$this->display();
		}
		public function doAddPlaything(){
			 if(empty($_POST['name']) || empty($_POST['classify_id']) ||  empty($_POST['price'])
				|| empty($_POST['qd_price']) || empty($_POST['reserve']) || empty($_FILES['image']) || empty($_POST['description']) ){
					echo "<script>alert('信息填写不正确')</script>";
					$this->redirect('Goods/addBook');
				} 
			$res=D("Goods")->add_goods();
			if($res){
				echo "<script>alert('添加成功')</script>";
				$this->redirect('Goods/plaything');
			}else{
				$this->error('添加失败');
			}
		}
		public function editPlaything(){
			$this->init();
			$goods=M('Goods');
			$goods_info=$goods->where(array('id'=>$_GET['id']))->select();
			$goods_info=D('Goods')->get_book_class($goods_info,2);
			$all_classes=D('Goods')->get_classes(2);
			foreach($all_classes as $key=>$value){
				if($value['id']==$goods_info[0]['classify_id']){
					$all_classes[$key]['access']=true;
				}
			}
			$this->assign("all_classes",$all_classes);
			$this->assign("info",$goods_info[0]);
			$this->display();
		}
		public function doEditPlaything(){
			if(!isset($_POST['hot_search'])){
				$_POST['hot_search']=0;
			}
			if(!isset($_POST['rq_book'])){
				$_POST['rq_book']=0;
			}
			
			$goods=M('Goods');
			$data=$_POST;
			if($goods->where(array('id'=>$_GET['id']))->save($data)){
				$this->success('修改成功',U('Goods/plaything'));
			}else{
				$this->error('修改失败');
			}
		
		}
		
		//回收站
		public function recover(){
			$this->init();
			$classify=M("Classify");
			$classify_id=$classify->where('pid <> 0')->select();
			$this->assign("classify_id",$classify_id);
			$goods=M("Goods");
			import('ORG.Util.Page');// 导入分页类
			$count=$goods->where('status=1')->count();
			$page=new Page($count,15);
			$recover=$goods->where('status=1')->limit($page->firstRow.','.$page->listRows)->select();
			foreach($recover as $key=>$value){
				foreach($classify_id as $v){
					if($value['classify_id']==$v['id']){
						$recover[$key]['class_name']=$v['name'];
					}
				}
			}
			$this->show=$page->show();
			$this->assign("recover",$recover);
			$this->display();
		}
		//回收站查询
		public function recoverSearch(){
			$this->init();
			$classify=M("Classify");
			$classify_id=$classify->where('pid <> 0')->select();
			$this->assign("classify_id",$classify_id);
			$goods=M("Goods");
			import('ORG.Util.Page');// 导入分页类
			if(empty($_POST['name'])){
				$count=$goods->where(array('classify_id'=>$_POST['classify_id'],'status'=>1))->count();
				$page=new Page($count,15);
				$this->show=$page->show();
				$goods_search=$goods->where(array('classify_id'=>$_POST['classify_id'],'status'=>1))->limit($page->firstRow.','.$page->listRows)->select();
			}else{
				$count=$goods->where(array('classify_id'=>$_POST['classify_id'],'status'=>1,'name'=>array("like","%{$_POST['name']}%")))->count();
				$page=new Page($count,15);
				$this->show=$page->show();
				$goods_search=$goods->where(array('classify_id'=>$_POST['classify_id'],'status'=>1,'name'=>array("like","%{$_POST['name']}%")))->limit($page->firstRow.','.$page->listRows)->select();
			}
			$this->assign("goods_search",$goods_search);
			$this->display();
		}
		//回收站还原
		public function restore(){
			$goods=M("Goods");
			$data['status']=0;
			$res=$goods->where(array('id'=>$_GET['id']))->save($data);
			if($res){
				$this->success('恢复成功',U('Goods/recover'));
			}else{
				$this->error('还原失败');
			}
		}
		//回收站删除
		public function trueDelete(){
			$goods=M("Goods");
			$res=$goods->where(array('id'=>$_GET['id']))->delete();
			if($res){
				$this->success('删除成功',U('Goods/recover'));
			}else{
				$this->error('删除失败');
			}
		}
		
		/**进入限时促销的方法
			
			*	ajax获取通过post传参过来的内容	
			
		**/
		public function ajax_sail_info(){
			$goods=M("Goods");
			$sail_goods=$goods->where(array('id'=>$_POST['id']))->find();
			echo json_encode($sail_goods);
		}
		public function ajax_sail_time(){
			$start_time=$_POST['start_time'];
			$arr=explode('-',$start_time);
			$end_time=mktime(0,0,0,$arr[1],$arr[2],$arr[0])+3600*24;
			 $e_time=date("Y-m-d",$end_time);
			echo json_encode($e_time);
		}
		//接收提交过来的数据，写入数据库
		public function time_sail(){
			$start_time=strtotime("{$_POST['start_time']}");
			$end_time=strtotime("{$_POST['end_time']}");
			$_POST['start_time']=$start_time;
			$_POST['end_time']=$end_time;
			$data=$_POST;
			$sail=M("TimeSail");
			
			//检测该产品是否设置过限时促销
			$goods_id=$sail->where(array('goods_id'=>$_POST['goods_id']))->find();
			if($goods_id){
				echo "<script>alert('该产品正在限时促销')</script>";
				$this->redirect('Goods/book');
			}
			if($_POST['status']==1){
				$max_status=$sail->max('status');
				$add_id=$sail->add($data);
				$data['status']=$max_status+1;
				if($sail->where(array('id'=>$add_id))->save($data)){
					$this->success('添加成功',U('Goods/time_sail_list'));
				}else{
					$this->error('添加失败');
				}
			}
			if($_POST['status']==0){
				if($sail->add($data)){
					$this->success('添加成功',U('Goods/time_sail_list'));
				}else{
					$this->error('添加失败');
				}
			}
			
			
		}
		public function time_sail_list(){
			$this->init();
			$classify=M('Classify');
			$classify_sail=$classify->where(array('pid'=>1))->select();//遍历玩具的所有类型
			$sail=M("TimeSail");
			import('ORG.Util.Page');//实例化分页类
			$count=$sail->count();
			$page=new Page($count,15);
			$sail=new Model();
			$sql="select t.id,t.classify_id,t.goods_id,t.price,t.rebate_price,t.start_time,t.end_time,t.status,g.reserve,g.name from qd_goods as g,qd_time_sail as t where g.id=t.goods_id limit $page->firstRow , $page->listRows";
			$goods_list=$sail->query($sql);
			//获取分类，商品名
			foreach($goods_list as $key=>$value){
				foreach($classify_sail as $v){
					if($value['classify_id']==$v['id']){
						$goods_list[$key]['class_name']=$v['name'];
					}
				}
			}
			foreach($goods_list as $key=>$value){
				$goods_list[$key]['start_time']=date("Y-m-d",$goods_list[$key]['start_time']);
				$goods_list[$key]['end_time']=date("Y-m-d",$goods_list[$key]['end_time']);
			}
			$this->assign("goods_list",$goods_list);
			$this->show=$page->show();
			$this->display();
		}
		public function time_sail_delete(){
			$this->init();
			$goods=M('TimeSail');
			$delete=$goods->where("id={$_GET['id']}")->delete();
			 if($delete){
					$this->redirect('Goods/time_sail_list');
			}else{
					echo "<script>alert('删除失败')</script>";
					$this->redirect('Goods/book');
			} 
			
		}
	}