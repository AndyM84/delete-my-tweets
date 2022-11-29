<?php

	require('./inc/core.php');

	use DG\Twitter\Twitter;
	use Zibings\CliScriptHelper;

	global $Cfg, $Ch, $Fh;

	$script = (new CliScriptHelper(
		"Tweetus Deleetus",
		"Script to delete tweets by their ID's"
	))->addExample(<<< EXAMPLE_TEXT
- Run script with default values:

  php deleter.php
EXAMPLE_TEXT)->addExample(<<< EXAMPLE_TEXT
- Run script with custom ID file:

  php deleter.php -f myIds.txt
EXAMPLE_TEXT)->addOption(
	'file',
	'f',
	'file',
	"File containing tweet ID's to delete",
	"File containing tweet ID's to delete, one per line",
	false,
	'tweetIds.txt');

	$script->startScript($Ch);
	$opts = $script->getOptions($Ch);

	if ($Cfg->get(ConfigStrings::ACCESS_SECRET, '<changeme>') == '<changeme>') {
		$Ch->putLine("Invalid configuration, please update the values inside your `settings.json` file");

		exit;
	}

	if (!$Fh->fileExists($opts['file'])) {
		$Ch->putLine("Invalid ID file, check path and run script again");

		exit;
	}

	$file = fopen($opts['file'], 'r');

	if (!$file) {
		$Ch->putLine("Failed to open fID file, check file and run script again");

		exit;
	}

	$Ch->putLine("Preparing to delete tweets.. ");
	$Ch->putLine();

	try {
		$twitter = new Twitter(
			$Cfg->get(ConfigStrings::CONSUMER_KEY, ''),
			$Cfg->get(ConfigStrings::CONSUMER_SECRET, ''),
			$Cfg->get(ConfigStrings::ACCESS_TOKEN, ''),
			$Cfg->get(ConfigStrings::ACCESS_SECRET, '')
		);

		while (($row = fgetcsv($file)) !== false) {
			$Ch->put("Deleting {$row[0]}.. ");
			$res = $twitter->request("https://api.twitter.com/2/tweets/{$row[0]}", 'DELETE');

			if ($res->data && $res->data->deleted !== null) {
				$Ch->putLine($res->data->deleted ? 'DONE' : 'ERROR');
			} else {
				$Ch->putLine('FAILED');
			}

			sleep(19);
		}
	} catch (DG\Twitter\Exception $ex) {
		$Ch->putLine("Error while processing: " . $ex->getMessage());

		exit;
	}

	$Ch->putLine();
	$Ch->putLine("Tweets deleted.");
