<h1>AssessMediaWiki</h1>
<?php echo form_fieldset('Resumen'); ?>
<table>
	<tr>
		<td>Usuario</td>
		<td><?php echo $usuario; ?></td>
		<td></td>
	</tr>
	<tr>
		<td>Enlace</td>

		<td>http://osl2.uca.es/wikiASO/index.php?oldid=<?php echo $entrada; ?>&diff=prev</td>
		<td></td>
	</tr>
	<tr class="head">
		<td>Entregable</td>
		<td>Nota</td>
		<td>Comentario</td>
	</tr>
	<?php
		foreach ($entregables as $i => $valor)
		{
	?>	
	<tr>
		<td><?php echo $entregables[$i]; ?></td> 
		<td><?php echo $puntuacion[$i]; ?></td>
		<td><?php echo $comentarios[$i]; ?></td>		
	</tr>
	<?php
		}
	?>
</table>
    <?php echo form_fieldset_close(); ?>

<p>Para comprobar otro enlace pinche aquí --> <?php echo anchor(site_url("evaluar/index"), "Continuar"); ?></p>

