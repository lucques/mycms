<?php
	$this->setContentType('application/rss+xml; charset=utf-8');

	echo '<?xml version="1.0" encoding="utf-8" ?>';
?>

<rss version="2.0">
	<channel>
		<title><?php echo $this->title; ?></title>
		<link><?php echo $this->host . $this->root; ?></link>
		<description><?php echo $this->description; ?></description>
		<image>
			<title><?php echo $this->title; ?></title>
			<link><?php echo $this->host . $this->root; ?></link>
			<url><?php echo $this->host . $this->root; ?>images/logo.png</url>
			<description><?php echo $this->description; ?></description>
			<width>210</width>
			<height>101</height>
		</image>
		<language><?php echo $this->language; ?></language>
<?php
	$postIterator = $this->posts->iterator();

	while ($postIterator->hasNext())
	{
		$post = $postIterator->next();
?>
		<item>
			<title><?php echo $post->title; ?></title>
			<link><?php echo $this->host . $post->path; ?></link>
			<guid><?php echo $this->host . $post->path; ?></guid>
			<description>
				<![CDATA[
					<?php echo $post->content; ?>

				]]>
			</description>
<?php //includes checking whether date is DST or not, and then uses right timezone offset whose format gets changed from +02:00 to +0200 ?>
			<pubDate><?php echo TimestampFormatter::format($post->timestamp, '%weekdayNameAbbreviation%, %dayWithLeadingZero% %monthNameAbbreviation% %year% %hourWithLeadingZero%:%minuteWithLeadingZero%:%secondWithLeadingZero% ' . ((boolean) date('I', Timestamp::toUnixTimestamp($post->timestamp)) ? substr($this->timeZoneOffsetInDST, 0, 3) . substr($this->timeZoneOffsetInDST, 4, 2) : substr($this->timeZoneOffset, 0, 3) . substr($this->timeZoneOffset, 4, 2))); ?></pubDate>
<?php
		$categoryIterator = $post->categories->iterator();

		while ($categoryIterator->hasNext())
		{
			$category = $categoryIterator->next();
?>
			<category><![CDATA[<?php echo $category->title; ?>]]></category>
<?php
		}
?>
		</item>
<?php
	}
?>
	</channel>
</rss>
