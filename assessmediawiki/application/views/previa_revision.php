
<?php	
	if (!isset($evaluaciones_pendientes) || $evaluaciones_pendientes>0)
	{	
		echo anchor_popup("http://wikis.uca.es/wikiASO/index.php?oldid=" . $entrada . "&diff=prev", "url to assess");
?>
<br />
<br />
<hr />
<p><?php echo $msg; ?></p>

<?php echo form_open($post_url); ?>
    <?php echo form_fieldset('Grading'); ?>

        <div class="textfield">           
			<?php
				$options = array();
				for ($i = 0; $i<=10; $i++)
					array_push($options, $i);
			?>
			<table>
				<tr class="head">
					<td colspan='2'>Revision</td>
					<td>Grade</td>
					<td>Description</td>
				</r>
			<?php
				foreach ($campos as $i => $valor)
				{
				?>
				<tr>
					<td><?php echo form_checkbox('campo['.$i.']'); ?></td>
					<td><?php echo form_label($valor, $valor); ?></td>
					<td><?php echo form_dropdown('puntuacion['.$i.']', $options); ?></td>
					<?php
						$info_descripcion = array(
							'name' => 'descripcion['.$i.']',
							'size' => '40',
							'maxlength' => '250');
					?>
					<td><?php echo form_input($info_descripcion); ?></td>
				<tr>
				<tr>
					<td></td>
					<td><p class="description"><?php echo $descriptions[$i]; ?></p></td>
					<td  colspan="2"></td>
				</tr>
				<?php
				}
			?>
			</table>
			<?php echo form_hidden('entrada', $entrada); ?>
			<?php echo form_hidden('user_id', $usuario_a_revisar); ?>
			<?php
				// Tiempo en el que se entra en el formulario.
				// Utilizado para saber el tiempo dedicado a rellenar.
				echo form_hidden('time', time());
			?>
			<?php
				// In case of reply.
				if (isset($evaluacion))
					echo form_hidden('rep_read', $evaluacion); 
			?>
        </div>

        <div class="buttons">
            <?php echo form_submit('puntuar', 'Puntuar'); ?>
        </div>

    <?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
<?php
		} // Fin evaluaciones pendientes
	
?>
