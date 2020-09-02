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
			$this->connection = mysql_connect($host, $user, $password);

			if ($this->connection === false)
				throw new DatabaseException('Connecting failed.');
			if (!mysql_select_db($database, $this->connection))
				throw new DatabaseException('Selecting database failed.');
			if (!mysql_set_charset('utf8', $this->connection))
				throw new DatabaseException('Setting charset to UTF8 failed.');

			$this->relationPrefix = $relationPrefix;
			$this->numberOfQueries = 0;
		}

		/**
		 * @throws DatabaseException
		 */
		public function __destruct()
		{
			if (!mysql_close($this->connection))
				throw new DatabaseException('Disconnecting failed.');
		}

		public function query($sql)
		{
			$this->numberOfQueries ++;

			$result = mysql_query($sql, $this->connection);

			if ($result === false)
				throw new SQLException($sql);
			if ($result === true)
				return null;

			return new MySQLResultIterator(mysql_query($sql, $this->connection));
		}

		public function getNumberOfQueries()
		{
			return $this->numberOfQueries;
		}

		public function escape($string)
		{
			$escaped = mysql_real_escape_string($string, $this->connection);

			if ($escaped === false)
				throw new DatabaseException('Escaping string failed.');

			return $escaped;
		}

		public function relation($name)
		{
			return $this->relationPrefix . $name;
		}
	}
