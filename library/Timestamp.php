<?php
	/**
	 * This class provides a method to create a Map object containing a timestamp from a unix timestamp.
	 */
	class Timestamp
	{
		/**
		 * @param int $unixTimestamp
		 * @return Map
		 *   Map
		 *   {
		 *     weekday: int
		 *     dayOfYear: int
		 *     week: int
		 *     year: int
		 *     month: int
		 *     day: int
		 *     hour: int
		 *     minute: int
		 *     second: int
		 *   }
		 */
		public static function fromUnixTimestamp($unixTimestamp)
		{
			$timestamp = new Map();
			$timestamp->put('weekday', (int) date('w', $unixTimestamp));
			$timestamp->put('dayOfYear', (int) date('z', $unixTimestamp));
			$timestamp->put('week', (int) date('W', $unixTimestamp));
			$timestamp->put('year', (int) date('Y', $unixTimestamp));
			$timestamp->put('month', (int) date('n', $unixTimestamp));
			$timestamp->put('day', (int) date('j', $unixTimestamp));
			$timestamp->put('hour', (int) date('G', $unixTimestamp));
			$timestamp->put('minute', (int) date('i', $unixTimestamp));
			$timestamp->put('second', (int) date('s', $unixTimestamp));

			return $timestamp;
		}

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
		 */
		public static function toUnixTimestamp(Map $timestamp)
		{
			return mktime($timestamp->get('hour'), $timestamp->get('minute'), $timestamp->get('second'), $timestamp->get('month'), $timestamp->get('day'), $timestamp->get('year'));
		}
	}
