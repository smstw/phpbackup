<?php
/**
 * Created by PhpStorm.
 * User: michael520
 * Date: 2014/2/26
 * Time: 下午3:08
 */
include('config.php');

$today = date('YmdHis');

$real_path = realpath('backups');

$backup_dir = $real_path . '/' . $today;

$backup_sql_name = $backup_dir . '/'  . $mysql_backup_name;

$mysqldump_cmd = $mysqldump_locate . ' -u'. $mysql_username .' -p' . $mysql_passwd . ' --all-databases > ' . $backup_sql_name;

if(is_dir($backup_dir))
{
	echo 'The dir' . $backup_dir  . 'is exited' . PHP_EOL;
}
else
{
	if($test_mode == 1)
	{
		echo 'This will create dir named ' . $backup_dir . PHP_EOL;
		echo 'The shell string is '. $mysqldump_cmd . PHP_EOL;
	}
	else
	{
		mkdir($backup_dir);
		system($mysqldump_cmd);
	}
}