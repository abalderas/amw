<h1>Listado de revisiones de mis artículos</h1>

<?php

?>

<br />
<table>
	<tr class="head">
		<td>Artículo</td><td>Entrar</td>
	</tr>
	<?php
	foreach($articulos as $id => $valor)
	{
	?>
	
	<tr>
		<td>
	<?php
		echo $valor;
	?>
		</td>
		<td>
	<?php echo anchor(site_url("evaluar/mostrar_evaluacion/" . $id), "Informe"); ?>
		</td>
	</tr>
	<?php
	}
	?>
</table>
