<?php
	include 'includes/head.php';
?>
		<title>Einstellungen bearbeiten — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2>Einstellungen bearbeiten</h2>

					</div>
<?php
	if ($this->failed)
	{
?>
					<div class="section failure">
						<p>Einstellungen nicht gespeichert</p>
					</div>
<?php
	}
	if ($this->edited)
	{
?>
					<div class="section success">
						<p>Einstellungen gespeichert</p>
					</div>
<?php
	}
?>
					<div class="section">
						<table>
							<thead>
								<tr>
									<th>Schlüssel</th>
									<th>Wert</th>
								</tr>
							</thead>
							<tbody>
<?php
	$keyIterator = $this->settings->keyList()->iterator();

	while ($keyIterator->hasNext())
	{
		$key = $keyIterator->next();
?>
								<tr>
									<td><label for="<?php echo str_replace('.', '_', $key); ?>"><?php echo $key; ?></label></td>
									<td>
										<input name="<?php echo str_replace('.', '_', $key); ?>" type="text" pattern="<?php echo $this->valuePattern; ?>" title="Maximal 500 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->settings->get($key)); ?>" />
									</td>
								</tr>
<?php
	}
?>
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
