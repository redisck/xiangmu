<?php
	class LoginAction extends Action{
		public function index(){
			
		}
		//登陆方法
		public function dologin(){
		//dump($_POST);
				$username=$_POST['username'];
				$password=$_POST['password'];
				
				 $m=M('user');
				 $where['username']=$username;
				 $where['password']=md5($password);
				$result=$m->where($where)->select();
				//explode("/",$_SERVER['REQUEST_URI']);
				if($result>0){
					$_SESSION['user']['username']=$username;
					$_SESSION['user']['id']=$result[0]['id'];
					$this->redirect("__APP__/Index/index");
					
				}else{
					echo "<meta charset='utf-8'/>";
					echo "<script>alert('用户名或者密码错误')</script>";
					$this->redirect("__APP__/Index/index");
				}
				 
			}
		//退出
		public function logout(){
			$_SESSION['user']=null;
			//setcookie(session_name(),'',time()-1,'/');
			$this->redirect("__APP__/Index/index");
		}
	
	}
?>