<h1>List of evaluation criteria</h1>
<br />
<?php
	echo anchor('params/add', '+ Add', 'title="New criteria"');
	echo "&nbsp;&nbsp" . anchor('params/csv', 'CSV', 'title="CSV"');
	echo br(2);
?>
<table>
	<tr class="head">
		<td>Criteria</td><td>Actions</td>
	</tr>
	<?php
		
		//for ($i=0; $i<sizeof($alumnos); $i++)
		foreach ($tests as $key => $value)
		{
	?>
	<tr>
		<td><?php echo $tests[$key]; ?></td>
		<td><?php echo anchor(site_url("params/edit/" . $key), "Edit"); ?>
			<?php 
			echo anchor(site_url("params/delete/" . $key), "Del"); 
			?>
			<!-- <a href="http://localhost/evalmediawiki/index.php/params/delete/<?php echo $key . '"'; ?> class="delete-link">Del</a> -->
			</td>
	</tr>
	<?php
		}
	?>
</table>
 
<h1>Other parameters</h1>
<form method="POST" action="params">

	<div>
		<label>Category
			<input type="text" name="categoria" value="<?php echo $categoria; ?>" /></label>
	</div>

	<div>
		<label>Start date (format is yyyymmddhhmmss)
			<input type="text" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>"></label>
	</div>

	<div>
		<label>End date (format is yyyymmddhhmmss)
			<input type="text" name="fecha_fin" value="<?php echo $fecha_fin; ?>"></label>
	</div>

	<input type="submit" value="Modify parameters" />
</form>
 
<div id="question" style="display:none; cursor: default"> 
        <h1>Would you like to contine?.</h1> 
        <input type="button" id="yes" value="Yes" /> 
        <input type="button" id="no" value="No" /> 
</div> 
