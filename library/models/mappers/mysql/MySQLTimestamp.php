<?php
	/**
	 * This class contains a static method to generate a MySQL timestamp
	 */
	class MySQLTimestamp
	{
		/**
		 * @param Map $timestamp
		 * @return string
		 */
		public static function fromTimestamp(Map $timestamp)
		{
			return TimestampFormatter::format($timestamp, '%year%-%monthWithLeadingZero%-%dayWithLeadingZero% %hourWithLeadingZero%:%minuteWithLeadingZero%:%secondWithLeadingZero%');
		}

		/**
		 * @param string $mySQLTimestamp
		 * @return Map
		 */
		public static function toTimestamp($mySQLTimestamp)
		{
			return Timestamp::fromUnixTimestamp(strtotime($mySQLTimestamp));
		}
	}
