<div class="content_title">
	<h2>افزودن صفحه جدید</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Page', array('url' => array('controller' => 'managers' ,'action' => 'add_page')))
		.$form->input('slug')
		.$form->input('cat')
		.$form->input('title')
		.$form->input('content' , array('id' => 'editor'))
		.$form->end(__('Submit', true));
	?>
</div>

