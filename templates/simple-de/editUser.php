<?php
	include 'includes/head.php';
?>
		<title>Benutzer bearbeiten — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';
?>
				<form action="<?php echo $this->path; ?>" method="post">
					<div class="section">
						<h2 class="with-subline">Benutzer bearbeiten</h2>
					</div>
<?php
	if ($this->failed)
	{
?>
					<div class="section failure">
						<p>Benutzer nicht aktualisiert</p>
					</div>
<?php
	}
	if ($this->edited)
	{
?>
					<div class="section success">
						<p>Benutzer erfolgreich aktualisiert</p>
					</div>
<?php
	}
?>

					<div class="section">
						<p>
							<label>
								<input name="id" type="text" value="<?php echo XSSFilter::filter($this->user->id); ?>" readonly />
								ID
							</label>
						</p>
<?php
	if ($this->invalidNick)
	{
?>
						<p class="failure">Name unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="nick" type="text" pattern="<?php echo $this->nickPattern; ?>" title="Maximal 100 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->user->nick); ?>" required />
								Name
							</label>
						</p>
<?php
	if ($this->invalidEmail)
	{
?>
						<p class="failure">E-Mail unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="email" type="email" title="Maximal 200 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->user->email); ?>" required />
								E-Mail
							</label>
						</p>
<?php
	if ($this->invalidWebsite)
	{
?>
						<p class="failure">Website unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="website" type="url" title="Maximal 400 Zeichen erlaubt" value="<?php echo XSSFilter::filter($this->user->website); ?>" required />
								Website
							</label>
						</p>
					</div>
					<div class="section">
						<h3>Passwort ändern</h3>
						<p>
							<label>
								<input name="change_password" type="checkbox"<?php if ($this->user->containsKey('passwordConfirmation')) { ?> checked<?php } ?> />
								Passwort ändern?
							</label>
						</p>
<?php
	if ($this->invalidPassword)
	{
?>
						<p class="failure">Passwort unzulässig</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="password" type="password" pattern="<?php echo $this->passwordPattern; ?>" title="Mindestens 8, maximal 100 Zeichen erlaubt"<?php if ($this->user->containsKey('passwordConfirmation')) { ?> value="<?php echo XSSFilter::filter($this->user->password); ?>"<?php } ?> />
								Passwort
							</label>
						</p>
<?php	
	if ($this->passwordsMismatch)
	{
?>
						<p class="failure">Passwörter stimmen nicht überein</p>
<?php	
	}
?>
						<p>
							<label>
								<input name="password_confirmation" type="password" pattern="<?php echo $this->passwordPattern; ?>" title="Mindestens 8, maximal 100 Zeichen erlaubt"<?php if ($this->user->containsKey('passwordConfirmation')) { ?> value="<?php echo XSSFilter::filter($this->user->passwordConfirmation); ?>"<?php } ?>  />
								Passwort bestätigen
							</label>
						</p>
					</div>
					<div class="section">
						<p>
							<input type="submit" value="Speichern" />
						</p>
					</div>
				</form>
<?php
	include 'includes/foot.php';
?>
