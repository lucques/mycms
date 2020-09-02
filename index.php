<?php
	$start = microtime(true);

	require_once 'autoload.php';

	require_once 'config.php';

	$database = new MySQLDatabase($databaseHost, $databaseUser, $databasePassword, $databaseName, $databaseRelationPrefix);

	unset($databaseHost, $databaseUser, $databasePassword, $databaseName, $databaseRelationPrefix);

	$request = new Request();
	$request->setAttribute('mapping', new MySQLMappingModel($database));

	$frontController = new FrontController();
	$frontController->action($request, new Response());

	echo '<!-- Loaded in ' . round((microtime(true) - $start), 4) . '; ' . $database->getNumberOfQueries() . ' queries -->';

	//for debugging purpose
	function trace()
	{
		$traces = debug_backtrace();

		foreach ($traces as $trace)
		{
			foreach ($trace as $key => $value)
			{
				if (is_object($value))
					continue;

				echo $key . ':';
				print_r($value);
				echo "\n";
			}

			echo "\n";
		}
	}
