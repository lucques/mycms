<?php
	if ($this->contains('yearMonthArchivesWidget'))
	{
?>
				<h2>Archive</h2>
				<ul>
<?php
		$iterator = $this->yearMonthArchivesWidget->iterator();

		while ($iterator->hasNext())
		{
			$timestamp = $iterator->next();
?>
					<li><?php html_link($this, TimestampFormatter::format($timestamp, '%germanMonthName% %year%'), $timestamp->path); ?> (<?php echo $timestamp->numberOfPosts; ?>)</li>
<?php
		}
?>
				</ul>
<?php
	}
