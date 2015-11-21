<?php
	class RoleAction extends CommonAction{
		public function index(){
			$role=M("Role");
			$role_list=$role->select();
			$this->assign("role_list",$role_list);
			$this->display();
		}
		public function doAddRole(){
			$role=M("Role");
			$role->create();
			if($role->add()){
				$this->success('添加成功');
			}
		}
	}