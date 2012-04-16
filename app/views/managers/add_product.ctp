<div class="content_title">
	<h2>افزودن محصول جدید</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Product', array('url' =>array('controller' => 'managers' ,'action' => 'add_product')))
		.$form->input('service_id',array('id'=>'service_product_property','options'=>$options))
		.$form->input('name',array('label' => 'نام محصول'))
		.$form->input('plan_name')
		.'<div id="productproperty"></div>'
		.$form->end(__('Submit', true));
	?>
</div>

