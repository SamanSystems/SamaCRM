<?php

echo '<div class="content_title">
		<h2>مشخصات کوپن شارژ</h2>
	  </div>
		
		<div class="content_content">'
		.	$form->create('Cardcharge',array('url' => array('controller'=>'users', 'action' =>'charge','id'=>'cardcharge'))).
			$form->inputs(array('fieldset'=>false,'cardid','cardpassword'),array('user_id','confirmed')).
			$form->end(__("Submit card",true)).	
		'</div>';
?>