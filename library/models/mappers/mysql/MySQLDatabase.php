<?php
	/**
	 * This class implements the Database interface for a MySQL database.
	 */
	class MySQLDatabase implements Database
	{
		protected $connection;
		protected $relationPrefix;
		protected $numberOfQueries;

		/**
		 * @param string $host
		 * @param string $user
		 * @param string $password
		 * @param string $database
		 * @throws DatabaseException
		 */
		public function __construct($host, $user, $password, $database, $relationPrefix)
		{
			$this->connection = mysqli_connect($host, $user, $password);

			if ($this->connection === false)
				throw new DatabaseException('Connecting failed.');
			if (!mysqli_select_db($this->connection, $database))
				throw new DatabaseException('Selecting database failed.');
			if (!mysqli_set_charset($this->connection, 'utf8'))
				throw new DatabaseException('Setting charset to UTF8 failed.');

			$this->relationPrefix = $relationPrefix;
			$this->numberOfQueries = 0;
		}

		/**
		 * @throws DatabaseException
		 */
		public function __destruct()
		{
			if (!mysqli_close($this->connection))
				throw new DatabaseException('Disconnecting failed.');
		}

		public function query($sql)
		{
			$this->numberOfQueries ++;

			$result = mysqli_query($this->connection, $sql);

			if ($result === false)
				throw new SQLException($sql);
			if ($result === true)
				return null;

			return new MySQLResultIterator(mysqli_query($this->connection, $sql));
		}

		public function getNumberOfQueries()
		{
			return $this->numberOfQueries;
		}

		public function escape($string)
		{
			$escaped = mysqli_real_escape_string($this->connection, $string);

			if ($escaped === false)
				throw new DatabaseException('Escaping string failed.');

			return $escaped;
		}

		public function relation($name)
		{
			return $this->relationPrefix . $name;
		}
	}
