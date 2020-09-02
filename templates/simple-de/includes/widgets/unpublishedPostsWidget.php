<?php
	if ($this->contains('unpublishedPostsWidget'))
	{
		$iterator = $this->unpublishedPostsWidget->iterator();
?>
				<div class="section">
					<h3>Unveröffentlichte Posts</h3>
					<table class="large">
						<thead>
							<tr>
								<th class="small">Zeitstempel</th>
								<th>Titel</th>
								<th class="small">Bearbeiten</th>
								<th class="small">Löschen</th>
							</tr>
						</thead>
						<tbody>
<?php
		while ($iterator->hasNext())
		{
			$post = $iterator->next();
?>
							<tr>
								<td><time datetime="<?php iso_8601_timestamp($post->timestamp, $this->timeZoneOffset, $this->timeZoneOffsetInDST); ?>"><?php echo TimestampFormatter::format($post->timestamp, '%dayWithLeadingZero%.%monthWithLeadingZero%.%year%'); ?></time></td>
								<td><?php echo $post->title; ?></td>
								<td><?php if ($post->containsKey('editPath')) { html_link($this, 'Bearbeiten', $post->editPath, 'class="administrative"'); } ?></td>
								<td><?php if ($post->containsKey('deletePath')) { html_link($this, 'Löschen', $post->deletePath, 'class="administrative"'); } ?></td>
							</tr>
<?php
		}
?>
						</tbody>
					</table>
				</div>
<?php
	}
