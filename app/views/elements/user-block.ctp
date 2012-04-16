<div class="block">
				<div class="block_title">
					<h2>پنل کاربران</h2>
				</div>
				<div class="block_content">
	<?php
		if(!isset($user)){
			echo $form->create('User',array('url'=>array('controller'=>'users','action'=>'login'),'id'=>'UserLogin')).
				 '<br /><center>'.$html->link($html->image('/img/icons/profile.png').__('register',true),array('controller'=>'users','action'=>'register'), array('class'=>'button' , 'title'=>__('register',true), 'escape'=>false)).'</center><br />'.
				 $form->input('email', array('class'=> 'input-eng')).
				 $form->input('password', array('class'=> 'input-eng')).'<br />'.
				 '<center>'.$html->link('بازیابی رمز عبور',array('controller' => 'users' , 'action'=>'forget_password')).'</center><br />'.
				 $form->end(__('login',true));
		} else {
				echo $this->element('login-block');
		}
	?>					
				</div>
			</div>