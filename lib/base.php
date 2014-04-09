<?php

/**
 * Class SqlBackupApplications
 *
 * @since 1.0
 */
class SqlBackupApplications
{
	/**
	 * Property cfg.
	 *
	 * @var  null
	 */
	public $cfg;

	/**
	 * @param null $cfg
	 */
	public function __construct($cfg = null)
	{
		$this->cfg = $cfg;
	}

	/**
	 * MakeBackupDir
	 *
	 * @param $cfg_site
	 *
	 * @return  string
	 */
	function MakeBackupDir($cfg_site)
	{
		$real_path = realpath('backups');

		$today = $this->MakeTodayDir($real_path);

		$backup_dir = $real_path . '/' . $today . '/' . $cfg_site;

		if (is_dir($backup_dir))
		{
			echo 'The dir' . $backup_dir  . ' is exited' . PHP_EOL;
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

	/**
	 * MakeTodayDir
	 *
	 * @param $real_path
	 *
	 * @return  bool|string
	 */
	function MakeTodayDir($real_path)
	{
		$today_dir = date('Ymd');

		$full_path = $real_path . '/' . $today_dir;

		if (is_dir($full_path))
		{
			echo 'The dir' . $full_path  . ' is exited' . PHP_EOL;
		}
		else
		{
			if ($this->cfg['TestMode'] == 1)
			{
				echo 'This will create dir named ' . $full_path . PHP_EOL;
			}
			else
			{
				mkdir($full_path);
			}
		}

		return $today_dir;
	}

	/**
	 * SetBackupName
	 *
	 * @param $cfg_site
	 *
	 * @return  string
	 */
	function SetBackupName($cfg_site)
	{
		$serial = date('YmdHis');
		$backup_sql_name = $cfg_site . '-' . $serial .'.sql';

		return $backup_sql_name;
	}

	/**
	 * DumpingSQL
	 *
	 * @param $cfg_i
	 * @param $DistFile
	 *
	 * @return  void
	 */
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

	/**
	 * del_expire_file
	 *
	 * @param $expire_day
	 *
	 * @return  void
	 */
	function del_expire_file($expire_day)
	{
		echo $expire_day;
	}
}

