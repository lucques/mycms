<?php
	if ($this->contains('recentCommentsWidget'))
	{
		$iterator = $this->recentCommentsWidget->iterator();

		if ($iterator->hasNext())
		{
?>
				<div class="section">
					<h3>Letze Kommentare</h3>
					<table class="large">
						<thead>
							<tr>
								<th class="small">Zeitstempel</th>
								<th>Post</th>
								<th>Name</th>
								<th class="small">Bearbeiten</th>
								<th class="small">Löschen</th>
							</tr>
						</thead>
						<tbody>
<?php
			while	($iterator->hasNext())
			{
				$comment = $iterator->next();
?>
							<tr>
								<td class="timestamp"><time datetime="<?php iso_8601_timestamp($comment->timestamp, $this->timeZoneOffset, $this->timeZoneOffsetInDST); ?>"><?php echo TimestampFormatter::format($comment->timestamp, '%dayWithLeadingZero%.%monthWithLeadingZero%.%year%'); ?></time></td>
								<td><?php html_link($this, XSSFilter::filter($comment->post->title), $comment->path); ?></td>
								<td><?php if ($comment->website != '') { html_link($this, XSSFilter::filter($comment->nick), XSSFilter::filter($comment->website)); } else { echo XSSFilter::filter($comment->nick); } ?></td>
								<td><?php if ($comment->containsKey('editPath')) { html_link($this, 'Bearbeiten', $comment->editPath, 'class="administrative"'); } ?></td>
								<td><?php if ($comment->containsKey('deletePath')) { html_link($this, 'Löschen', $comment->deletePath, 'class="administrative"'); } ?></td>
							</tr>
<?php
			}
?>
						</tbody>
					</table>
				</div>
<?php
		}
	}
