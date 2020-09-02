<?php
	/**
	 * This Exception is thrown if some data was not found.
	 */
	class NotFoundException extends Exception
	{
		public function __construct()
		{
			parent::__construct('Data was not found.');
		}
	}
