<div class="content_title">
	<h2>ارسال انبوه اس ام اس</h2>
</div>
<div class="content_content">
<p align="right"><b>توجه :</b> پس از کلیک بر روی ثبت عملیات قابل بازگشت نیست .</p>
	<?php
	echo $form->create('Bulk', array('url' => array('controller' => 'managers', 'action' => 'bulk_sms')))
		.$form->input('subject', array('label' => 'عنوان اس ام اس ( موضوع اس ام اس )'))
		.$form->input('content', array('label' => 'متن اس ام اس'))
		.$form->end(__('Submit', true));
	?>
</div>