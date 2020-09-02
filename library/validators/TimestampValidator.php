<?php
	/**
	 * This validator validates a timestamp Map. It only considers year, month, day, hour, minute and second.
	 */
	class TimestampValidator
	{
		/**
		 * @param Map $timestamp
		 *   Map
		 *   {
		 *     year: int
		 *     month: int
		 *     day: int
		 *     hour: int
		 *     minute: int
		 *     second: int
		 *   }
		 * @return boolean
		 */
		public static function isValid(Map $timestamp)
		{
			return (!$timestamp->containsKey('year') ||
			        $timestamp->get('year') <= 32767 &&
			        $timestamp->get('year') > 0) &&
			       (!$timestamp->containsKey('month') ||
			        $timestamp->get('month') <= 12 &&
			        $timestamp->get('month') > 0) &&
			       (!$timestamp->containsKey('day') ||
			        $timestamp->get('day') <= 31 &&
			        $timestamp->get('day') > 0) &&
			       (!$timestamp->containsKey('hour') ||
			        $timestamp->get('hour') < 24 &&
			        $timestamp->get('hour') >= 0) &&
			       (!$timestamp->containsKey('minute') ||
			        $timestamp->get('minute') < 60 &&
			        $timestamp->get('minute') >= 0) &&
			       (!$timestamp->containsKey('second') ||
			        $timestamp->get('second') < 60 &&
			        $timestamp->get('second') >= 0) &&
			       ((!$timestamp->containsKey('year') ||
			         !$timestamp->containsKey('month') ||
			         !$timestamp->containsKey('day')) ||
			        checkdate($timestamp->get('month'), $timestamp->get('day'), $timestamp->get('year'))) &&
			       (($timestamp->containsKey('year') ||
			         !$timestamp->containsKey('month') ||
			         !$timestamp->containsKey('day')) ||
			//2010 is not a leap year
			        checkdate($timestamp->get('month'), $timestamp->get('day'), 2010));
		}
	}
