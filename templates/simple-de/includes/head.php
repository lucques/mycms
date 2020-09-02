<?php
	include 'functions.php';

	$this->setContentType('text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
	<head>
		<meta charset="utf-8" />
		<link rel="alternate" type="application/rss+xml" title="Feed" href="/feed/" />
		<link rel="shortcut icon" href="<?php echo $this->root; ?>favicon.ico" />
		<link rel="stylesheet" href="<?php echo $this->templatePath; ?>css/layout.css" />
		<!-- Workaround for old Internet Explorers to handle HTML5 (http://code.google.com/p/html5shiv/) -->
		<!--[if lt IE 9]>
		<script src="<?php echo $this->templatePath; ?>js/html5shiv.js"></script>
		<![endif]-->
