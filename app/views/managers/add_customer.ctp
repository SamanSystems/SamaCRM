<div class="content_title">
	<h2>افزودن مشتری جدید</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Customer', array('url' => array('controller' => 'managers' ,'action' => 'add_customer')))
		.$form->input('title')
		.$form->input('link')
		.$form->end(__('Submit', true));
	?>
</div>

