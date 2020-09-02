<?php
	/**
	 * This Exception is thrown if the user tries to do an unauthorized action.
	 */
	class UnauthorizedException extends Exception
	{
		public function __construct()
		{
			parent::__construct('User action is unauthorized.');
		}
	}
