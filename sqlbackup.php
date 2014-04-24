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

$dump = new SqlBackupApplication($cfg);

$dir = new BackupDirApplication($cfg);

foreach ($cfg['Site'] as $i => $param)
{
	$backupDir = $dir->makeBackupDir($i);

	$backupSqlName = $dump->setBackupSqlName($i);

	$dist = $backupDir . '/' . $backupSqlName;

	$dump->dumpingSQL($i, $dist);
}
