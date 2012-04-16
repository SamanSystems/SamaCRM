<div class="content_title">
	<h2>ويرايش رابط</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Api', array('url' => array('controller' => 'managers' ,'action' => 'api_edit', 'id' => $this->data['Api']['id'])))
		.$form->input('name', array('label' => 'عنوان'))
		.$form->input('component_name')
		.$form->input('settings', array('class' => 'input-eng', 'type' => 'textarea'))
		.$form->end(__('Submit', true));
	?>
</div>

