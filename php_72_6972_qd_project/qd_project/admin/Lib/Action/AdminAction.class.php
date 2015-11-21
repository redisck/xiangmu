<?php
	class AdminAction extends CommonAction{
		public function index(){
			//管理员列表
			$admin=new Model();
			$admin_info=$admin->query("select a.id,a.admin_name,a.last_login_time,a.last_login_ip,r.role_name from qd_admin as a,qd_role as r,qd_admin_role as ar where a.id=ar.admin_id and ar.role_id=r.id");
			foreach($admin_info as $key=>$value){
				$admin_info[$key]['last_login_time']=date("Y-m-d H:i:s",$admin_info[$key]['last_login_time']);
				$admin_info[$key]['last_login_ip']=long2ip($admin_info[$key]['last_login_ip']);
			}
			$this->assign("admin_info",$admin_info);
			//角色遍历
			$role=M("Role");
			$role_list=$role->select();
			$this->assign("role_list",$role_list);
			
			
			$this->display();
		}
		public function doAddAdmin(){
			$admin=M("Admin");
			$data['admin_name']=$_POST['admin_name'];
			if($_POST['admin_pwd']!=$_POST['sure_pwd']){
				echo "<script>alert('两次密码不一致')</script>";
				$this->redirect('Admin/index');
			}
			if(!isset($_POST['role_id'])){
				$this->error('请赋予角色');
			}
			$data['admin_pwd']=md5($_POST['admin_pwd']);
			$admin_id=$admin->add($data);//新插入管理员id
			$admin_role=M("AdminRole");
			$data_role['admin_id']=$admin_id;
			$data_role['role_id']=$_POST['role_id'];
			if($admin_role->add($data_role)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
			
		}
		public function doEdit(){
			 $admin=M("Admin");
			if(empty($_POST['admin_pwd']) || empty($_POST['sure_pwd']) || $_POST['admin_pwd']!=$_POST['sure_pwd']){
				$this->error('密码填写错误');
			}
			$data['admin_pwd']=md5($_POST['admin_pwd']);
			$admin->where("id={$_POST['admin_id']}")->save($data);
			$admin_role=M("AdminRole");
			$data_role['role_id']=$_POST['role_id'];
			if($admin_role->where("admin_id={$_POST['admin_id']}")->save($data_role)){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			} 
		}
		public function ajax_admin_info(){
			$admin=new Model();
				$admin_info=$admin->query("select a.admin_name,ar.role_id from qd_admin as a,qd_admin_role as ar where a.id=ar.admin_id and a.id=".$_POST['admin_id']);
				echo json_encode($admin_info);
		}
	}