<div class="content_title">
	<h2>ارسال انبوه ایمیل</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Bulk', array('url' => array('controller' => 'managers', 'action' => 'bulk_email')))
		.$form->input('subject', array('label' => 'عنوان ایمیل'))
		.$form->input('content', array('label' => 'متن کامل ایمیل', 'id' => 'editor'))
		.$form->end(__('Submit', true));
	?>
</div>