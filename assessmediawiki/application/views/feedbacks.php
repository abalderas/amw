<h1>List of revisions</h1>

<?php

?>

<br />
<table>
	<tr class="head">
		<td>Revision</td><td>Show</td>
	</tr>
	<?php
	foreach($articulos as $id => $value)
	{
	?>
	
	<tr>
		<td>
	<?php
		echo $value;
	?>
		</td>
		<td>
	<?php echo anchor(site_url("evaluar/mostrar_evaluacion/" . $id), "Report (" . $this->replies->replies_amount($id) .")"); ?> 
		</td>
	</tr>
	<?php
	}
	?>
</table>
<h5>* In brackets the number of replies</h5>
