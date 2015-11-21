<?php
	function thumb_images($pic){
	
		$array_dir=explode('/',$pic);
		$date_dir=$array_dir[3];
		$image_name=$array_dir[5];
		//组装缩略图路径
		$big=C('Goods_image_path').'/'.$date_dir.'/big/b_'.$image_name;
		$middle=C('Goods_image_path').'/'.$date_dir.'/middle/m_'.$image_name;
		$small=C('Goods_image_path').'/'.$date_dir.'/small/s_'.$image_name;
		import("ORG.Util.Image");
		Image::thumb($pic,$big,'',C('Goods_big_width'),C('Goods_big_height'));
		Image::thumb($pic,$middle,'',C('Goods_middle_width'),C('Goods_middle_width'));
		Image::thumb($pic,$small,'',C('Goods_small_width'),C('Goods_small_width'));
	}
	 function truncate($str , $len = 15 , $fill = '...' , $start = 0 , $charset = 'UTF-8') { 
		// return $str;
		$res = mb_substr($str , $start , $len , $charset);
		if($res == $str)
			return $res;
		return $res.$fill;
	}