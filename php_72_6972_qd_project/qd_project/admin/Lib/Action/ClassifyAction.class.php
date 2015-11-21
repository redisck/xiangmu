<?php
	class ClassifyAction extends CommonAction{
		/**
			显示分类列表
		*/
		public function index(){
			$this->init();
			$class_list=D("Classify")->get_class_list();
			$this->assign("class_list",$class_list);
			$this->display();
		}
		/**
			添加分类
		*/
		public function add(){
			$this->init();
			$add_class=D('Classify')->add_class();
			$this->redirect('index');
			
		}
		public function edit(){
			$this->init();
			 $class=M("Classify");
			 //获取当前分类的内容
			$class_now=$class->where(array('id'=>$_GET['id']))->find();
			
			//获取所有顶级分类
			$class_pid=$class->where(array('pid'=>0))->select();
			foreach($class_pid as $key=>$v){
				if($v['id']==$class_now['pid']){
					$class_pid[$key]['access']=true;
				}
			}
			$this->assign("class_pid",$class_pid);
			$this->assign("class_now",$class_now); 
			$this->display();
			
		}
		public function doedit(){
			$this->init();
			
			$class=M("Classify");
			$path=$class->field('path')->where(array('id'=>$_POST['pid']))->find();
			if($path==null){
				$path="0,";
			}else{
				$path=$path['path'].$_POST['pid'].",";
			}
			$data['name']=$_POST['edit_name'];
			$data['status']=$_POST['status'];
			$data['pid']=$_POST['pid'];
			$data['path']=$path;
			$res=$class->where(array('id'=>$_GET['id']))->save($data);
			if($res){
				echo $this->success('修改成功',U('index'));
			}
		}
		public function delete(){
			$this->init();
			$class=M("Classify");
			$class_fa=$class->where(array('id'=>$_GET['id']))->delete();
			$class_child=$class->where(array('pid'=>$_GET['id']))->select();
			if($class_child){
				$class_chid_res=$class->where(array('pid'=>$_GET['id']))->delete();	
				}
			if($class_fa || ($class_fa && $class_child_res)){
				$this->success('删除成功',U('index'));
				}
			}
		}
	
	