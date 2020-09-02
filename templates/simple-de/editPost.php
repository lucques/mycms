<?php
	include 'includes/head.php';
?>
		<title>Post bearbeiten — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2 class="with-subline">Post bearbeiten</h2>
						<p class="subline meta">
							<?php
	$empty = true;

	if ($this->post->containsKey('path'))
	{
?>
							<?php html_link($this, 'Anschauen', $this->post->path); ?>

<?php
		$empty = false;
	}
	if ($this->post->containsKey('editPath'))
	{
?>
							<?php if (!$empty) { ?>· <?php } html_link($this, 'Bearbeiten', $this->post->editPath, 'class="administrative"'); ?>

<?php
		$empty = false;
	}
	if ($this->post->containsKey('deletePath'))
	{
?>
							<?php if (!$empty) { ?>· <?php } html_link($this, 'Löschen', $this->post->deletePath, 'class="administrative"'); ?>

<?php
	}
?>
						</p>
					</div>
<?php
	if ($this->failed)
	{
?>
					<div class="section failure">
						<p>Post nicht aktualisiert</p>
					</div>
<?php
	}
	if ($this->edited)
	{
?>
					<div class="section success">
						<p>Post erfolgreich aktualisiert</p>
					</div>
<?php
	}
?>

					<div class="section">
						<h3>ID, Titel und Autor</h3>
						<p>
							<label>
								<input name="id" type="text" value="<?php echo $this->post->id; ?>" readonly />
								ID
							</label>
						</p>
<?php
	if ($this->invalidTitle)
	{
?>
						<p class="failure">Titel unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="title" type="text" pattern="<?php echo $this->titlePattern; ?>" title="Maximal 200 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->post->title); ?>" required />
								Titel
							</label>
						</p>
						<p>
							<label>
								<input name="author_id" type="text" value="<?php echo $this->post->author->id; ?>" required readonly />
								Autoren-ID
							</label>
						</p>
					</div>
					<div class="section">
						<h3>Inhalt</h3>
<?php
	if ($this->invalidContent)
	{
?>
						<p class="failure">Inhalt unzulässig</p>
<?php
	}
?>
						<p>
							<textarea name="content" rows="25" pattern="<?php echo $this->contentPattern; ?>" title="Maximal 16000 Zeichen erlaubt" required><?php echo XSSFilter::filter($this->post->content); ?></textarea>
						</p>
					</div>
					<div class="section">
						<h3>Zeitstempel</h3>
<?php
	if ($this->invalidTimestamp)
	{
?>
						<p class="failure">Zeitstempel unzulässig</p>
<?php
	}
?>
						<table>
							<thead>
								<tr>
									<th>Datum (<label for="form_timestamp_day"><strong>dd</strong></label>.<label for="form_timestamp_month"><strong>mm</strong></label>.<label for="form_timestamp_year"><strong>yyyy</strong></label>)</th>
									<th>Uhrzeit (<label for="form_timestamp_hour"><strong>hh</strong></label>:<label for="form_timestamp_minute"><strong>mm</strong></label>:<label for="form_timestamp_second"><strong>ss</strong></label>)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input id="form_timestamp_day" name="timestamp_day" type="text" maxlength="2" size="2" placeholder="dd" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->post->timestamp->day); } else { echo TimestampFormatter::format($this->post->timestamp, '%dayWithLeadingZero%'); } ?>" required />
										. <input id="form_timestamp_month" name="timestamp_month" type="text" maxlength="2" size="2" placeholder="mm" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->post->timestamp->month); } else { echo TimestampFormatter::format($this->post->timestamp, '%monthWithLeadingZero%'); } ?>" required />
										. <input id="form_timestamp_year" name="timestamp_year" type="text" maxlength="4" size="4" placeholder="yyyy" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->post->timestamp->year); } else { echo $this->post->timestamp->year; } ?>" required />
									</td>
									<td>
										<input id="form_timestamp_hour" name="timestamp_hour" type="text" maxlength="2" size="2" placeholder="hh" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->post->timestamp->hour); } else { echo TimestampFormatter::format($this->post->timestamp, '%hourWithLeadingZero%'); } ?>" required />
										: <input id="form_timestamp_minute" name="timestamp_minute" type="text" maxlength="2" size="2" placeholder="mm" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->post->timestamp->minute); } else { echo TimestampFormatter::format($this->post->timestamp, '%minuteWithLeadingZero%'); } ?>" required />
										: <input id="form_timestamp_second" name="timestamp_second" type="text" maxlength="2" size="2" placeholder="ss" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->post->timestamp->second); } else { echo TimestampFormatter::format($this->post->timestamp, '%secondWithLeadingZero%'); } ?>" required />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="section">
						<h3>Kategorien</h3>
						<table>
							<thead>
								<tr>
									<th class="centered">✓</th>
									<th>Titel</th>
								</tr>
							</thead>
							<tbody>
<?php
	$iterator = $this->categories->iterator();

	while ($iterator->hasNext())
	{
		$category = $iterator->next();
?>
								<tr>
									<td><input id="form_category_<?php echo $category->id; ?>" name="category_<?php echo $category->id; ?>" type="checkbox"<?php if ($this->post->categories->contains($category->id)) { ?> checked<?php } ?> /></td>
									<td><label for="form_category_<?php echo $category->id; ?>"><?php echo $category->title; ?></label></td>
								</tr>
<?php
	}
?>
							</tbody>
						</table>
					</div>
					<div class="section">
						<h3>Einstellungen</h3>
						<table>
							<thead>
								<tr>
									<th class="centered">✓</th>
									<th>Einstellung</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input id="form_show_comments" name="show_comments" type="checkbox"<?php if ($this->post->showComments) { ?> checked<?php } ?> /></td>
									<td><label for="form_show_comments">Kommentare zeigen</label></td>
								</tr>
								<tr>
									<td><input id="form_allow_comments" name="allow_comments" type="checkbox"<?php if ($this->post->allowComments) { ?> checked<?php } ?> /></td>
									<td><label for="form_allow_comments">Kommentare zulassen</label></td>
								</tr>
								<tr>
									<td><input id="form_show_link" name="show_link" type="checkbox"<?php if ($this->post->showLink) { ?> checked<?php } ?> /></td>
									<td><label for="form_show_link">Link zeigen</label></td>
								</tr>
								<tr>
									<td><input id="form_show_timestamp" name="show_timestamp" type="checkbox"<?php if ($this->post->showAuthor) { ?> checked<?php } ?> /></td>
									<td><label for="form_show_timestamp">Zeitstempel zeigen</label></td>
								</tr>
								<tr>
									<td><input id="form_show_author" name="show_author" type="checkbox"<?php if ($this->post->showAuthor) { ?> checked<?php } ?> /></td>
									<td><label for="form_show_author">Autor zeigen</label></td>
								</tr>
								<tr>
									<td><input id="form_is_static" name="is_static" type="checkbox"<?php if ($this->post->isStatic) { ?> checked<?php } ?> /></td>
									<td><label for="form_is_static">Statisch?</label></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="section">
						<p>
							<input type="submit" value="Speichern" />
						</p>
					</div>
				</form>
<?php
	include 'includes/foot.php';
?>
