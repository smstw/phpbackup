<?php
/**
 * Part of phpbackup project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class SyncToStorageApplication
 *
 * @since 1.0
 */
class SyncToStorageApplication
{
	public $config;

	public function __construct($config = null)
	{
		$this->config = $config;
	}

	/**
	 * startSync
	 *
	 * @param integer $index
	 *
	 * @return  bool
	 */
	public function startSync($index)
	{
		$syncCmd = 'rsync -avl';
		$syncSource = $this->config['BackupPath'];
		$syncSSH = '-e ssh';
		$syncSSHUser = $this->config['Storage'][$index]['User'];
		$syncHOST = $this->config['Storage'][$index]['HostAdd'];
		$syncDest = $this->config['Storage'][$index]['DestPath'];

		$cmd = sprintf('%s %s %s %s@%s:%s', $syncCmd, $syncSource, $syncSSH, $syncSSHUser, $syncHOST, $syncDest);

		if ($this->config['TestMode'] == 1)
		{
			$syncCmd = 'rsync --dry-run -avl';
			$cmd = sprintf('%s %s %s %s@%s:%s', $syncCmd, $syncSource, $syncSSH, $syncSSHUser, $syncHOST, $syncDest);
			echo 'the shell will be : ' . $cmd . PHP_EOL;
			echo 'Dry run to test .... ' . PHP_EOL;
			system($cmd);
		}
		else
		{
			system($cmd);
		}

		return true;
	}

	/**
	 * delBackupsAfterSync
	 *
	 * @return  void
	 */
	public function delBackupsAfterSync()
	{
		$rmCMD = 'rm -rf';
		$rmDirPath = $this->config['BackupPath'];

		if ($this->config['DelFilesAfterSync'] == 1)
		{
			$cmd = sprintf('%s %s/*', $rmCMD, $rmDirPath);
			system($cmd);

			echo sprintf('The backup : %s have deleted after sync .', $rmDirPath) . PHP_EOL;
		}
		else
		{
			echo sprintf('The backup : %s is not delete after sync .', $rmDirPath) . PHP_EOL;
		}
	}

	/**
	 * delRemoteBackupsAfterSync
	 *
	 * @param integer $index
	 *
	 * @return  void
	 */
	public function delRemoteBackupsAfterSync($index)
	{
		$rmCMD = 'rm -rf';
		$rmDirPath = $this->config['Remote'][$index]['Source'];
		$sshCMD = 'ssh';
		$remoteUser = $this->config['Remote'][$index]['User'];
		$remoteHost = $this->config['Remote'][$index]['HostAdd'];

		if ($this->config['DelFilesAfterSync'] == 1)
		{
			$cmd = sprintf('%s %s@%s %s %s/*', $sshCMD, $remoteUser, $remoteHost, $rmCMD, $rmDirPath);

			system($cmd);

			echo sprintf('The backup : %s have deleted after sync.', $rmDirPath) . PHP_EOL;
		}
		else
		{
			echo sprintf('The backup : %s is not delete after sync.', $rmDirPath) . PHP_EOL;
		}
 }

	/**
	 * syncFromRemote
	 *
	 * @param integer $index
	 *
	 * @return  void
	 */
	public function syncFromRemote($index)
	{
		$rsyncCmd = 'rsync -av';
		$localDest = $this->config['BackupDest'];
		$syncSSH = '-e ssh';
		$remoteUser = $this->config['Remote'][$index]['User'];
		$remoteHOST = $this->config['Remote'][$index]['HostAdd'];
		$remoteSource = $this->config['Remote'][$index]['Source'];

		$remote = sprintf('%s@%s:%s', $remoteUser, $remoteHOST, $remoteSource);
		$local = sprintf('%s', $localDest);

		$cmd = sprintf('%s %s %s %s', $rsyncCmd, $syncSSH, $remote, $local);

		if ($this->config['TestMode'] == 1)
		{
			$rsyncCmd = 'rsync --dry-run -avl';
			$cmd = sprintf('%s %s %s %s', $rsyncCmd, $syncSSH, $remote, $local);
			echo 'the shell will be : ' . $cmd . PHP_EOL;
			echo 'Dry run to test .... ' . PHP_EOL;
			system($cmd);
		}
		else
		{
			echo 'the shell will be : ' . $cmd . PHP_EOL;
			system($cmd);
		}
	}
}
