<?php
	include 'includes/head.php';
?>
		<title>Login — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2>Login</h2>
					</div>
<?php
	if ($this->loginFailed)
	{
?>
					<div class="section failure">
						<p>Login schlug fehl</p>
					</div>
<?php
	}
?>
					<div class="section">
<?php
	if ($this->invalidId)
	{
?>
						<p class="failure">Benutzer-ID ist nicht valide.</p>
<?php
	}
?>
						<p>
							<label>
								<input name="id" type="text" pattern="<?php echo $this->idPattern; ?>" title="Maximal 200 Kleinbuchstaben, Ziffern und Bindestriche erlaubt"<?php if ($this->contains('id')) { ?> value="<?php echo $this->id; ?>"<?php } ?> required autofocus />
								ID
							</label>
						</p>
						<p>
							<label>
								<input name="password" type="password" required />
								Passwort
							</label>
						</p>
						<p>
							<input type="submit" value="Login" />
						</p>
					</div>
				</form>
<?php
	include 'includes/foot.php';
?>
