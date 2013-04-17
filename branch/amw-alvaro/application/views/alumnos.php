<h2>List of students</h2>

<?=form_open('configuration/setroles')?>
<?php $options = array('student' => 'Student', 'referee' => 'Referee', 'meta' => 'MetaEvaluator', 'metameta' => 'Meta²evaluator'); ?>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th>Students</th>
			<th>Report</th>
			<th>CSV</th>
			<th>Roles  &nbsp;&nbsp;&nbsp; <?=form_submit('submit', 'Save Roles')?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($alumnos as $key => $value) { ?>
	<tr>
		<td><?php echo $alumnos[$key]; ?></td>
		<td><?php echo anchor(site_url("feedback/informe/" . $key), "Report"); ?></td>
		<td><?php echo anchor(site_url("feedback/csv/" . $key), "CSV"); ?></td>
		<td><?php echo form_dropdown("select_role_$key", $options, $this->roles_model->getrole($value), "id = 'select_role_$key'"); ?></td>
	</tr>
<?php } ?>
	</tbody>
</table>

<?=form_close()?>