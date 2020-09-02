<?php
	function __autoload($class)
	{
		$directory = 'library';

		if (substr($class, strlen($class) - 10) == 'Controller')
			$directory .= '/controllers';
		else if (substr($class, strlen($class) - 9) == 'Exception')
			$directory .= '/exceptions';
		else if (substr($class, strlen($class) - 5) == 'Model')
			$directory .= '/models';
		else if (substr($class, 0, 5) == 'MySQL' || $class == 'AbstractMySQLMapper')
			$directory .= '/models/mappers/mysql';
		else if (substr($class, strlen($class) - 9) == 'Criterion')
			$directory .= '/models/mappers/mysql/criteria';
		else if (substr($class, strlen($class) - 6) == 'Mapper')
			$directory .= '/models/mappers';
		else if (substr($class, strlen($class) - 8) == 'Modifier')
			$directory .= '/modifiers';
		else if (substr($class, strlen($class) - 9) == 'Validator')
			$directory .= '/validators';

		require_once $directory . '/' . $class . '.php';
	}
