<div class="content_title">
	<h2>ویرایش مشخصات مشتری</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('User', array('url' => array('controller' => 'managers' ,'action' => 'edit_user', $this->params['pass'][0])))
		.$form->input('email')
		.$form->input('name')
		.$form->input('cellnum')
		.$form->input('phonenum')
		.$form->input('pbox')
		.$form->input('company')
		.$form->input('password', array('class' => 'input-eng'))
		.$form->input('password_confirm', array('class' => 'input-eng', 'type' => 'password'))
		.$form->input('address')
		.$form->input('role',array('label'=>'سطح دسترسی :','options' => array('-1'=>'تایید نشده','0'=>'مشتری','1'=>'اپراتور وبسايت','2'=>'فروش و مالی','3'=>'پشتيبانی','4'=>'مديرکل')))
		.$form->end(__('Submit', true));
		echo '<a href="/managers/contact/'.$id.'"> بر گشت به مشخصات مشتری</a>';  
	?>
</div>