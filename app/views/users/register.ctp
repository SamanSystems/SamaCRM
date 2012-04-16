	<div class=content_title>
		<h2><?php __('register'); ?></h2>
	</div>
		<div class=content_content>
		
		<?php
		echo $form->create('User', array('url' => array('controller' => 'users', 'action' => 'register')))
			.$form->input('email', array('class' => 'input-eng', 'div' => array('id' => 'required')))
			.$form->input('password', array('class' => 'input-eng', 'div' => array('id' => 'required')))
			.$form->input('password_confirm', array('class' => 'input-eng', 'type' => 'password', 'div' => array('id' => 'required')))
			.$form->input('name', array('div' => array('id' => 'required')))
			.$form->input('cellnum', array('class' => 'input-eng', 'div' => array('id'=>'required')))
			.$form->input('phonenum', array('class' => 'input-eng'))
			.$form->input('address')
			.$form->input('pbox',array('class' => 'input-eng'))
			.$form->input('company');
		
		if(!empty($referrer_name))
			echo $form->input('referrer_name',array('value' => $referrer_name, 'readonly' => 'readonly'));
		
		echo $form->end(__('register',true));		
		?>
		
		</div>