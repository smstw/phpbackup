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
	public $config;

	/**
	 * @param null $config
	 */
	public function __construct($config = null)
	{
		$this->config = $config;
	}

	/**
	 * makeBackupDir
	 *
	 * @param integer $index
	 *
	 * @return string
	 */
	public function makeBackupDir($index)
	{
		$cfgSite = $this->config['Site'][$index]['DataBase'];

		$realPath = realpath('backups');

		$today = $this->makeTodayDir($realPath);

		$backupDir = $realPath . '/' . $today . '/' . $cfgSite;

		$this->prepareDir($backupDir);

		return $backupDir;
	}

	/**
	 * makeTodayDir
	 *
	 * @param $realPath
	 *
	 * @return bool|string
	 */
	public function makeTodayDir($realPath)
	{
		$todayDir = date('Ymd');

		$fullPath = $realPath . '/' . $todayDir;

		$this->prepareDir($fullPath);

		return $todayDir;
	}

	/**
	 * prepareDir
	 *
	 * @param string $path
	 *
	 * @return void
	 */
	public function prepareDir($path)
	{
		if (is_dir($path))
		{
			echo 'The dir ' . $path  . ' is exited.' . PHP_EOL;
		}
		else
		{
			if ($this->config['TestMode'] == 1)
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
	 * setBackupName
	 *
	 * @param integer $index
	 *
	 * @return string
	 */
	public function setBackupName($index)
	{
		$cfgSite = $this->config['Site'][$index]['DataBase'];
		$serial = date('YmdHis');
		$backupSqlName = $cfgSite . '-' . $serial .'.sql';

		return $backupSqlName;
	}

	/**
	 * dumpingSQL
	 *
	 * @param integer $index
	 * @param string $distFile
	 *
	 * @return  void
	 */
	public function dumpingSQL($index,$distFile)
	{
		$dumpCmd = $this->config['MysqlDumpCMDPath'];
		$mysqlUser = $this->config['Site'][$index]['User'];
		$mysqlPassWord = $this->config['Site'][$index]['PassWord'];
		$mysqlDataBase = $this->config['Site'][$index]['DataBase'];
		$dumpBackupPath = $distFile;

		$cmd = sprintf('%s -u%s -p%s %s > %s', $dumpCmd, $mysqlUser, $mysqlPassWord, $mysqlDataBase, $dumpBackupPath);

		if ($this->config['TestMode'] == 1)
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
	public function del_expire_file($expire_day)
	{
		echo $expire_day;
	}
}
