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
	 * @param $cfg_i
	 *
	 * @return  string
	 */
	function MakeBackupDir($cfg_i)
	{
		$cfg_site = $this->cfg['Site'][$cfg_i]['database'];

		$real_path = realpath('backups');

		$today = $this->MakeTodayDir($real_path);

		$backup_dir = $real_path . '/' . $today . '/' . $cfg_site;

		$this->PrepareDir($backup_dir);

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

		$this->PrepareDir($full_path);

		return $today_dir;
	}

	/**
	 * PrepareDir
	 *
	 * @param $path
	 *
	 * @return  void
	 */
	function PrepareDir($path)
	{
		if (is_dir($path))
		{
			echo 'The dir ' . $path  . ' is exited.' . PHP_EOL;
		}
		else
		{
			if ($this->cfg['TestMode'] == 1)
			{
				echo 'This will create dir named ' . $path . PHP_EOL;
			}
			else
			{
				mkdir($path);
			}
		}
	}

	/**
	 * SetBackupName
	 *
	 * @param $cfg_i
	 *
	 * @return  string
	 */
	function SetBackupName($cfg_i)
	{
		$cfg_site = $this->cfg['Site'][$cfg_i]['database'];
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
