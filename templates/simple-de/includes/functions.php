<?php
	/**
	 * @param string $title
	 * @param string $link
	 * @param string $host
	 * @param string $path
	 * @param string $attributes
	 * @return string
	 */
	function html_link(Response $response, $title, $link, $attributes = '')
	{
		if ($link == $response->path || $link == $response->host . $response->path)
			echo '<span class="current">' . $title . '</span>';
		else
			echo '<a href="' . $link . '"' . (($attributes != '') ? ' ' . $attributes : '') . '>' . $title . '</a>';
	}

	/**
	 * @param Map $timestamp
	 * @param string $timeZoneOffset	looks like +02:00
	 * @param string $timeZoneOffsetInDST	looks like +03:00
	 *
	 * If $timeZoneOffset is empty, only the date will be printed, not the time and time zone offset
	 */
	function iso_8601_timestamp(Map $timestamp, $timeZoneOffset = '', $timeZoneOffsetInDST = '')
	{
		$format = '%year%-%monthWithLeadingZero%-%dayWithLeadingZero%';

		if ($timeZoneOffset != '')
			$format .= 'T%hourWithLeadingZero%:%minuteWithLeadingZero%:%secondWithLeadingZero%' . ((boolean) date('I', Timestamp::toUnixTimestamp($timestamp)) ? $timeZoneOffsetInDST : $timeZoneOffset);
	
		echo TimestampFormatter::format($timestamp, $format);
	}
