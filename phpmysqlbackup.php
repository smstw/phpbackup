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

$backup_dir = $app->MakeBackupDir($cfg['Site'][1]['database']);

$backup_sql_name = $app->SetBackupName($cfg['Site'][1]['database']);

$dist = $backup_dir . '/' . $backup_sql_name;

$app->DumpingSQL(1,$dist);

