<?php
/* return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING' => array('__PUBLIC__' => __ROOT__.'/'.APP_NAME.'/Tpl/Public'),
); */
	$common_config=require './config.php';
	$admin_config=array(
		'TMPL_PARSE_STRING' => array('__PUBLIC__' => __ROOT__.'/'.APP_NAME.'/Tpl/Public'),
	);
	return array_merge($common_config,$admin_config);
?>