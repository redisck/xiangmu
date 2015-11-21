<?php
	class RBACModel extends Model{
		public function node_list(){
			 $node=M('Node')->where('pid=0')->select();
			 foreach($node as $key=>$v){
				$node_child=M('Node')->where("pid={$v['id']}")->select();
				$node[$key]['child']=$node_child;
			}
			return $node; 
			
		}
	
	}