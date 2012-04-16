<div class="content_title">
	<h2>ویرایش  تنظیمات</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Setting', array('url' => array('controller' => 'managers', 'action' => 'edit_setting')))
		.$form->input('name', array('label' => 'نام موسسه'))
		.$form->input('phonenum', array('label' => 'تلفن تماس', 'class' => 'input-eng'))
		.$form->input('address', array('label' => 'آدرس موسسه'))
		.$form->input('website', array('آدرس سایت', 'class' => 'input-eng'))
		.$form->input('desc', array('label' => 'توضیحات'))
		.$form->input('top_user_percent',array('label'=>'پورسانت فروش به فروشنده بالادست (در صد)'))
		.$form->input('mail_address', array('label' => 'آدرس پست الکترونیک', 'class' => 'input-eng'))
		.$form->input('mail_title', array('label' => 'عنوان پست‌های الکترونیک'))
		.$form->input('send_email', array('label' => 'پست الکترونیک فرستاده شود'))
		.$form->input('gateway_number', array('label' => 'شماره درگاه اس ام اس', 'class' => 'input-eng'))
		.$form->input('gateway_pass', array('label' => 'کلمه عبور درگاه اس ام اس', 'class' => 'input-eng', 'type' => 'password'))
		.$form->input('security_key', array('label' => 'کلمه امنیتی 16 کارکتری', 'class' => 'input-eng'))
		.$form->input('send_sms', array('label' => 'برای کاربر اس ام اس ارسال شود'))
		.$form->input('admin_cellnum', array('label' => 'شماره موبایل مدیر', 'class' => 'input-eng'))
		.$form->input('send_sms_option', array('label' => 'برای مدیر اس ام اس ارسال شود'))
		.$form->end(__('Submit', true));
	?>
</div>

