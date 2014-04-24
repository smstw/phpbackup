<?php
/**
 * Created by PhpStorm.
 * User: michael520
 * Date: 2014/2/26
 * Time: 下午3:08
 */
include('config.php');

// Register autoload function
spl_autoload_register(
	function($class)
	{
		require __DIR__ . '/lib/' . $class . '.php';
	}
);

$app = new SqlBackupApplications($cfg);

foreach ($cfg['Site'] as $i => $param)
{
	$backupDir = $app->makeBackupDir($i);

	$backupSqlName = $app->setBackupName($i);

	$dist = $backupDir . '/' . $backupSqlName;

	$app->dumpingSQL($i, $dist);
}
