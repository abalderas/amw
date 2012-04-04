<h4><?php if(isset($reply_number)) echo "Reply $reply_number"; else echo "Assessment"; ?></h4>
<div <?php if(isset($color)) echo "style=\"background-color:".$color.";\"";?>>
<?php echo form_fieldset('Summary'); ?>

<table>
	<tr>
		<td>User</td>
		<td><?php echo $usuario; ?></td>
		<td></td>
	</tr>
    <?php
    if ($revisor == 'Admin' || $revisor == $usuario)
    {
    ?>
    
	<tr>
		<td>Revisor</td>
		<td><?php echo $revisor; ?></td>
		<td></td>
	</tr>
    <?php
    }
    ?>
	<tr>
		<td>Link</td>
		<td><?php echo $entrada; ?></td>
		<td></td>
	</tr>
	<tr class="head">
		<td>Revision</td>
		<td>Grade</td>
		<td>Description</td>
	</tr>
	<?php
		foreach ($entregables as $i => $valor)
		{
	?>	
	<tr>
		<td><?php echo $entregables[$i]; ?></td> 
		<td><?php echo $puntuacion[$i]; ?></td>
		<td><?php echo $comentarios[$i]; ?></td>		
	</tr>
	<?php
		}
	?>
</table>
    <?php echo form_fieldset_close(); ?>
</div>
