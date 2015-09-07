<h2>List of evaluation criteria</h2>

<div class="btn-group" style="margin-bottom: 10px">
<?php
	echo anchor('parametros/add', 'Add another criteria', array('title' => "New criteria", "class" => "btn btn-success"));
	echo anchor('parametros/csv', 'Generate CSV', array('title' => 'CSV', "class" => "btn"));
?>
</div>

<table class="table table-striped table-hover table-condensed table-bordered">
	<tbody>
		<tr class="head">
			<th>Criteria</th>
			<th>Generic / Specific</th>
			<th>Actions</th>
		</tr>
	</tbody>
	<?php foreach ($entregables as $key => $value) { ?>
	<tr>
		<td><?php echo $value; ?></td>
		<td>
			<?php if ($generic_specific[$value] == false) { echo "Generic"; } ?>
			<?php if ($generic_specific[$value] == true) { echo "Specific"; } ?>
		</td>
		<td>
			<div class="btn-group">
				<?php echo anchor(site_url("parametros/edit/" . $key), "Edit", array("class" => "btn btn-small btn-primary")); ?>
				<?php echo anchor(site_url("parametros/delete/" . $key), "Delete", array("class" => "btn btn-small btn-danger")); ?>
			</div>			
		</td>
	</tr>
	<?php } ?>
</table>
 
<h2>General parameters</h2>
<form method="POST" action="parametros" class="form-horizontal">

	<div class="control-group">
		<label class="control-label" for="">Category</label>
		<div class="controls">
			<input type="text" name="categoria" value="<?php echo $categoria; ?>" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Start date</label>
		<div class="controls">
			<input type="text" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>"><span class="help-inline">Format is yyyymmddhhmmss</span>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">End date</label>
		<div class="controls">
			<input type="text" name="fecha_fin" value="<?php echo $fecha_fin; ?>"><span class="help-inline">Format is yyyymmddhhmmss</span>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Evals per student</label>
		<div class="controls">
			<input type="text" name="evaluaciones_por_alumno" value="<?php echo $evaluaciones_por_alumno;?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Meta-evals per student</label>
		<div class="controls">
			<input type="text" name="metaevaluaciones_por_alumno" value="<?php echo $metaevaluaciones_por_alumno;?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Evaluations per edition</label>
		<div class="controls">
			<input type="text" name="evaluaciones_por_edicion" value="<?php echo $evaluaciones_por_edicion;?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Each student must have a minimun of X editions evaluated</label>
		<div class="controls">
			<input type="text" name="min_ediciones_evaluadas_por_alumno" value="<?php echo $min_ediciones_evaluadas_por_alumno;?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Autoevaluation (1 = Allowed, 0 = Disallowed)</label>
		<div class="controls">
			<input type="text" name="autoevaluacion" value="<?php echo $autoevaluacion;?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="">Wiki URL</label>
		<div class="controls">
			<input type="text" name="wiki_url" value="<?php echo $wiki_url;?>">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Modify parameters</button>
		</div>
	</div>
</form>
 
<div id="question" style="display:none; cursor: default"> 
        <h1>Would you like to contine?.</h1> 
        <input type="button" id="yes" value="Yes" /> 
        <input type="button" id="no" value="No" /> 
</div> 

<h2>Evaluation exercises management</h2>
<div class="btn-group" style="margin-bottom: 10px">
<?php
	echo anchor('evaluation_exercise', 'Administration of evaluation exercises', array('title' => 'Evaluation exercise', "class" => "btn"));
?>

<?php echo "<br><br>";?>

<h2>Roles</h2>
<div class="btn-group" style="margin-bottom: 10px">
<?php
	echo anchor('roles', 'Administration of roles', array('title' => 'Roles', "class" => "btn"));
?>

<?php echo "<br><br>";?>

<h2>Extra help</h2>
<div class="btn-group" style="margin-bottom: 10px">
<?php
	echo anchor(site_url("parametros/help"), 'Help', array('title' => 'Help', "class" => "btn"));
?>