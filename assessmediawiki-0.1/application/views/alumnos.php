<h1>Listado de alumnos</h1>
<br />
<table>
	<tr class="head">
		<td>Alumnos</td><td>CVS</td>
	</tr>
	<?php
		
		//for ($i=0; $i<sizeof($alumnos); $i++)
		foreach ($alumnos as $key => $value)
		{
	?>
	<tr>
		<td><?php echo $alumnos[$key]; ?></td>
		<td><?php echo anchor(site_url("feedback/informe/" . $key), "Informe"); ?></td>
	</tr>
	<?php
		}
	?>
</table>