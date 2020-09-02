				<div class="section large-margin">
<?php
	$postIterator = $this->posts->iterator();

	while ($postIterator->hasNext())
	{
		$post = $postIterator->next();

		$withSubline = $post->showAuthor || $post->showTimestamp || $post->containsKey('editPath') || $post->containsKey('deletePath');
?>
					<article class="item">
						<h2<?php if ($withSubline) { ?> class="with-subline"<?php } ?>><?php if ($post->showLink) { html_link($this, $post->title, $post->path); } else { echo $post->title; } ?></h2>
<?php
		if ($withSubline)
		{
			$empty = true;
?>
						<p class="subline meta">
<?php
			if ($post->showAuthor)
			{
?>
							Von <?php if ($post->author->website != '') { html_link($this, $post->author->nick, $post->author->website); } else { echo $post->author->nick; } ?>

<?php
				$empty = false;
			}
			if ($post->showTimestamp)
			{
?>
							<?php if (!$empty) { ?>am <?php } else { ?>Am <?php } ?><time datetime="<?php iso_8601_timestamp($post->timestamp, $this->timeZoneOffset, $this->timeZoneOffsetInDST); ?>" pubdate><?php echo TimestampFormatter::format($post->timestamp, '%dayWithLeadingZero%.%monthWithLeadingZero%.%year%, %hourWithLeadingZero%:%minuteWithLeadingZero% Uhr'); ?></time>
<?php
				$empty = false;
			}
			if ($post->containsKey('editPath'))
			{
?>
							<?php if (!$empty) { ?>· <?php } html_link($this, 'Bearbeiten', $post->editPath, 'class="administrative"'); ?>

<?php
				$empty = false;
			}
			if ($post->containsKey('deletePath'))
			{
?>
							<?php if (!$empty) { ?>· <?php } html_link($this, 'Löschen', $post->deletePath, 'class="administrative"'); ?>

<?php
			}
?>
						</p>
<?php
		}

		$position = strpos($post->content, '<!--more-->');

		if ($position === false)
		{
?>
						<?php echo $post->content; ?>

<?php
		}
		else
		{
?>
						<?php echo substr($post->content, 0 , $position); ?>
						<p>
							<strong><a href="<?php echo $post->path; ?>#more">Weiterlesen…</a></strong>
						</p>
<?php
		}

		if ($post->categories->size() > 0)
		{
?>
						<p class="meta">
							Kategorien:
<?php
			$categoryIterator = $post->categories->iterator();

			while ($categoryIterator->hasNext())
			{
				$category = $categoryIterator->next();
?>
							<?php html_link($this, $category->title, $category->path); ?><?php if ($categoryIterator->hasNext()) { ?>,<?php } ?>

<?php
			}
?>
						</p>
<?php
		}
?>
					</article>
<?php
	}
?>
				</div>
<?php
	if ($this->pagination->size() > 1)
	{
		$paginationIterator = $this->pagination->iterator();
?>
				<div class="section">
					<ul class="section pagination">
						<?php
		while ($paginationIterator->hasNext())
		{
			$page = $paginationIterator->next();
?><li><?php html_link($this, $page->page, $page->path); ?></li><?php
		}
?>

					</ul>
				</div>
<?php
	}
?>
