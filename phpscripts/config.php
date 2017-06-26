<?php
global $config,$db,$user,$g_m,$g_o,$operates,$tpl,$replace;

$config['db'] = array('hostname' => 'localhost',   //数据库主机
					  'datebase' => 'ECADatabase',   //数据库名称
					  'username' => 'root',        //数据库用户名
					  'password' => '',      //数据库密码
					  'charset' => 'utf8',         //数据库字符集
					  'pre' => '',
						'ECA_DB_HOST' => './phpscripts',
						'ESCC'=>'442',
						'EA'=>'',
						'ESCC_EXP_DISP'=>'',
						'EA_EXP_DISP'=>'',
						'ESCC_FILE_PATH'=>'http://10.222.228.167/ECADatabase/ECAData/ESCC/',
						'EA_FILE_PATH'=>'http://10.222.228.167/ECADatabase/ECAData/EA/'
					);           //数据库表前缀
?>
