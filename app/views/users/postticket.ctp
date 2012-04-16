<div class="content_title">
	<h2>ارسال تيکت جديد</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Ticket', array('url' => array('controller' => 'users' ,'action' => 'postticket'), 'type' => 'file'))
		.$form->input('title')
		.$form->input('content' , array('rows' => '4'))
		.$form->input('file', array('label' => 'فایل' ,'type' => 'file'))
		.$form->input('ticketdepartment_id',array('options' =>$departments))
		.$form->input('priority')
		.$form->end(__('Submit', true));
	?>
</div>