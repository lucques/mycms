<?php
	/**
	 * This Exception is thrown if there is an error while communicating with the database.
	 */
	class DatabaseException extends Exception
	{
		/**
		 * @param string $message
		 */
		public function __construct($message)
		{
			parent::__construct('Error while communicating with database: ' . $message);
		}
	}
