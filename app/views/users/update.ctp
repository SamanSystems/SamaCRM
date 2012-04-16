<?php

echo '<div class="content_title">
		<h2>مشخصات حساب من</h2>
	  </div>
		
		<div class="content_content">'
		.	$form->create('User',array('url' => array('controller'=>'users', 'action' =>'update'))).
			$form->input("name").
			$form->input("phonenum").
			$form->input("cellnum").
			$form->input("address").
			$form->input("pbox",array('size'=> '10')).
			$form->input("company").
			$form->end(__("update profile",true)).
		'</div>';

?>