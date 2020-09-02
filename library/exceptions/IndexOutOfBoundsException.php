<?php
	/**
	 * This Exception is thrown if an index does not exist in a MyList.
	 */
	class IndexOutOfBoundsException extends Exception
	{
		public function __construct()
		{
			parent::__construct('Index is out of bounds.');
		}
	}
