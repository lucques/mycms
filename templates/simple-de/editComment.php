<?php
	include 'includes/head.php';
?>
		<title>Kommentar bearbeiten — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2>Kommentar bearbeiten</h2>
						<p>
							<?php html_link($this, 'Anschauen', $this->comment->path); ?>

<?php
		if ($this->comment->containsKey('editPath'))
		{
?>
							· <?php html_link($this, 'Bearbeiten', $this->comment->editPath, 'class="administrative"'); ?>

<?php
		}
		if ($this->comment->containsKey('deletePath'))
		{
?>
							· <?php html_link($this, 'Löschen', $this->comment->deletePath, 'class="administrative"'); ?>

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
						<p>Kommentar nicht aktualisiert</p>
					</div>
<?php
	}
	if ($this->edited)
	{
?>
					<div class="section success">
						<p>Kommentar erfolgreich aktualisiert</p>
					</div>
<?php
	}
?>
					<div class="section">
						<h3>ID</h3>
						<p>
							<label>
								<input name="id" type="text" value="<?php echo XSSFilter::filter($this->comment->id); ?>" readonly />
								ID
							</label>
						</p>
					</div>
					<div class="section">
						<h3>Name, E-Mail und Website</h3>
<?php
	if ($this->invalidNick)
	{
?>
						<p class="failure">Name unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="nick" type="text" pattern="<?php echo $this->nickPattern; ?>" title="Maximal 100 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->comment->nick); ?>" required />
								Name
							</label>
						</p>
<?php
	if ($this->invalidEmail)
	{
?>
						<p class="failure">E-Mail unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="email" type="email" title="Maximal 200 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->comment->email); ?>" required />
								E-Mail
							</label>
						</p>
<?php
	if ($this->invalidWebsite)
	{
?>
						<p class="failure">Website unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="website" type="url" title="Maximal 400 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->comment->website); ?>" />
								Website
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
							<textarea name="content" rows="10" pattern="<?php echo $this->contentPattern; ?>" title="Maximal 4000 Zeichen erlaubt" required><?php echo XSSFilter::filter($this->comment->content); ?></textarea>
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
										<input id="form_timestamp_day" name="timestamp_day" type="text" maxlength="2" size="2" placeholder="dd" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->comment->timestamp->day); } else { echo TimestampFormatter::format($this->comment->timestamp, '%dayWithLeadingZero%'); } ?>" required />
										. <input id="form_timestamp_month" name="timestamp_month" type="text" maxlength="2" size="2" placeholder="mm" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->comment->timestamp->month); } else { echo TimestampFormatter::format($this->comment->timestamp, '%monthWithLeadingZero%'); } ?>" required />
										. <input id="form_timestamp_year" name="timestamp_year" type="text" maxlength="4" size="4" placeholder="yyyy" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->comment->timestamp->year); } else { echo $this->comment->timestamp->year; } ?>" required />
									</td>
									<td>
										<input id="form_timestamp_hour" name="timestamp_hour" type="text" maxlength="2" size="2" placeholder="hh" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->comment->timestamp->hour); } else { echo TimestampFormatter::format($this->comment->timestamp, '%hourWithLeadingZero%'); } ?>" required />
										: <input id="form_timestamp_minute" name="timestamp_minute" type="text" maxlength="2" size="2" placeholder="mm" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->comment->timestamp->minute); } else { echo TimestampFormatter::format($this->comment->timestamp, '%minuteWithLeadingZero%'); } ?>" required />
										: <input id="form_timestamp_second" name="timestamp_second" type="text" maxlength="2" size="2" placeholder="ss" value="<?php if ($this->invalidTimestamp) { echo XSSFilter::filter($this->comment->timestamp->second); } else { echo TimestampFormatter::format($this->comment->timestamp, '%secondWithLeadingZero%'); } ?>" required />
									</td>
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
