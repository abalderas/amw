
<p>Hi <strong><?php echo $usuario; ?></strong>
<?php

if (!isset($metaevaluaciones_pendientes))
{
	$metaevaluaciones_pendientes = "no";
}

echo ", there are $metaevaluaciones_pendientes evaluations pending for a metaevaluation.";

?>
</p>
