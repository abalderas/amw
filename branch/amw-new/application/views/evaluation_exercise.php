<h2>Evaluation exercises</h2>
</div>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tbody>
		<tr class="head">
			<th>Evaluation exercise</th>
			<th>Details</th>
		</tr>
	</tbody>
	<tr class="head">
		<td>Name</td>
		<td>Beginning</td>
		<td>End of exercise description phase</td>
		<td>End of develop phase</td>
		<td>End of evaluation phase</td>
		<td>End of teacher corrections phase</td>
		<td>Criteria for the students</td>
	</tr>
	<?php foreach ($evaluation_exercise_id as $key => $value) { ?>
	<?php echo form_open($edit_evaluation_exercise_url); ?>
	<tr>
		<td>
			<input type="hidden" name="evaluation_id" value="<?php echo $value;?>" />
			<input type="text" name="exercise_name" value="<?php echo $exercise_name[$value];?>" />
		</td>
		<td>
			<div class="date">
				<input type="date" name= "beginning" value="<?php echo $beginning[$value];?>" />
			</div>
		</td>
		<td>
			<div class="date">
				<input type="date" name="first_phase_end" value="<?php echo $first_phase_end[$value];?>" />
			</div>
		</td>
		<td>
			<div class="date">
				<input type="date" name="second_phase_end" value="<?php echo $second_phase_end[$value];?>" />
			</div>
		</td>
		<td>
			<div class="date">
				<input type="date" name="third_phase_end" value="<?php echo $third_phase_end[$value];?>" />
			</div>
		</td>
		<td>
			<div class="date">
				<input type="date" name="fourth_phase_end" value="<?php echo $fourth_phase_end[$value];?>" />
			</div>
		</td>
		<td>
			<div class="description">
				<input type="textarea" name="description" rows="5" cols="40" value="<?php echo $description[$value];?>" />
			</div>
		</td>
		<td>
			<div class="buttons">
	      		<?php echo form_submit('edit evaluation exercise', 'Edit evaluation exercise'); ?>
	   		</div>
		</td>
	</tr>
<?php echo form_close(); ?> 
<?php } ?>
</table>

<h2>Make preasignations</h2>
<?php echo form_open($make_preasignations_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<select name="ee_to_preasignations">
				<option value="0"> Select evaluation exercise </option> 
				<?php foreach ($avalibles_for_preasignations as $key => $value) { ?>
					<option value='<?php echo $value; ?>'> <?php echo $exercise_name[$value]; ?> </option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('make preasignations', 'Make preasignations'); ?>
    		</div>
		</td>
	</tr>		
</table>
<?php echo form_close(); ?> 

<h2>Delete preasignations</h2>
<?php echo form_open($delete_preasignations_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<select name="ee_delete_preasignations">
				<option value="0"> Delete preasignations from</option> 
				<?php foreach ($preasignations_to_delete as $key => $value) { ?>
					<option value='<?php echo $value; ?>'> <?php echo $exercise_name[$value]; ?> </option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('delete preasignations', 'delete preasignations'); ?>
    		</div>
		</td>
	</tr>		
</table>
<?php echo form_close(); ?> 

<h2>Criteria for evaluation exercises</h2>
</div>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tbody>
		<tr class="head">
			<th>Evaluation exercise</th>
			<?php foreach ($entregables as $categoria) { ?>
				<th><?php echo $entregable_name[$categoria]; ?></th>
			<?php } ?>
			</tr>
	</tbody>
	<?php foreach ($evaluation_exercise_id as $ee) { ?>
	<?php echo form_open($edit_evaluation_exercise_criteria_url); ?>
	<tr>
		<td>
			<?php echo $exercise_name[$ee]; ?>
			<input type="hidden" name="ee_name" value="<?php echo $exercise_name[$ee]; ?>" />
		</td>
		<?php foreach ($entregables as $categoria) { ?>
		<td>
			<div class="checkbox">
				<input type="checkbox" name= "<?php echo $entregable_name[$categoria]; ?>" <?php if ($multiarray[$ee][$categoria] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<?php } ?>
		<td>
			<div class="buttons">
	      		<?php echo form_submit('edit evaluation exercise criteria', 'Edit evaluation exercise criteria'); ?>
	    	</div>
		</td>
		<?php echo form_close(); ?>
	</tr>
	<?php } ?>
</table>


<h2>Create new evaluation exercise</h2>
<?php echo form_open($new_evaluation_exercise_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Evaluation exercise name (without spaces)</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="text" name="new_evaluation_exercise_name" value="New_evaluation_exercise_name" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Beggining date</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="date" name="nuevo_beginning">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">End of exercise description phase</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="date" name="nuevo_first_phase_end">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">End of develop phase</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="date" name="nuevo_second_phase_end">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">End of evaluation phase</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="date" name="nuevo_third_phase_end">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">End of teacher corrections phase</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="date" name="nuevo_fourth_phase_end">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Description</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="textarea" rows="5" cols="40" name="nuevo_description">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('create new evaluation exercise', 'Create new evaluation exercise'); ?>
    		</div>
    	</td>
	</tr>
</table>
<?php echo form_close(); ?> 

<h2>Delete evaluation exercise</h2>
<?php echo form_open($delete_evaluation_exercise_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<select name="evaluation_exercise_to_delete">
				<option value="0"> Select evaluation exercise to delete </option> 
				<?php foreach ($evaluation_exercise_id as $key => $value) { ?>
					<option value=<?php echo $exercise_name[$value]; ?>> <?php echo $exercise_name[$value]; ?> </option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('delete evaluation exercise', 'Delete evaluation exercise'); ?>
    		</div>
		</td>
	</tr>		
</table>
<?php echo form_close(); ?> 
