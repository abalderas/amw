<h1>List of students</h1>
<br />
<table>
	<tr class="head">
		<td>Students</td><td>Report</td><td>CSV</td>
	</tr>
	<?php
		
		//for ($i=0; $i<sizeof($alumnos); $i++)
		foreach ($alumnos as $key => $value)
		{
	?>
	<tr>
		<td><?php echo $alumnos[$key]; ?></td>
		<td><?php echo anchor(site_url("feedback/informe/" . $key), "Report"); ?></td>
		<td><?php echo anchor(site_url("feedback/csv/" . $key), "csv"); ?></td>
	</tr>
	<?php
		}
	?>
</table>
