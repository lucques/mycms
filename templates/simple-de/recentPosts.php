<?php
	include 'includes/head.php';
?>
		<title><?php echo $this->title; ?><?php if ($this->page > 1) { ?> (Seite <?php echo $this->page; ?>)<?php } ?></title>
<?php
	include 'includes/prebody.php';
	include 'includes/posts.php';
	include 'includes/foot.php';
?>
