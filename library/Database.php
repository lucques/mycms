<?php
	/**
	 * This interface defines a way to interact with databases. The main function of this class is to send SQL queries and
	 * get the result sets.
	 */
	interface Database
	{
		/**
		 * @param string $sql
		 * @return MyIterator|null
		 * @throws SQLException
		 */
		public function query($sql);

		/**
		 * @return int
		 */
		public function getNumberOfQueries();

		/**
		 * 
		 *
		 * @param string $string
		 * @return string
		 * @throws DatabaseException
		 */
		public function escape($string);

		/**
		 * Returns the concatenation of the relation prefix with $name
		 *
		 * @param string $name
		 * @return string
		 */
		public function relation($name);
	}
