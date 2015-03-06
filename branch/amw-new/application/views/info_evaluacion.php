<h2>Summary of metaevaluations</h2>
<div class="row">
	<div class="span3">
		<ul>
			<li>Author of the m.evaluation: <?php echo $usuario; ?></li>
			<li>Revision link: <?php echo anchor_popup(wiki_revision_url($edicion), 'url'); ?></li>
		
		</ul>
	</div>
	
	<div class="span8 offset1">
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr class="head">
					<th>Criterion</th>
					<th>Grade</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>

			<tr>
				<td>
					<?php
					foreach ($criterio_eva as $key) {
						echo $key . "<br>";
					}
					?>
				</td>

				<td>
					<?php
					foreach ($calificacion_eva as $key) {
						echo $key . "<br>";
					}
					?>
				</td>

				<td>
					<?php
					foreach ($descripcion_eva as $key) {
						echo $key . "<br>";
					}
					?>
				</td>
			</tr>

			</tbody>
		</table>

		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr class="head">
					<th>Calification</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>	
			<tr>

				<td>
					<?php echo $calificacion_mev;?>
				</td>

				<td>
					<?php echo $comentario_mev;?>
				</td>
			</tr>

			</tbody>
		</table>
	</div>
</div>


