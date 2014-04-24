<?php
/**
 * Part of phpbackup project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

include('config.php');

foreach (glob("lib/*.php") as $filename)
{
	include $filename;
}
$nas = new SyncToStorageApplications($cfg);

foreach ($cfg['Storage'] as $i => $param)
{
	$nas->startSync($i);
}
