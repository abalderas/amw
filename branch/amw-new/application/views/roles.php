<h2>Rol permissions</h2>
</div>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tbody>
		<tr class="head">
			<th>Rol name</th>
			<th>Permissions to acces to:</th>
		</tr>
	</tbody>
	<tr class="head">
		<td>Rol</td>
		<td>Asses</td>
		<td>My assessments</td>
		<td>Metaevaluations</td>
		<td>All Metaevaluations</td>
		<td>Students</td>
		<td>Parameters</td>
	</tr>
	<?php foreach ($roles as $key => $value) { ?>
	<?php echo form_open($edit_rol_url); ?>
	<tr>
		<td>
			<?php echo $value; ?>
			<input type="hidden" name="rol_name" value="<?php echo $value;?>" />
		</td>
		<td>
			<div class="checkbox">
				<input type="checkbox" name= "evaluar" <?php if ($evaluar[$value] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<td>
			<div class="checkbox">
				<input type="checkbox" name="feedback" <?php if ($feedback[$value] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<td>
			<div class="checkbox">
				<input type="checkbox" name="metaevaluar" <?php if ($metaevaluar[$value] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<td>
			<div class="checkbox">
				<input type="checkbox" name="metaevaluar_lista" <?php if ($metaevaluar_lista[$value] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<td>
			<div class="checkbox">
				<input type="checkbox" name="alumnos" <?php if ($alumnos[$value] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<td>
			<div class="checkbox">
				<input type="checkbox" name="parametros" <?php if ($parametros[$value] == true) { ?> checked <?php } ?>>
			</div>
		</td>
		<td>
		<div class="buttons">
	      		<?php echo form_submit('edit rol permissions', 'Edit rol permissions'); ?>
	    </div>
	</td>
	</tr>
	<?php echo form_close(); ?> 
	<?php } ?>
</table>


<h2>Create new rol</h2>
<?php echo form_open($new_rol_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Rol name</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="text" name="new_rol_name" value="New rol name" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Asses</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="checkbox" name="nuevo_acceso" checked>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">My assessments</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="checkbox" name="nuevo_feedback" checked>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Metaevaluations</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="checkbox" name="nuevo_metaevaluaciones">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">All Metaevaluations</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="checkbox" name="nuevo_metaevaluaciones_lista">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Students</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="checkbox" name="nuevo_alumnos">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="">Parameters</label>
			</div>
		</td>
		<td>
			<div class="controls">
				<input type="checkbox" name="nuevo_parametros">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('create new rol', 'Create new rol'); ?>
    		</div>
    	</td>
	</tr>
</table>
<?php echo form_close(); ?> 

<h2>Delete rol</h2>
<?php echo form_open($delete_rol_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<select name="rol_to_delete">
				<option value="0"> Select rol to delete </option> 
				<?php foreach ($roles as $key => $value) { ?>
					<option value=<?php echo $value; ?>> <?php echo $value; ?> </option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('delete rol', 'Delete rol'); ?>
    		</div>
		</td>
	</tr>		
</table>
<?php echo form_close(); ?> 

<h2>Assign rol</h2>
<?php echo form_open($assign_rol_url); ?>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tr>
		<td>
			<div class="control-group">
				<select name="user_to_assign">
				<option value="0"> Select user to assign a rol </option> 
				<?php foreach ($alumnos as $key => $value) { ?>
					<option value=<?php echo $value; ?>> <?php echo $value; ?> </option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td>
			<div class="control-group">
				<select name="rol_to_assign">
				<option value="0"> Select rol to assign </option> 
				<?php foreach ($roles as $key => $value) { ?>
					<option value=<?php echo $value; ?>> <?php echo $value; ?> </option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td>
			<div class="buttons">
    		    <?php echo form_submit('assign rol', 'Assign rol'); ?>
    		</div>
		</td>
	</tr>		
</table>
<?php echo form_close(); ?> 

<h2>Users with roles</h2>
</div>
<table class="table table-striped table-hover table-condensed table-bordered">
	<tbody>
		<tr class="head">
			<th>User</th>
			<th>Rol</th>
		</tr>
	</tbody>
	<?php foreach ($usuarios_con_roles as $key => $value) { ?>
	<tr>
		<td>
			<?php echo $username[$value]; ?>
		</td>
		<td>
			<?php echo $userrol[$value]; ?>
		</td>
	</tr>
	<?php } ?>
</table>