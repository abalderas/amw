
<p>Hi <?php echo $usuario; ?>
<?php
		if (isset($evaluaciones_pendientes))
		{
			echo ", there are " . $evaluaciones_pendientes . " revisions pending for an assessment";
			if ($evaluaciones_pendientes > 0)
				echo ", the entry of the wiki is in the next url:  ";
		}
		else
			echo ", there are not revisions pending for an assessment:  ";
?>
</p>
