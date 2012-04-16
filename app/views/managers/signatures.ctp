<div class="content_title">
	<h2>مدیریت امضاء</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Signature', array('url' => array('controller' => 'managers' ,'action' => 'Signatures')))
		.$form->input('text', array('type' => 'textarea', 'label' => 'متن امضاء'))
		.$form->end(__('Submit', true));
	?>
</div>

