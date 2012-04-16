<div class="content_title">
	<h2>افزودن منو جديد</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Menu', array('url' =>array('controller' => 'managers' ,'action' => 'add_menu')))
		.$form->input('title')
		.$form->input('link')
		.$form->input('sort')
		.$form->end(__('Submit', true));
	?>
</div>

