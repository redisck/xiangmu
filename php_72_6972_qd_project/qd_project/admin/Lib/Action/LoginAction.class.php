<?php
	class LoginAction extends Action{
		public function index(){
			$this->display();
		}
		public function dologin(){
			$admin=M("Admin");
			$pwd=md5($_POST['admin_pwd']);
			$info=$admin->where(array('admin_name'=>"{$_POST['admin_name']}",'admin_pwd'=>"{$pwd}"))->select();
			if(!$info){
				echo "<meta charset='utf-8'>";
				echo "<script>alert('用户名或者密码错误')</script>";
				$this->redirect('Login/index');
			}
			if(md5($_POST['verifycode'])!=$_SESSION['verify']){
				echo "<meta charset=utf-8>";
				echo "<script>alert('验证码错误')</script>";
				$this->redirect('Login/index');
			}
			$data['last_login_time']=time();
			$data['last_login_ip']=ip2long("{$_SERVER['REMOTE_ADDR']}");
			$admin->where(array('admin_name'=>"{$_POST['admin_name']}"))->save($data);
			
			$_SESSION['admin']['name']=$_POST['admin_name'];
			$_SESSION['admin']['id']=$info[0]['id'];
			//写入权限
			$role_node=new Model();
			$nodes=$role_node->query("select rn.node_id from qd_role_node as rn,qd_admin_role as ar where ar.role_id=rn.role_id and ar.admin_id=".$_SESSION['admin']['id']);
			foreach($nodes as $key=>$value){
				$arr[]=$value['node_id'];
			}
			$_SESSION['admin']['nodes']=$arr;
			$this->redirect('Index/index');
		}
		public function logout(){
			$_SESSION['admin']=null;
			setCookie(session_name(),'',time()-1,'/');
			$this->redirect('Login/index');
		
		}
	}