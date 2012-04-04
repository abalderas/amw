	<?php if ($evaluacion!=0) { ?>
		<p>If you don't agree with your evaluation, you may reply here --> <?php echo anchor(site_url("evaluar/reply/" . $evaluacion), "Reply"); ?></p>
	<?php } ?>