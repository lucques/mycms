<?php
	include 'includes/head.php';
?>
		<title>Kategorie löschen — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2 class="with-subline">Kategorie löschen</h2>
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
					<div class="section">
						<p>
							Sind Sie sicher, dass Sie die Kategorie mit der ID „<?php if ($this->category->containsKey('path')) { echo html_link($this, $this->category->id, $this->category->path); } else { echo $this->category->id; } ?>“ löschen möchten?
						</p>
						<p>
							<input name="delete" type="hidden" value="delete" />
							<input type="submit" value="Löschen" />
						</p>
					</div>
				</form>
<?php
	include 'includes/foot.php';
?>
