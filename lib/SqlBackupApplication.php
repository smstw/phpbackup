<?php

/**
 * Class SqlBackupApplication
 *
 * @since 1.0
 */
class SqlBackupApplication
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
	 * setBackupSqlName
	 *
	 * @param integer $index
	 *
	 * @return string
	 */
	public function setBackupSqlName($index)
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
}
