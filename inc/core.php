<?php

	if (!defined('STOIC_CORE_PATH')) {
		define('STOIC_CORE_PATH', './');
	}

	require(STOIC_CORE_PATH . 'vendor/autoload.php');

	use AndyM84\Config\ConfigContainer;
	use AndyM84\Config\Migrator;

	use Stoic\Utilities\ConsoleHelper;
	use Stoic\Utilities\FileHelper;

	global $Cfg, $Ch, $Fh;

	/**
	 * @var ConfigContainer $Cfg
	 * @var ConsoleHelper $Ch
	 * @var FileHelper $Fh
	 */

	$Ch = new ConsoleHelper($argv);
	$Fh = new FileHelper(STOIC_CORE_PATH);

	$Fh->load("~/inc/Constants.php");
	$Fh->load("~/inc/CliScriptHelper.php");

	(new Migrator(STOIC_CORE_PATH . 'migrations/cfg', 'settings.json'))->migrate();
	$Cfg = new ConfigContainer($Fh->getContents('~/settings.json'));
