<?php
	include 'includes/head.php';
?>
		<title>Kategorie hinzufügen — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2>Kategorie hinzufügen</h2>
					</div>
<?php
	if ($this->failed)
	{
?>
					<div class="section failure">
						<p>Kategorie nicht erstellt</p>
					</div>
<?php
	}
	if ($this->written)
	{
?>
					<div class="section success">
						<p>Kategorie erfolgreich erstellt</p>
					</div>
<?php
	}
?>
					<div class="section">
<?php
	if ($this->invalidId)
	{
?>
						<p class="failure">ID unzulässig</p>
<?php
	}
	if ($this->idTaken)
	{
?>
						<p class="failure">ID bereits vergeben</p>
<?php
	}
?>
						<p>
							<label>
								<input name="id" type="text" pattern="<?php echo $this->idPattern; ?>" title="Maximal 200 Kleinbuchstaben, Ziffern und Bindestriche erlaubt"<?php if ($this->failed) { ?> value="<?php echo XSSFilter::filter($this->category->id); ?>"<?php } ?> required autofocus />
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
								<input name="title" type="text" pattern="<?php echo $this->titlePattern; ?>" title="Maximal 200 Zeichen erlaubt"<?php if ($this->failed) { ?> value="<?php echo XSSFilter::filter($this->category->title); ?>"<?php } ?> required />
								Titel
							</label>
						</p>
					</div>
					<div class="section">
						<p>
							<input type="submit" value="Speichern" class="section" />
						</p>
					</div>
				</form>
<?php
	include 'includes/foot.php';
?>
