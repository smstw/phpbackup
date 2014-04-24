<?php

if ($argc !== 2)
{
	showUsage();
	exit;
}

$command = $argv[1];

switch ($command)
{
	case 'sqldump':

		include 'sqlbackup.php';

	break;

	case 'syncfiles':

		include 'sync_to_storage.php';

	break;

	default :

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
}
