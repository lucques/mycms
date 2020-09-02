<?php
	include 'includes/head.php';
?>
		<title><?php echo $this->post->title; ?> — <?php echo $this->title; ?></title>
<?php
	include 'includes/prebody.php';

	if ($this->commentFailed)
	{
?>
				<div class="section failure">
					<p>Dein Kommentar konnte leider nicht eingetragen werden!</p>
				</div>
<?php
	}
	if ($this->commentWritten)
	{
?>
				<div class="section success">
					<p>Danke für deinen Kommentar!</p>
				</div>
<?php
	}

	$withSubline = $this->post->showAuthor || $this->post->showTimestamp || $this->post->containsKey('editPath') || $this->post->containsKey('deletePath');
?>
				<article class="section">
					<h2<?php if ($withSubline) { ?> class="with-subline"<?php } ?>><?php if ($this->post->showLink) { html_link($this, $this->post->title, $this->post->path); } else { echo $this->post->title; } ?></h2>
<?php
	if ($withSubline)
	{
		$empty = true;
?>
					<p class="subline meta">
<?php
		if ($this->post->showAuthor)
		{
?>
						Von <?php if ($this->post->author->website != '') { html_link($this, $this->post->author->nick, $this->post->author->website); } else { echo $this->post->author->nick; } ?>

<?php
			$empty = false;
		}
		if ($this->post->showTimestamp)
		{
?>
						<?php if (!$empty) { ?>am <?php } else { ?>Am <?php } ?><time datetime="<?php iso_8601_timestamp($this->post->timestamp, $this->timeZoneOffset, $this->timeZoneOffsetInDST); ?>" pubdate><?php echo TimestampFormatter::format($this->post->timestamp, '%dayWithLeadingZero%.%monthWithLeadingZero%.%year%, %hourWithLeadingZero%:%minuteWithLeadingZero% Uhr'); ?></time>
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
<?php
	}
?>
					<?php echo str_replace('<!--more-->', '<span id="more"></span>', $this->post->content); ?>

<?php
	if ($this->post->categories->size() > 0)
	{
?>
					<p class="meta">
						Kategorien:
<?php
		$categoryIterator = $this->post->categories->iterator();

		while ($categoryIterator->hasNext())
		{
			$category = $categoryIterator->next();
?>
						<?php html_link($this, $category->title, $category->path); ?><?php if ($categoryIterator->hasNext()) { ?>,<?php } ?>

<?php
		}
?>
					</p>
<?php
	}
?>
				</article>
<?php
	if ($this->post->showComments)
	{
?>
				<div class="section">
					<h3>Kommentare</h3>
<?php
		if ($this->post->comments->size() > 0)
		{
?>
					<ul>
<?php
			$commentIterator = $this->post->comments->iterator();

			while	($commentIterator->hasNext())
			{
				$comment = $commentIterator->next();
?>
						<li id="comment-<?php echo $comment->id; ?>">
							<p>
								<?php if ($comment->website != '') { html_link($this, XSSFilter::filter($comment->nick), XSSFilter::filter($comment->website)); } else { echo XSSFilter::filter($comment->nick); } ?>

								<span class="meta">
									am <span class="timestamp"><?php echo TimestampFormatter::format($comment->timestamp, '%dayWithLeadingZero%.%monthWithLeadingZero%.%year%'); ?></span>
<?php
				if ($comment->containsKey('editPath'))
				{
?>
									· <?php html_link($this, 'Bearbeiten', $comment->editPath, 'class="administrative"'); ?>

<?php
				}
				if ($comment->containsKey('deletePath'))
				{
?>
									· <?php html_link($this, 'Löschen', $comment->deletePath, 'class="administrative"'); ?>

<?php
				}
?>
								</span>
							</p>
							<p>
								<?php echo str_replace("\n", '<br/>', XSSFilter::filter($comment->content)); ?> 
							</p>
						</li>
<?php
			}
?>
					</ul>
<?php
		}
		else
		{
?>
					<p>Noch keine Kommentare bisher</p>
<?php
		}
?>
				</div>
<?php
	}

	if ($this->post->allowComments)
	{
?>
				<div class="section">
					<form action="<?php echo $this->path; ?>" method="post">
						<h3>Schreibe deinen eigenen Kommentar</h3>
<?php
		if ($this->invalidNick)
		{
?>
						<p class="failure">Name ist nicht valide.</p>
<?php
		}
?>
						<p>
							<label>
								<input name="nick" type="text"<?php if ($this->commentFailed) { ?> value="<?php echo XSSFilter::filter($this->commentForm->nick); ?>"<?php } ?> required />
								Name
							</label>
						</p>
<?php
		if ($this->invalidEmail)
		{
?>
						<p class="failure">E-Mail ist nicht valide.</p>
<?php
		}
?>
						<p>
							<label>
								<input name="email" type="email"<?php if ($this->commentFailed) { ?> value="<?php echo XSSFilter::filter($this->commentForm->email); ?>"<?php } ?> required />
								E-Mail
							</label>
						</p>
<?php
		if ($this->invalidWebsite)
		{
?>
						<p class="failure">Website ist nicht valide.</p>
<?php
		}
?>
						<p>
							<label>
								<input name="website" type="url"<?php if ($this->commentFailed) { ?> value="<?php echo XSSFilter::filter($this->commentForm->website); ?>"<?php } ?> />
								Website (optional)
							</label>
						</p>
<?php
		if ($this->invalidContent)
		{
?>
						<p class="failure">Inhalt ist nicht valide.</p>
<?php
		}
?>
						<p>
							<label>
								<textarea name="content" rows="10" required><?php if ($this->commentFailed) { ?><?php echo XSSFilter::filter($this->commentForm->content); ?><?php } ?></textarea>
							</label>
						</p>
<?php
		if ($this->contains('captcha'))
		{
			if ($this->invalidCaptcha)
			{
?>
						<p class="failure">Das Captcha wurde nicht korrekt gelöst.</p>
<?php
			}
?>
						<p>
							<label>
								<input name="captcha_input" type="text" required />
								Was ist <?php if ($this->captcha->operator == '+')
									        echo 'die Summe';
									      else if ($this->captcha->operator == '-')
									        echo 'die Differenz';
									      else if ($this->captcha->operator == '*')
									        echo 'das Produkt';
									      else if ($this->captcha->operator == '/')
									        echo 'der Quotient';
								        ?> von <?php echo $this->captcha->a; ?> und <?php echo $this->captcha->b; ?>?
							</label>
						</p>
<?php
		}
?>
						<p>
<?php
		if ($this->contains('captcha'))
		{
?>
							<input name="captcha_answer" type="hidden" value="<?php echo $this->captcha->answer; ?>" />
<?php
		}
?>
							<input type="submit" value="Senden" />
						</p>
					</form>
				</div>
<?php
	}

	include 'includes/foot.php';
?>
