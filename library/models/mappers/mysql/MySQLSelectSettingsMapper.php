<?php
	/**
	 * This class implements the SelectSettingsMapper interface for a MySQL database.
	 */
	class MySQLSelectSettingsMapper extends AbstractMySQLMapper implements SelectSettingsMapper
	{
		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);
		}

		public function map()
		{
			$settings = new Map();

			$sql  = 'SELECT ';
			$sql .=   'name, ';
			$sql .=   'value ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('settings') . ' ';
			$sql .= 'ORDER BY ';
			$sql .=   'name';

			$iterator = $this->database->query($sql);

			while ($iterator->hasNext())
			{
				$tuple = $iterator->next();

				$settings->put($tuple['name'], $tuple['value']);
			}

			return $settings;
		}
	}
