<?php
/**
 * Created by PhpStorm.
 * User: michael520
 * Date: 2014/2/26
 * Time: 下午3:08
 */
include('config.php');

foreach (glob("lib/*.php") as $filename)
{
	include $filename;
}

$app = new SqlBackupApplications($cfg);

foreach ($cfg['Site'] as $i => $param)
{
	$backup_dir = $app->MakeBackupDir($i);

	$backup_sql_name = $app->SetBackupName($i);

	$dist = $backup_dir . '/' . $backup_sql_name;

	$app->DumpingSQL($i,$dist);
}
