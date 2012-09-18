	<?php
		echo heading('Introduce the new criteria:', 1);
		echo br();
		echo form_open('parametros/insert');
		echo heading('Criteria:', 4);		
		echo form_input($test);
		echo br();
		echo heading('Description:', 4);	
		echo form_input($description);
		echo br();
		echo br();
		echo form_submit($submit);
		echo form_close();
	?>
