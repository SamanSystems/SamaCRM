<div class="content_title">
	<h2>افزودن شاخه خبری جديد</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Newscategory', array('url' =>array('controller' => 'managers' ,'action' => 'add_newscategory')))
		.$form->input('name', array('label' => 'نام شاخه'))
		.$form->end(__('Submit', true));
	?>
</div>

