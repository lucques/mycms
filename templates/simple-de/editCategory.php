<?php
	include 'includes/head.php';
?>
		<title>Kategorie bearbeiten — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2 class="with-subline">Kategorie bearbeiten</h2>
						<p class="subline meta">
							<?php
	$empty = true;

	if ($this->category->containsKey('path'))
	{
?>
							<?php html_link($this, 'Anschauen', $this->category->path); ?>

<?php
		$empty = false;
	}
	if ($this->category->containsKey('editPath'))
	{
?>
							<?php if (!$empty) { ?>· <?php } html_link($this, 'Bearbeiten', $this->category->editPath, 'class="administrative"'); ?>

<?php
		$empty = false;
	}
	if ($this->category->containsKey('deletePath'))
	{
?>
							<?php if (!$empty) { ?>· <?php } html_link($this, 'Löschen', $this->category->deletePath, 'class="administrative"'); ?>

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
						<p>Kategorie nicht aktualisiert</p>
					</div>
<?php
	}
	if ($this->edited)
	{
?>
					<div class="section success">
						<p>Kategorie erfolgreich aktualisiert</p>
					</div>
<?php
	}
?>

					<div class="section">
						<p>
							<label>
								<input name="id" type="text" value="<?php echo XSSFilter::filter($this->category->id); ?>" readonly />
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
								<input name="title" type="text" pattern="<?php echo $this->titlePattern; ?>" title="Maximal 200 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->category->title); ?>" required />
								Titel
							</label>
						</p>
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
