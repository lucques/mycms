<?php
	/**
	 * This Exception is thrown if there is something wrong with an SQL query sent to the database.
	 */
	class SQLException extends Exception
	{
		/**
		 * @param string $message
		 */
		public function __construct($sql)
		{
			parent::__construct('SQL query failed: ' . $sql);
		}
	}
