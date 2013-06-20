<?php	
	if (!isset($metaevaluaciones_pendientes) || $metaevaluaciones_pendientes > 0)
	{	

?>
<p><?php echo $msg . " " . anchor_popup(wiki_revision_url($edicion), "This is the url assessed");?>.</p>

<?php echo form_open($post_url); ?>
    <div class="textfield">           
		<?php
			$options = array("","1) Very bad", "2) Bad", "3) Regular", "4) Good", "5) Very good");
		?>	

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
					foreach ($criterio as $key) {
						echo $key . "<br>";
					}
					?>
				</td>
				<td>
					<?php
					foreach ($calificacion as $key) {
						echo $key . "<br>";
					}
					?>
				</td>

				<td>
					<?php
					foreach ($descripcion as $key) {
						echo $key . "<br>";
					}
					?>
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
					<?=form_dropdown('puntuacion', $options);?>
				</td>
		
				<?php
					$info_comentario = array(
						'name' => 'comentario',
						'size' => '40',
						'maxlength' => '250');
				?>
				<td><?php echo form_input($info_comentario);?></td>
			</tr>

			</tbody>
		</table>
		<?php
			// ID of the evaluation.
				echo form_hidden('id_evaluation', $evaluacion); 
		?>
		<?php echo form_hidden('edicion', $edicion); ?>
		<?php
			// Tiempo en el que se entra en el formulario.
			// Utilizado para saber el tiempo dedicado a rellenar.
			echo form_hidden('time', time());
		?>
		<?php
			// In case of reply.
			if (isset($metaevaluacion))
				echo form_hidden('rep_read', $metaevaluacion); 
		?>
    </div>

    <div class="buttons">
        <?php echo form_submit('puntuar', 'Metaevaluar'); ?>
    </div>

<?php echo form_close(); ?>	

<?php
		} // Fin metaevaluaciones metaevaluaciones_pendientes
	
?>
