
<p>Hi <strong><?php echo $usuario; ?></strong>
<?php

if (!isset($evaluaciones_pendientes) || $evaluaciones_pendientes == 0)
{
	$evaluaciones_pendientes = "no";
}

echo ", there are $evaluaciones_pendientes revisions pending for an assessment.";

?>
</p>
