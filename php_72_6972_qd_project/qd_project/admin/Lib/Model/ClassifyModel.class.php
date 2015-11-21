<?php
	class ClassifyModel extends Model{
		/**
			添加分类
		*/
		public function add_class(){
			$class=M('Classify');
			$data['name']=$_POST['class_name'];
			$data['pid']=$_POST['pid'];
			if($_POST['pid']==0){
				$data['path']="0,";
			}else{
				$path=$class->where(array('id'=>$_POST['pid']))->select();
				$data['path']=$path[0]['path'].$_POST['pid'].",";
			}
			$data['status']=$_POST['status'];
			$class->add($data);
		}
		/**
			按层次获取分类的方法
		*/
		public function get_class_list(){
			$class=M("Classify");
			$class_list=$class->order('concat(path,id)')->select();
			foreach($class_list as $key=>$class_value){
				$length=explode(",",$class_value['path']);
				$class_list[$key]['length']=$length;
			}
			return $class_list;
		}
	
	}