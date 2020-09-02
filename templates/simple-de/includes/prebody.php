	</head>
	<body>
		<nav id="accessibility">
			<ul>
				<li><a href="#content">Zum Inhalt</a></li>
				<li><a href="#navigation">Zur Navigation</a></li>
			</ul>
		</nav>
		<div id="wrapper">
			<header>
				<img id="logo" src="<?php echo $this->root; ?>images/logo.png" alt="<?php echo $this->title; ?>" width="105" height="101" />
				<h1 id="title"><?php echo $this->title; ?></h1>
				<p id="description"><?php echo $this->description; ?></p>
			</header>
			<nav id="top-nav">
				<ul>
<?php
	include 'custom/navigation.php';
?>
				</ul>
			</nav>
			<div id="sidebar">
<?php
	if ($this->contains('dashboardPath') ||
	    $this->contains('addPostPath') ||
	    $this->contains('addCategoryPath') ||
	    $this->contains('logoutPath'))
	{
?>
				<h2>Administration</h2>
				<ul>
					<?php if ($this->contains('dashboardPath')) { ?><li><?php html_link($this, 'Dashboard', $this->dashboardPath); ?></li><?php } ?>

					<?php if ($this->contains('addPostPath')) { ?><li><?php html_link($this, 'Neuer Post', $this->addPostPath); ?></li><?php } ?>

					<?php if ($this->contains('addCategoryPath')) { ?><li><?php html_link($this, 'Neue Kategorie', $this->addCategoryPath); ?></li><?php } ?>

					<?php if ($this->contains('editUserPath')) { ?><li><?php html_link($this, 'Benutzer bearbeiten', $this->editUserPath); ?></li><?php } ?>

					<?php if ($this->contains('editSettingsPath')) { ?><li><?php html_link($this, 'Einstellungen', $this->editSettingsPath); ?></li><?php } ?>

					<?php if ($this->contains('logoutPath')) { ?><li><?php html_link($this, 'Logout', $this->logoutPath); ?></li><?php } ?>

				</ul>
<?php
	}

	include 'widgets/categoryArchivesWidget.php';
	include 'widgets/yearMonthArchivesWidget.php';
	include 'custom/sidebar.php';
?>
			</div>
			<div id="content">
