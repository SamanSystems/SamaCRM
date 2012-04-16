<div class="content_title">
	<h2>ویرایش منو</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Menu', array('url' =>array('controller' => 'managers' ,'action' => 'edit_menu')))
		.$form->input('title')
		.$form->input('link')
		.$form->input('sort')
		.$form->end(__('Submit', true));
	?>
</div>


