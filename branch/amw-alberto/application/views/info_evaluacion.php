<h2>Summary of metaevaluation</h2>

<div class="row">
	<div class="span3">
		<ul>
			<li>Author:
			<?php echo $usuario; ?></li>
		
			<li>Evaluacion ID: <?php echo $evaluacion; ?></li>
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
					<?php echo $criterio_eva;?>
				</td>

				<td>
					<?php echo $calificacion_eva;?>
				</td>

				<td>
					<?php echo $descripcion_eva;?>
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


