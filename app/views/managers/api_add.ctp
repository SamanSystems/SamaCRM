<div class="content_title">
	<h2>افزودن رابط جدید</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Api', array('url' => array('controller' => 'managers' ,'action' => 'api_add')))
		.$form->input('name', array('label' => 'عنوان'))
		.$form->input('component_name')
		.$form->input('settings', array('class' => 'input-eng'))
		.$form->end(__('Submit', true));
	?>
</div>

