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
}
 