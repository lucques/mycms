<?php
	if ($this->contains('unusedCategoriesWidget'))
	{
		$iterator = $this->unusedCategoriesWidget->iterator();
?>
				<div class="section">
					<h3>Ungenutzte Kategorien</h3>
					<table class="large">
						<thead>
							<tr>
								<th>Titel</th>
								<th class="small">Bearbeiten</th>
								<th class="small">Löschen</th>
							</tr>
						</thead>
						<tbody>
<?php
		while ($iterator->hasNext())
		{
			$category = $iterator->next();
?>
							<tr>
								<td><?php echo $category->title; ?></td>
								<td><?php if ($category->containsKey('editPath')) { html_link($this, 'Bearbeiten', $category->editPath, 'class="administrative"'); } ?></td>
								<td><?php if ($category->containsKey('deletePath')) { html_link($this, 'Löschen', $category->deletePath, 'class="administrative"'); } ?></td>
							</tr>
<?php
		}
?>
						</tbody>
					</table>
				</div>
<?php
	}
