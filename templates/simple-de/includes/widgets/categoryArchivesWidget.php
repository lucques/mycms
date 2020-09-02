<?php
	if ($this->contains('categoryArchivesWidget'))
	{
?>
				<h2>Kategorien</h2>
				<ul>
<?php
		$iterator = $this->categoryArchivesWidget->iterator();

		while ($iterator->hasNext())
		{
			$category = $iterator->next();
?>
					<li>
						<?php html_link($this, $category->title, $category->path); ?> (<?php echo $category->numberOfPosts; ?>)
<?php
			if ($category->containsKey('editPath'))
			{
?>
						<span class="meta">· <?php html_link($this, 'Bearbeiten', $category->editPath, 'class="administrative"'); ?></span>

<?php
			}
			if ($category->containsKey('deletePath'))
			{
?>
						<span class="meta">· <?php html_link($this, 'Löschen', $category->deletePath, 'class="administrative"'); ?></span>

<?php
			}
?>
					</li>
<?php
		}
?>
				</ul>
<?php
	}
