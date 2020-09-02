<?php
	if ($this->contains('statisticsWidget'))
	{
?>
				<div class="section">
					<h3>Statistik</h3>
					<table>
						<thead>
							<tr>
								<th>Datentyp</th>
								<th>Anzahl</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Posts</td>
								<td><?php echo $this->statisticsWidget->posts ?></td>
							</tr>
							<tr>
								<td>Kategorien</td>
								<td><?php echo $this->statisticsWidget->categories ?></td>
							</tr>
							<tr>
								<td>Kommentare</td>
								<td><?php echo $this->statisticsWidget->comments ?></td>
							</tr>
						</tbody>
					</table>
				</div>
<?php
	}
