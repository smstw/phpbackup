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
	$backupDir = $app->makeBackupDir($i);

	$backupSqlName = $app->setBackupName($i);

	$dist = $backupDir . '/' . $backupSqlName;

	$app->dumpingSQL($i, $dist);
}
