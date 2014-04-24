<?php

/**
 * Class SqlBackupApplications
 *
 * @since 1.0
 */
class BackupDirApplication
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
	 * deleteExpireFile
	 *
	 * @return  void
	 */
	public function deleteExpireFile()
	{
		// Planing how to delete expires.
		echo $this->config['DayToExpire'];
	}
}
