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

		$realPath = $this->config['BackupPath'];

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
	 * setTarBallName
	 *
	 * @param integer $index
	 *
	 * @return  string
	 */
	public function setTarBallName($index)
	{
		$siteName = $this->config['Site'][$index]['SiteName'];
		$serial = date('YmdHis');
		$TarBallName = $siteName . '-' . $serial .'.tar.gz';

		return $TarBallName;
	}

	public function doTarFile($dest,$index)
	{
		$tarCMD = 'tar zcf';
		$tarDest = $dest;
		$tarSources = '';

		$getConfigMediaDirs = $this->config['Site'][$index]['MediaDirs'];
		$getConfigSitePath = $this->config['Site'][$index]['SitePath'];

		$mediaDirs = explode(',', $getConfigMediaDirs);

		foreach ($mediaDirs as $dir)
		{
			$tarSources .= ' ' . $getConfigSitePath . '/' . $dir ;
		}

		echo 'tar source :' . $tarSources . PHP_EOL;
		$cmd = sprintf('%s %s %s',$tarCMD ,$tarDest, $tarSources);

		if ($this->config['TestMode'] == 1)
		{
			echo 'This command will be : ' . $cmd . PHP_EOL;
		}
		else
		{
			system($cmd);
		}
	}

	/**
	 * DoExpires
	 *
	 * @param integer $index
	 *
	 * @return  void
	 */
	public function DoExpires($index)
	{
		$sshCmd = 'ssh';
		$sshUser = $this->config['Storage'][$index]['User'];
		$sshHost = $this->config['Storage'][$index]['HostAdd'];
		$rmCmd = 'rm -rf';
		$rmDirName = $this->explodePath($this->config['BackupPath']);
		$rmDestPath = $this->config['Storage'][$index]['DestPath'];
		$daysToExpire = mktime(0, 0, 0, date('m'), (date('d') - $this->config['DayToExpire']), date('Y'));

		$expireDir = date('Ymd', $daysToExpire);

		$rmFullDestPath = $rmDestPath . '/' . $rmDirName . '/' . $expireDir;

		$cmd = sprintf('%s %s@%s %s %s', $sshCmd, $sshUser, $sshHost, $rmCmd, $rmFullDestPath);

		echo 'The expire files is' . $rmFullDestPath . PHP_EOL;

		system($cmd);

	}

	/**
	 * doLocalExpires
	 *
	 * @param integer $index
	 *
	 * @return  void
	 */
	public function doLocalExpires($index)
	{
		$rmCmd = 'rm -rf';

		$rmDirName = $this->explodePath($this->config['Remote'][$index]['Source']);
		$rmPath = $this->config['BackupDest'] . '/' . $rmDirName;

		$daysToExpire = mktime(0, 0, 0, date('m'), (date('d') - $this->config['DayToExpire']), date('Y'));

		$expireDir = date('Ymd', $daysToExpire);

		$fullPath = $rmPath . '/' . $expireDir;

		$cmd = sprintf('%s %s', $rmCmd, $fullPath);

		echo 'The expire files is' . $fullPath . PHP_EOL;

		system($cmd);

	}

	/**
	 * explodePath
	 *
	 * @param string $path
	 *
	 * @return  mixed
	 */
	public function explodePath($path)
	{
		$peaces= explode('/', $path);
		$totalPeace = count($peaces);
		$lastPeace = $totalPeace - 1;
		$directoryName = $peaces[$lastPeace];

		return $directoryName;
	}
}
