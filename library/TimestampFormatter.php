<?php
	/**
	 * This class provides a static method to format a Map containing a timestamp with a given format.
	 */
	class TimestampFormatter
	{
		protected static $weekdayNames = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		protected static $weekdayNameAbbreviations = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
		protected static $monthNames = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		protected static $monthNameAbbreviations = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

		protected static $germanWeekdayNames = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
		protected static $germanWeekdayNameAbbreviations = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
		protected static $germanMonthNames = array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
		protected static $germanMonthNameAbbreviations = array('Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez');

		/**
		 * @param Map $timestamp
		 * @param string $format
		 * @return string
		 */
		public static function format(Map $timestamp, $format)
		{
			if (strpos($format, '%weekdayNameAbbreviation%') !== false)
				$format = str_replace('%weekdayNameAbbreviation%', self::$weekdayNameAbbreviations[$timestamp->get('weekday')], $format);
			if (strpos($format, '%weekdayName%') !== false)
				$format = str_replace('%weekdayName%', self::$weekdayNames[$timestamp->get('weekday')], $format);
			if (strpos($format, '%monthNameAbbreviation%') !== false)
				$format = str_replace('%monthNameAbbreviation%', self::$monthNameAbbreviations[$timestamp->get('month') - 1], $format);
			if (strpos($format, '%monthName%') !== false)
				$format = str_replace('%monthName%', self::$monthNames[$timestamp->get('month') - 1], $format);
			if (strpos($format, '%germanWeekdayNameAbbreviation%') !== false)
				$format = str_replace('%germanWeekdayNameAbbreviation%', self::$germanWeekdayNameAbbreviations[$timestamp->get('weekday')], $format);
			if (strpos($format, '%germanWeekdayName%') !== false)
				$format = str_replace('%germanWeekdayName%', self::$germanWeekdayNames[$timestamp->get('weekday')], $format);
			if (strpos($format, '%germanMonthNameAbbreviation%') !== false)
				$format = str_replace('%germanMonthNameAbbreviation%', self::$germanMonthNameAbbreviations[$timestamp->get('month') - 1], $format);
			if (strpos($format, '%germanMonthName%') !== false)
				$format = str_replace('%germanMonthName%', self::$germanMonthNames[$timestamp->get('month') - 1], $format);
			if (strpos($format, '%weekday%') !== false)
				$format = str_replace('%weekday%', $timestamp->get('weekday'), $format);
			if (strpos($format, '%dayOfYear%') !== false)
				$format = str_replace('%dayOfYear%', $timestamp->get('dayOfYear'), $format);
			if (strpos($format, '%week%') !== false)
				$format = str_replace('%week%', $timestamp->get('week'), $format);
			if (strpos($format, '%year%') !== false)
				$format = str_replace('%year%', $timestamp->get('year'), $format);
			if (strpos($format, '%month%') !== false)
				$format = str_replace('%month%', $timestamp->get('month'), $format);
			if (strpos($format, '%monthWithLeadingZero%') !== false)
				$format = str_replace('%monthWithLeadingZero%', str_pad($timestamp->get('month'), 2, '0', STR_PAD_LEFT), $format);
			if (strpos($format, '%day%') !== false)
				$format = str_replace('%day%', $timestamp->get('day'), $format);
			if (strpos($format, '%dayWithLeadingZero%') !== false)
				$format = str_replace('%dayWithLeadingZero%', str_pad($timestamp->get('day'), 2, '0', STR_PAD_LEFT), $format);
			if (strpos($format, '%hour%') !== false)
				$format = str_replace('%hour%', $timestamp->get('hour'), $format);
			if (strpos($format, '%hourWithLeadingZero%') !== false)
				$format = str_replace('%hourWithLeadingZero%', str_pad($timestamp->get('hour'), 2, '0', STR_PAD_LEFT), $format);
			if (strpos($format, '%hourOf12%') !== false)
				$format = str_replace('%hourOf12%', $timestamp->get('hour') == 0 ? 12 : $timestamp->get('hour') > 12 ? $timestamp->get('hour') - 12 : $timestamp->get('hour'), $format);
			if (strpos($format, '%hourOf12WithLeadingZero%') !== false)
				$format = str_replace('%hourOf12WithLeadingZero%', str_pad($timestamp->get('hour') == 0 ? 12 : $timestamp->get('hour') > 12 ? $timestamp->get('hour') - 12 : $timestamp->get('hour'), 2, '0', STR_PAD_LEFT), $format);
			if (strpos($format, '%amOrPm%') !== false)
				$format = str_replace('%amOrPm%', $timestamp->get('hour') < 12 ? 'a.m.' : 'p.m.', $format);
			if (strpos($format, '%minute%') !== false)
				$format = str_replace('%minute%', $timestamp->get('minute'), $format);
			if (strpos($format, '%minuteWithLeadingZero%') !== false)
				$format = str_replace('%minuteWithLeadingZero%', str_pad($timestamp->get('minute'), 2, '0', STR_PAD_LEFT), $format);
			if (strpos($format, '%second%') !== false)
				$format = str_replace('%second%', $timestamp->get('second'), $format);
			if (strpos($format, '%secondWithLeadingZero%') !== false)
				$format = str_replace('%secondWithLeadingZero%', str_pad($timestamp->get('second'), 2, '0', STR_PAD_LEFT), $format);

			return $format;
		}
	}
