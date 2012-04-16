<div class="content_title">
	<h2>ویرایش دپارتمان</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Ticketdepartment', array('url' =>array('controller' => 'managers' ,'action' => 'edit_department')))
		.$form->input('name', array('label' => 'نام دپارتمان'))				.$form->input('department_order')				.$form->input('guest_access', array('label' => 'افتتاح تيکت توسط ميهمان','type' => 'checkbox'))
		.$form->end(__('Submit', true));
	?>
</div>


