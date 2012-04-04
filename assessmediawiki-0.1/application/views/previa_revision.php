<h1>EvalMediaWiki</h1>
<?php
	if (isset($entrada))
	{
?>
<p>Hola <?php echo $usuario; ?>
<?php
/*
		if (isset($evaluaciones_pendientes))
		{
			echo ", tienes " . $evaluaciones_pendientes . " artículos pendientes de revisar";
			if ($evaluaciones_pendientes > 0)
				echo ", las entrada del wiki que tienes que revisar se encuentra en el siguiente enlace:  ";
		}
		else
			echo ", las entrada del wiki que tienes que revisar se encuentra en el siguiente enlace:  ";
*/
?>
</p>
<?php
	if (1) {
		echo "El periodo de evaluaci&oacute;n ha finalizado.";
	}
	else if (!isset($evaluaciones_pendientes) || $evaluaciones_pendientes>0)
	{	
		echo anchor_popup("http://osl2.uca.es/wikiASO/index.php?oldid=" . $entrada . "&diff=prev");
?>
<br />
<br />
<hr />
<p>Revise el enlace arriba indicado comparando dos entradas consecutivas del Wiki y después puntúe en la parte inferior.</p>

<?php echo form_open('evaluar/procesar'); ?>
    <?php echo form_fieldset('Puntuación'); ?>

        <div class="textfield">           
			<?php
				$options = array();
				for ($i = 0; $i<=10; $i++)
					array_push($options, $i);
			?>
			<table>
				<tr class="head">
					<td colspan='2'>Entregables</td>
					<td>Nota</td>
					<td>Descripción</td>
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
				<?php
				}
			?>
			</table>
			<?php echo form_hidden('entrada', $entrada); ?>
			<?php echo form_hidden('user_id', $usuario_a_revisar); ?>
        </div>

        <div class="buttons">
            <?php echo form_submit('puntuar', 'Puntuar'); ?>
        </div>

    <?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
<?php
		} // Fin evaluaciones pendientes
	}
	
	else
	{
	?>
<p>Hola <?php echo $usuario; ?>, en este momento no hay entradas para revisar. Inténtelo en otro momento. </p>
	<?php	
	}
?>
