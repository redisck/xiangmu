<?php
	class ConfigAction extends CommonAction{
		public function index(){
			$os = explode(' ' , php_uname());
			$mysql_support = (function_exists('mysql_close')) ? 
				'<font color="green">√</font>' : '<font color="red">×</font>';
			$register_globals = get_cfg_var("register_globals") ? 
				'<font color="green">√</font>' : '<font color="red">×</font>';
			$enable_dl = get_cfg_var("enable_dl") ? 
				'<font color="green">√</font>' : '<font color="red">×</font>';
			$allow_url_fopen = get_cfg_var("allow_url_fopen") ? 
				'<font color="green">√</font>' : '<font color="red">×</font>';
			$display_errors = get_cfg_var("display_errors") ? 
				'<font color="green">√</font>' : '<font color="red">×</font>';
			$session_support = (function_exists('session_start')) ? 
				'<font color="green">√</font>' : '<font color="red">×</font>';
				
			$config['server_name'] 		   = $_SERVER['SERVER_NAME'];
			$config['server_ip']   		   = @gethostbyname($_SERVER['SERVER_NAME']);
			$config['server_time'] 		   = date("Y年n月j日 H:i:s");
			$config['os']          		   = $os[0];
			$config['os_core']     		   = $os[2];
			$config['server_root'] 		   = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
			$config['server_engine'] 	   = $_SERVER['SERVER_SOFTWARE'];
			$config['server_port'] 		   = $_SERVER['SERVER_PORT'];
			$config['php_version'] 		   = PHP_VERSION;
			$config['php_run_type'] 	   = strtoupper(php_sapi_name());
			$config['mysql_support'] 	   = $mysql_support;
			$config['register_globals']    = $register_globals;
			$config['allow_url_fopen']     = $allow_url_fopen;
			$config['display_errors']  	   = $display_errors;
			$config['enable_dl']		   = $enable_dl;
			$config['memory_limit']        = get_cfg_var("memory_limit");
			$config['post_max_size']       = get_cfg_var("post_max_size");
			$config['upload_max_filesize'] = get_cfg_var("upload_max_filesize");
			$config['max_execution_time']  = get_cfg_var("max_execution_time");
			$config['session_support'] 	   = $session_support;
			$this -> config_arr = $config;
			$this->display();
		}
	}