<?php
	include 'includes/head.php';
?>
		<title><?php echo TimestampFormatter::format($this->timestamp, '%germanMonthName% %year%'); ?> — <?php echo $this->title; ?><?php if ($this->page > 1) { ?> (Seite <?php echo $this->page; ?>)<?php } ?></title>
<?php
	include 'includes/prebody.php';
?>
				<div class="section lettering">
					<p>Archiv für <?php echo TimestampFormatter::format($this->timestamp, '%germanMonthName% %year%'); ?></p>
				</div>
<?php
	include 'includes/posts.php';
	include 'includes/foot.php';
?>