<?php
	return array(
		'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => 'localhost', // 服务器地址
        'DB_NAME'   => 'qd_project', // 数据库名
        'DB_USER'   => 'root', // 用户名
        'DB_PWD'    => '123', // 密码
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => 'qd_', // 数据库表前缀 
		'TMPL_L_DELIM'=>'<{',
		'TMPL_R_DELIM'=>'}>',
		
		//网站管理
			//上传商品图片路径
			'Goods_image_path'=>'Public/uploads/Goods_images',
			//上传广告图片路径
			'Ad_image_path'=>'Public/uploads/Ad_images',
			//一个广告缩略路径
			'Ad_image_common'=>'common',
			//三个缩略图路径
			'Goods_image_common'=>'common',
			'Goods_image_big'=>'big',
			'Goods_image_middle'=>'middle',
			'Goods_image_small'=>'small',
			//广告图片路径
			//'Ad_image_path'=>'Public/uploads/Ad_images',
			//最大上传大小
			'Goods_image_max'=>'3145728',
			//允许上传的类型
			'allowExts'=>array('jpg', 'gif', 'png', 'jpeg'),
			//广告位置名称
			'ad_position'=>array('首页顶部','首页底部','图书页顶部','图书页底部'),
			//big缩略图宽高
			'Goods_big_width'=>'130px',
			'Goods_big_height'=>'160px',
			//middle缩略图宽高
			'Goods_middle_width'=>'70px',
			'Goods_middle_height'=>'90px',
			//small缩略图宽高
			'Goods_small_width'=>'45px',
			'Goods_small_height'=>'55px',
			//'SHOW_PAGE_TRACE'=>true,//开启页面Trace
	);