<?php
	class CommonAction extends Action{
		public function init(){
			if(!$_SESSION['admin']){
				$this->redirect('Login/index');
			}
			if($_GET['_URL_'][0]=='Classify' && $_GET['_URL_'][1]=='index' && !in_array(2,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Classify' && $_GET['_URL_'][1]=='add' && !in_array(3,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Classify' && $_GET['_URL_'][1]=='edit' && !in_array(4,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Classify' && $_GET['_URL_'][1]=='delete' && !in_array(5,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='book' && !in_array(7,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='addBook' && !in_array(8,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='deleteBook' && !in_array(9,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='editBook' && !in_array(10,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='plaything' && !in_array(11,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='addPlaything' && !in_array(12,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='editPlaything' && !in_array(13,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Goods' && $_GET['_URL_'][1]=='recover' && !in_array(14,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='RBAC' && $_GET['_URL_'][1]=='index' && !in_array(16,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='RBAC' && $_GET['_URL_'][1]=='doAddAdmin' && !in_array(17,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='RBAC' && $_GET['_URL_'][1]=='doEdit' && !in_array(18,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='RBAC' && $_GET['_URL_'][1]=='role' && !in_array(19,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='RBAC' && $_GET['_URL_'][1]=='doAddRole' && !in_array(20,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Comment' && $_GET['_URL_'][1]=='index' && !in_array(22,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Comment' && $_GET['_URL_'][1]=='delete' && !in_array(23,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Order' && $_GET['_URL_'][1]=='index' && !in_array(25,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Order' && $_GET['_URL_'][1]=='changestatus' && !in_array(26,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Ad' && $_GET['_URL_'][1]=='index' && !in_array(28,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Ad' && $_GET['_URL_'][1]=='add' && !in_array(29,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
			if($_GET['_URL_'][0]=='Ad' && $_GET['_URL_'][1]=='edit' && !in_array(30,$_SESSION['admin']['nodes'])){
				$this->error('你没有权限');
			}
		}
	}