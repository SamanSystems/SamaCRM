<div class="content_title">
	<h2>ویرایش روش پرداخت</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Payment', array('url' =>array('controller' => 'managers' ,'action' => 'edit_payment')))
		.$form->input('name',array('label'=> __('Method Name', true)))
		.$form->input('desc' ,array('id' => 'editor'))
		.$form->input('list',array('label'=>'نوع پرداخت :','options'=>array('0'=>'در لیست نباشد' , '1'=>'پرداخت معمولی'   , '2'  => 'پرداخت آنلاین')))
		.$form->input('pin',array('label'=>' : شماره حساب یا پین برای پرداخت آنلاین '))
		.$form->input('merchant', array('label' => 'رابط API', 'class' => 'input-eng'))
		.$form->input('settings', array('label' => 'اطلاعات رابط API', 'type' => 'textarea', 'class' => 'input-eng'))
		.$form->end(__('Submit', true));
	?>
</div>

