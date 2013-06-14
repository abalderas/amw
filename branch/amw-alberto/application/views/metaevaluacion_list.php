<h2>List of metaevaluations</h2>
<h4>There are a total of <?php echo $total;?> metaevaluations done: </h4>
<div class="row">

	<div class="span8 offset1">
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr class="head">
					<th>Metaevaluator</th>
					<th>Metaevaluation grade</th>
					<th>Metaevaluation comments</th>
					<th>URL</th>
					<th>Criterion</th>
					<th>Evaluation grade</th>
					<th>Evaluation description</th>
				</tr>
			</thead>

			<tbody>
			<?php foreach ($metaevaluacion as $i) { ?>
				<tr>
					<td>
						<?php echo $usuario[$i];?> <!-- Cambiar para que muestre el nombre del usuario y no el id -->
					</td>

					<td>
						<?php echo $calificacion_mev[$i];?>
					</td>

					<td>
						<?php echo $comentario_mev[$i];?>
					</td>

					<td>
						<?php echo anchor_popup(wiki_revision_url($edicion[$i]), 'url'); ?>
					</td>

					<td>
						<?php echo $criterio_eva[$i];?>
					</td>
					
					<td>
						<?php echo $calificacion_eva[$i];?>
					</td>

					<td>
						<?php echo $descripcion_eva[$i];?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>	
	
</div>


