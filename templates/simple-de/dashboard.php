<?php
	include 'includes/head.php';
?>
		<title>Dashboard — <?php echo $this->title; ?></title>
		<script src="<?php echo $this->templatePath; ?>js/dojo.js"></script>
<?php
	include 'includes/prebody.php';
?>
				<div class="section">
					<h2>Dashboard</h2>
					<p>
						Hi, willkommen auf dem Dashboard!
					</p>
				</div>
<?php
	include 'includes/widgets/statisticsWidget.php';
	include 'includes/widgets/unpublishedPostsWidget.php';
	include 'includes/widgets/staticPostsWidget.php';
	include 'includes/widgets/unusedCategoriesWidget.php';
	include 'includes/widgets/recentCommentsWidget.php';
	include 'includes/foot.php';
?>
