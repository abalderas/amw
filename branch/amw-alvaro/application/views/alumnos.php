<h2>List of students</h2>

<?=form_open('configuration/setroles')?>
<?php $options = array('student' => 'Student', 'referee' => 'Referee', 'meta' => 'MetaEvaluator', 'metameta' => 'Meta²evaluator'); ?>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th style = 'vertical-align:top;'>Students</th>
			<th style = 'vertical-align:top;'>Report</th>
			<th style = 'vertical-align:top;'>CSV</th>
			<th style = 'vertical-align:top;'>Replies <br> <?=anchor(site_url("feedback/replies/"), "View All")?></th>
			<th style = 'width:60%;'>Roles <br> <?=form_submit('submit', 'Save Roles')."&nbsp;Set all to: ".form_submit('submit_student', 'Student').form_submit('submit_referee', 'Referee').form_submit('submit_meta', 'Meta-Evaluator').form_submit('submit_metameta', 'Meta²evaluator')?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($alumnos as $key => $value) { ?>
	<tr>
		<td><?php echo $alumnos[$key]; ?></td>
		<td><?php echo anchor(site_url("feedback/informe/" . $key), "Report"); ?></td>
		<td><?php echo anchor(site_url("feedback/csv/" . $key), "CSV"); ?></td>
		<td><?php echo anchor(site_url("feedback/replies_in/" . $key), "Replies In")."<br>".anchor(site_url("feedback/replies_out/" . $key), "Replies Out"); ?></td>
		<td style = 'width:60%;'><?php echo form_dropdown("select_role_$key", $options, end($this->roles_model->getroles($value)), "id = 'select_role_$key'"); ?></td>
	</tr>
<?php } ?>
	</tbody>
</table>

<?=form_close()?>