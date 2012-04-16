	<div class=content_title>
		<h2><?php __("register"); ?></h2>
	</div>
		<div class=content_content>
		<?php
		echo $form->create('User',array('url' => array('controller'=>'managers', 'action' =>'register'))).
			$form->input("email").
			$form->input("password").
			$form->input("password_confirm",array('type' => 'password')).
			$form->input("name").
			$form->input("phonenum").
			$form->input("cellnum").
			$form->input("address").
			$form->input("pbox").
			$form->input("company").
			$form->input('send_mail',array('label'=>'عدم ارسال پست الکترونیکی و تایید خودکار','type' => 'checkbox')).
			$form->end(__("register",true));		
		?>
		</div>