<?php

class SqlBackupApplications
{
	public $cfg;

	public function __construct($cfg = null)
	{
		$this->cfg = $cfg;
	}

	function MakeBackupDir($cfg_site)
	{
		$today = date('Ymd');

		$real_path = realpath('backups');

		$backup_dir = $real_path . '/' . $today . '/' . $cfg_site;

		if (is_dir($backup_dir))
		{
			echo 'The dir' . $backup_dir  . 'is exited' . PHP_EOL;
		}
		else
		{
			if ($this->cfg['TestMode'] == 1)
			{
				echo 'This will create dir named ' . $backup_dir . PHP_EOL;
			}
		else
		{
			mkdir($backup_dir);
		}
}
		return $backup_dir;
	}

	function SetBackupName($cfg_site)
	{
		$backup_sql_name = $cfg_site .'.sql';

		return $backup_sql_name;
	}

	function DumpingSQL($cfg_i,$DistFile)
	{
		$cmd = $this->cfg['MysqlDump_locate'] . ' -u'. $this->cfg['Site'][$cfg_i]['user'] .' -p' . $this->cfg['Site'][$cfg_i]['password'] . ' ' . $this->cfg['Site'][$cfg_i]['database'] . ' > ' . $DistFile;

		if ($this->cfg['TestMode'] == 1)
		{
			echo 'the shell will be : ' . $cmd . PHP_EOL;
		}
		else
		{
			system($cmd);
		}
	}

	function del_expire_file($expire_day)
	{
		echo $expire_day;
	}
}
