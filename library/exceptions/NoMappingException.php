<?php
	/**
	 * This Exception is thrown if there is no element mapped to a given string.
	 */
	class NoMappingException extends Exception
	{
		/**
		 * @param string $key
		 */
		public function __construct($key)
		{
			parent::__construct('No mapping found for "' . $key . '".');
		}
	}
