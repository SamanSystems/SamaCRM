<div class="content_title">
	<h2>تغییرات منو</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Menu', array('url' => array('controller' => 'menus' ,'action' => 'admin_edit')))
		.$form->inputs(array('legend' => false)
		.$form->end(__('Submit', true));
	?>
</div>