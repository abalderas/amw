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
					<th>Evaluator</th>
				</tr>
			</thead>

			<tbody>
			<?php foreach ($metaevaluacion as $i) { ?>
				<tr>
					<td>
						<?php echo $usuario[$i];?>
					</td>

					<td>
						<center>
						<?php echo $calificacion_mev[$i] *100/5 ."%" ;?> <!-- Se tiene que dividir entre el numero de opciones en previa_evaluacion	 -->
						</center>
					</td>

					<td>
						<?php echo $comentario_mev[$i];?>
					</td>

					<td>
						<?php echo anchor_popup(wiki_revision_url($edicion[$i]), 'url'); ?>
					</td>

					<td>
						<?php
							foreach ($criterio_eva[$i] as $key) {
								echo $key . "<br>";
							}
						?>
					</td>
					
					<td>
						<center>
						<?php
							foreach ($calificacion_eva[$i] as $key) {
								echo $key . "<br>";
							}
						?>
						</center>
					</td>

					<td>
						<?php
							foreach ($descripcion_eva[$i] as $key) {
								echo $key . "<br>";
							}
						?>
					</td>

					<td>
						<?php echo $evaluador[$i];?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>	
	
</div>


