<?php
	// There are two ways to configure the database connection:
	// 1) Set environment variables (e.g. comfortable to set up using docker-compose)
	// 2) Hard-code the variables in this file

	if (isset($_ENV['MYCMS_DB_HOST']) &&
	    isset($_ENV['MYCMS_DB_USER']) &&
	    isset($_ENV['MYCMS_DB_PASSWORD']) &&
	    isset($_ENV['MYCMS_DB_NAME']) &&
	    isset($_ENV['MYCMS_DB_RELATION_PREFIX'])) {
		$databaseHost = $_ENV['MYCMS_DB_HOST'];
		$databaseUser = $_ENV['MYCMS_DB_USER'];
		$databasePassword = $_ENV['MYCMS_DB_PASSWORD'];
		$databaseName = $_ENV['MYCMS_DB_NAME'];
		$databaseRelationPrefix = $_ENV['MYCMS_DB_RELATION_PREFIX'];
	}
	else {
		$databaseHost = 'db';
		$databaseUser = 'root';
		$databasePassword = 'rutus';
		$databaseName = 'mycms_db';
		$databaseRelationPrefix = 'mycms_';
	}


	date_default_timezone_set('UTC')
?>
