<?php
	include 'includes/head.php';
?>
		<title>Kommentar löschen — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2>Kommentar löschen</h2>
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
					<div class="section">
						<p>
							Sind Sie sicher, dass Sie den Kommentar mit der ID <?php html_link($this, $this->comment->id, $this->comment->path); ?> löschen möchten?
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
