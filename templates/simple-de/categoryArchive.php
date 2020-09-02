<?php
	include 'includes/head.php';
?>
		<title><?php echo $this->category->title; ?> — <?php echo $this->title; ?><?php if ($this->page > 1) { ?> (Seite <?php echo $this->page; ?>)<?php } ?></title>
<?php
	include 'includes/prebody.php';
?>
				<div class="section lettering">
					<p>Archiv für die Kategorie „<?php echo $this->category->title; ?>“</p>
<?php
	if ($this->category->containsKey('editPath') || $this->category->containsKey('deletePath'))
	{
		$empty = true;
?>
					<p class="meta">
<?php
		if ($this->category->containsKey('editPath'))
		{
?>
						<?php html_link($this, 'Bearbeiten', $this->category->editPath, 'class="administrative"'); ?>

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
<?php
	}
?>
				</div>
<?php
	include 'includes/posts.php';
	include 'includes/foot.php';
?>
