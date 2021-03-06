<h2>List of replies<?=isset($student)? " : ".$this->acceso_model->username($student) : ""?></h2>

<?=form_open('evaluar/resolver_replies')?>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>User</th>
			<th>Revisor</th>
			<th>Revision</th>
			<th>Grade</th>
			<th>Comment</th>
			<th>Status</th>
<?if(in_array('referee', $this->roles_model->getroles($this->session->userdata('username')))) {?>
			<th>Arbitrate</th>
<?}?>
			
		</tr>
	</thead>
	<tbody>
	
<?php if($replies) 
	foreach ($replies as $replie) { ?>
	<tr>
		<td><?php echo $replie['rep_id']; ?></td>
		<td><?php echo $this->acceso_model->username($replie['eva_user']); ?></td>
		<td><?php echo $this->acceso_model->username($replie['eva_revisor']);  ?></td>
		<td><?php echo $replie['eva_revision'];  ?></td>
		<td><?php echo $replie['ee_nota'];  ?></td>
		<td><?php echo $replie['ee_comentario'];  ?></td>
		<td><?php echo $replie['rep_status'];  ?></td>
<?if(in_array('referee', $this->roles_model->getroles($this->session->item('username')))) {?>
		<td><?php echo anchor("evaluar/resolver_reply/accept/".$replie['rep_id'], 'Accept Reply')."&nbsp".anchor("evaluar/resolver_reply/deny/".$replie['rep_id'], 'Deny Reply');?></td>
<?}?>
	</tr>
<?php }
	else{ ?>
		<td colspan = '7'><?php echo "There are no replies.";  ?></td>
	<?}?>

	</tbody>
</table>

<?=form_close()?>