<?php
	/**
	 * This class implements the Criterion interface by simply returning empty arrays.
	 */
	abstract class AbstractCriterion implements Criterion
	{
		protected $database;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			$this->database = $database;
		}

		public function from()
		{
			return array();
		}

		public function where()
		{
			return array();
		}

		public function groupBy()
		{
			return array();
		}

		public function having()
		{
			return array();
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
