<?php
	include 'includes/head.php';
?>
		<title>Post löschen — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2 class="with-subline">Post löschen</h2>
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
					<div class="section">
						<p>
							Sind Sie sicher, dass Sie den Post mit der ID „<?php if ($this->post->showLink && $this->post->containsKey('path')) { html_link($this, $this->post->id, $this->post->path); } else { echo $this->post->id; } ?>“ löschen möchten?
							Alle Kommentare zu diesem Post werden gelöscht.
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
