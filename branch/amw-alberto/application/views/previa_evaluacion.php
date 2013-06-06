<?php	
	if (!isset($metaevaluaciones_pendientes) || $metaevaluaciones_pendientes > 0)
	{	

?>
<p><?php echo $msg . " " . anchor_popup(wiki_revision_url($entrada), "This is the url to assess");?>.</p>
    <div class="textfield">           
		<?php
			$options = array("Very good", "Good", "Not bad", "Bad", "Very bad");
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
						<?php echo "Criterio evaluado";?>
				</td>
				<td>
					<?php echo "La nota que le pusieron"; ?>
				</td>

				<td><?php echo "Descripcion";?></td>
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
		<?php echo form_hidden('entrada', $entrada); ?>
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
        <?php echo form_submit('puntuar', 'Puntuar'); ?>
    </div>

<?php echo form_close(); ?>	

<?php
		} // Fin metaevaluaciones pendientes (Necesito un script o algo que lanze la funcion)
	
?>
