	  <div class="content_title">
		<h2><?php __('Change Pass'); ?></h2>
	  </div>
		
		<div class="content_content">
<?php 
	echo $form->create('User', array('action' => 'change_password')).
		$form->input('old_password', array('type' => 'password')).'<br />'.
		$form->input('password', array('label' => __('New Password', true))).'<br />'.
		$form->input('password_confirm', array('type' => 'password', 'label' => __('Password Confirm', true))).'<br />'.
		$form->end(__('Change Pass', true));
?>
		</div>