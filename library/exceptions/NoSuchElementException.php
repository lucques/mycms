<?php
	/**
	 * This Exception is thrown if there are no more elements to iterate over.
	 */
	class NoSuchElementException extends Exception
	{
		public function __construct()
		{
			parent::__construct('There are no elements to iterate over.');
		}
	}
