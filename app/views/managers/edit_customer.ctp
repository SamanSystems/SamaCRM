<div class="content_title">
	<h2>ویرایش مشتری برتر</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Customer', array('url' => array('controller' => 'managers' ,'action' => 'edit_customer')))
		.$form->input('title')
		.$form->input('link')
		.$form->end(__('Submit', true));
	?>
</div>

