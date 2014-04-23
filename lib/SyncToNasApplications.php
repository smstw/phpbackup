<?php
/**
 * Part of phpbackup project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class SyncToNasApplications
 *
 * @since 1.0
 */
class SyncToNasApplications
{
	public $config;

	public function __construct($config = null)
	{
		$this->config = $config;
	}

	public function startSync($index)
	{
		$syncCmd = 'rsync -av';
		$syncSource = $this->config['Storage'][$index]['SourcePath'];
		$syncSSH = '-e ssh';
		$syncSSHUser = $this->config['Storage'][$index]['User'];
		$syncHOST = $this->config['Storage'][$index]['HostAdd'];
		$syncDist = $this->config['Storage'][$index]['DistPath'];

		$cmd = sprintf('%s %s %s %s@%s:%s', $syncCmd, $syncSource, $syncSSH, $syncSSHUser, $syncHOST, $syncDist);

		if ($this->config['TestMode'] == 1)
		{
			echo 'the shell will be : ' . $cmd . PHP_EOL;
		}
		else
		{
			system($cmd);
		}

		return true;
	}
}
 