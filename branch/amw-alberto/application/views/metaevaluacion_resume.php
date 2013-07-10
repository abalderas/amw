<h2>Metaevaluations resume</h2>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th>Student</th>
			<th>Nota Media</th>
			<th>Otra cosa</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo $alumnos; ?></td>
		<td>aqui saldra la nota media</td>
		<td>aqui saldra otra cosa</td>
	</tr>
	</tbody>
</table>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th>Metaevaluations recived</th>
			<th>Metaevaluations made</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo anchor(site_url("feedback/metaevaluaciones_recibidas/" . $id), "Meta-evaluations recived"); ?></td>
		<td><?php echo anchor(site_url("feedback/metaevaluaciones_realizadas/" . $id), "My meta-evaluations"); ?></td>
	</tr>
	</tbody>
</table>