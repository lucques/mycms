<?php
	/**
	 * This validator validates integer numbers.
	 */
	class IntegerNumberValidator
	{
		/**
		 * @param string $value
		 * @param boolean $withLeadingZeros
		 * @return boolean
		 */
		public static function isValid($value, $withLeadingZeros)
		{
			if ($withLeadingZeros)
				return (boolean) preg_match('/^-?[0-9]+$/', $value);
			else
				return (boolean) preg_match('/^((-[1-9][0-9]*)|(0|[1-9][0-9]*))$/', $value);
		}
	}
