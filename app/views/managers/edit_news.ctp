<div class="content_title">
	<h2>ویرایش خبر</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('News', array('url' => array('controller' => 'managers' ,'action' => 'edit_news')))
		.$form->input( 'title')
		.$form->input('content', array('id' => 'editor'))
		.$form->input('date' , array('type' => 'date'))
		.$form->input('newscategory_id' ,array('options'=>$categories,'empty' => 'بدون شاخه'))
		.$form->end(__('Submit', true));
	?>
</div>

