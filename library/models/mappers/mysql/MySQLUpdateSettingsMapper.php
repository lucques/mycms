<?php
	/**
	 * This class implements the UpdateSettingsMapper interface for a MySQL database.
	 */
	class MySQLUpdateSettingsMapper extends AbstractMySQLMapper implements UpdateSettingsMapper
	{
		protected $settings;

		/**
		 * @param Database $database
		 * @param Map $settings
		 */
		public function __construct(Database $database, Map $settings)
		{
			parent::__construct($database);

			$this->settings = $settings;
		}

		public function setSettings(Map $settings)
		{
			$this->settings = $settings;
		}

		public function map()
		{
			$keyIterator = $this->settings->keyList()->iterator();

			while ($keyIterator->hasNext())
			{
				$key = $keyIterator->next();

				$sql  = 'UPDATE ';
				$sql .=   $this->relation('settings') . ' ';
				$sql .= 'SET ';
				$sql .=   'value = "' . $this->escape($this->settings->get($key)) . '" ';
				$sql .= 'WHERE ';
				$sql .=   'name = "' . $key . '"';

				$this->database->query($sql);
			}
		}
	}
