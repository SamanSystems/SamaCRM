<?php 
	if ( $session->check('Message.auth') )
	{
		$session->flash("auth", array('class' => 'error-msg'));
	}
?>