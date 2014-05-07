<?php
/**
 * Do things for commands.
 */

// Auto load and register classes
spl_autoload_register(
	function($class)
	{
		require __DIR__ . '/lib/' . $class . '.php';
	}
);

include('config.php');

/**
 * sqlBackup
 *
 * @param string $cfg
 *
 * @return  void
 */
function sqlBackup($cfg)
{
	$dump = new SqlBackupApplication($cfg);
	$dir = new BackupDirApplication($cfg);

	foreach ($cfg['Site'] as $i => $param)
	{
		$backupDir = $dir->makeBackupDir($i);

		$backupSqlName = $dump->setBackupSqlName($i);

		$dist = $backupDir . '/' . $backupSqlName;

		$dump->dumpingSQL($i, $dist);
	}
}

/**
 * mediaBackup
 *
 * @param string $cfg
 *
 * @return  void
 */
function mediaBackup($cfg)
{
	$dir = new BackupDirApplication($cfg);

	foreach ($cfg['Site'] as $i => $param)
	{
		$backupDir = $dir->makeBackupDir($i);

		$backupName = $dir->setTarBallName($i);

		$dest = $backupDir . '/' . $backupName;

		$dir->doTarFile($dest,$i);

	}
}

/**
 * syncToStorage
 *
 * @param string $cfg
 *
 * @return  void
 */
function syncToStorage($cfg)
{
	$storage = new SyncToStorageApplication($cfg);

	foreach ($cfg['Storage'] as $i => $param)
	{
		$storage->startSync($i);
	}

	$storage->delBackupsAfterSync();
}

/**
 * delExpireFiles
 *
 * @param string $cfg
 *
 * @return  void
 */
function delExpireFiles($cfg)
{
	$expire = new BackupDirApplication($cfg);
	foreach ($cfg['Storage'] as $i => $param)
	{
		$expire->DoExpires($i);
	}

}

/**
 * delExpiresOnLocal
 *
 * @param string $cfg
 *
 * @return  void
 */
function delExpiresOnLocal($cfg)
{
	$expire = new BackupDirApplication($cfg);
	$expire->doLocalExpires();
}

/**
 * delRemoteFiles
 *
 * @param string $cfg
 *
 * @return  void
 */
function delRemoteFiles($cfg)
{
	$del = new SyncToStorageApplication($cfg);
	foreach ($cfg['Remote'] as $i => $param)
	{
		$del->delRemoteBackupsAfterSync($i);
	}
}

/**
 * syncRemote
 *
 * @param string $cfg
 *
 * @return  void
 */
function syncRemote($cfg)
{
	$remote = new SyncToStorageApplication($cfg);
	foreach ($cfg['Remote'] as $i => $param)
	{
		$remote->syncFromRemote($i);
	}
}
// Execute command to do things.
if ($argc !== 2)
{
	showUsage();
	exit;
}

$command = $argv[1];

switch ($command)
{
	case 'sqldump':

		sqlBackup($cfg);

	break;

	case 'syncfiles':

		syncToStorage($cfg);

	break;

	case 'tarmedias':

		mediaBackup($cfg);

	break;

	case 'dobackup':
		sqlBackup($cfg);
		mediaBackup($cfg);
		break;

	case 'doexpires':

		delExpireFiles($cfg);

	break;

	case 'syncremote':
		syncRemote($cfg);
		delRemoteFiles($cfg);
		delExpiresOnLocal($cfg);
		break;

	default:
		echo 'Command not found.' . PHP_EOL;
		showUsage();
}

/**
 * showUsage
 *
 * @return  void
 */
function showUsage()
{
	echo 'Usage :' . PHP_EOL;
	echo 'To dump sqls type : php console.php sqldump.' . PHP_EOL;
	echo 'To sync sqls files type : php console.php syncfiles.' . PHP_EOL;
	echo 'To tar medias type : php console.php tarmedias.' . PHP_EOL;
	echo 'To do sync from remote type : php console.php syncremote.' . PHP_EOL;
	echo 'To do dump sqls, tar medias and sync files of all things type : php console.php doall.' . PHP_EOL;
}
