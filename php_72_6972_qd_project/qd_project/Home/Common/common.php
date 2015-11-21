<?php
	function get_classify_image(){
		return array('icon_book.gif','zb16.gif','sc_icon.png','lotto.gif','goods.gif');
	}
	function get_classify_path(){
		return array('__APP__/Book/index','__APP__/Plaything/index','javascript:void(0)','javascript:void(0)','javascript:void(0)');
	}
	 function truncate($str , $len = 6 , $fill = '...' , $start = 0 , $charset = 'UTF-8') { 
		// return $str;
		$res = mb_substr($str , $start , $len , $charset);
		if($res == $str)
			return $res;
		return $res.$fill;
	}