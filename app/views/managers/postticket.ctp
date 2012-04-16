<div class="content_title">
	<h2>ارسال تيکت جديد</h2>
</div>
<div class="content_content">
	<?php
	echo 
		$form->create('Ticket', array('url' => array('controller' => 'managers' ,'action' => 'postticket',$to_user['User']['id']), 'type' => 'file'))
		.$form->input('name',array('value' =>$to_user['User']['name'],'disabled' =>'disabled'))
		.$form->input('company',array('value' =>$to_user['User']['company'],'disabled' =>'disabled'))
		.$form->input('title')
		.$form->input('content' , array('rows' => '4'))
		.$form->input('file', array('label' => 'فایل' ,'type' => 'file'))
		.$form->input('ticketdepartment_id',array('options' =>$departments))
		.$form->input('priority')
		.$form->input('status')
		.$form->end(__('Submit', true));
	?>
</div>