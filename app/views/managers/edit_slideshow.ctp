<div class="content_title">
	<h2>تغییر تصویر کشویی</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Slideshow', array('url' =>array('controller' => 'managers' ,'action' => 'edit_slideshow')))
		.$form->input('title')
		.$form->input('pic_address',array('class' => 'input-eng'))
		.$form->input('link_address',array('class' => 'input-eng'))
		.$form->input('active')
		.$form->end(__('Submit', true));
	?>
</div>
