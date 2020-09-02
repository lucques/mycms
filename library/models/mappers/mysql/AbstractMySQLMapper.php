<?php
	/**
	 * This class represents an abstract mapper using a MySQL database.
	 */
	abstract class AbstractMySQLMapper
	{
		protected $database;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			$this->database = $database;
		}

		/**
		 * @param string $string
		 * @return string
		 * @throws DatabaseException
		 */
		protected function escape($string)
		{
			return $this->database->escape($string);
		}

		/**
		 * @param string $name
		 * @return string
		 */
		protected function relation($name)
		{
			return $this->database->relation($name);
		}
	}
