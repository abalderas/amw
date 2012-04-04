	<?php
		echo heading('Introduce the new value of the criteria:', 1);
		echo br();
		echo form_open('params/update');
		echo heading('Criteria:', 4);		
		echo form_input($test);
		echo br();
		echo heading('Description:', 4);	
		echo form_input($description);
		echo br();
		echo form_hidden($id);
		echo br();
		echo form_submit($submit);
		echo form_close();
	?>
