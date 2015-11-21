<?php
	class CommentAction extends Action{
		public function index(){
			//显示评价列表
			
			
			import('ORG.Util.Page'); 
			$c=M("comment");
			$count=$c->count();

			$page=new Page($count,10);
			$show=$page->show();
			$comment=M("comment");
			$comments=$comment->limit($page->firstRow.','.$page->listRows)->select();
			$u=M("user");
			$g=M('goods');
			foreach($comments as $key=>$val){
				$username=$u->where("id={$val['user_id']}")->getField("username");
				$comments[$key]['username']=$username;
				$goodsname=$g->where("id={$val['goods_id']}")->getField("name");
				$comments[$key]['goodsname']=$goodsname;
				$time=date("Y-m-d m:i:s",$val['time']);
				$comments[$key]['time']=$time;
			}
			//dump($comments);
			$this->assign('page',$show);
			$this->assign("comments",$comments);
			$this->display();
		}
		
		//删除评论
		public function delete(){
			$id=$_POST['id'];
			$c=M("comment");
			$res=$c->where("id={$id}")->delete();
			if($res){
				echo 1;
			}else{
				echo 0;
			}
		}
		
	
	
	}
	
	
	
	