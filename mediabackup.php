<?php
/**
 * Backup files and compress a tarball
 */

include('config.php');

// Register autoload function
spl_autoload_register(
	function($class)
	{
		require __DIR__ . '/lib/' . $class . '.php';
	}
);

$dir = new BackupDirApplication($cfg);

foreach ($cfg['Site'] as $i => $param)
{
	$backupDir = $dir->makeBackupDir($i);

	$backupName = $dir->setTarBallName($i);

	$dest = $backupDir . '/' . $backupName;

	$dir->doTarFile($dest);

}
