<?php
	/**
	 * This class provides a static method to simply protect a string from XSS.
	 */
	class XSSFilter
	{
		/**
		 * @param string $string
		 * @return string
		 */
		public static function filter($string)
		{
			return htmlspecialchars($string, ENT_NOQUOTES);
		}
	}
