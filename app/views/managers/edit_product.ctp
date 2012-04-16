<div class="content_title">
	<h2>ویرایش محصول</h2>
</div>
<div class="content_content">
	<?php
	echo
		$form->create('Product', array('url' => array('controller' => 'managers' ,'action' => 'edit_product')))
		.$form->input('name',array('label' => 'نام محصول'))
		.$form->input('plan_name')
		.$inputs
		.$form->end(__('Submit', true));
	?>
</div>

