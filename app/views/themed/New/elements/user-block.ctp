<div class="menu-box user-panel">
	<?php
		if(!isset($user)){
			echo '<h2>پنل کاربران</h2>'.
				 $form->create('User',array('url'=>array('controller'=>'users','action'=>'login'),'id'=>'UserLogin')).
				 $form->input('email', array('class'=> 'input-eng')).
				 $form->input('password', array('class'=> 'input-eng')).'<br>'.
				 '<center>'.$html->link('بازیابی رمز عبور',array('controller' => 'users' , 'action'=>'forget_password')).'</center><br />'.
				 $form->end(__('login',true)).
 				 '<br /><center>'.$html->link($html->image('/img/icons/profile.png').__('register',true),array('controller'=>'users','action'=>'register'), array('class'=>'button' , 'title'=>__('register',true), 'escape'=>false)).'</center><br />';
		} else {
				echo $this->element('login-block');
		}
	?>					
</div>	