<?php if($step == 'step2') { ?>
<div class=content_title>
	<h2>ايجاد کلمه رمز عبور جديد</h2>
</div>
<div class="content_content">
	<div id="flashMessage" class="warning-msg">1. لطفا يک رمز عبور جديد را همراه با تکرار آن وارد کنيد.<br>
	2. چنانچه مايل به تغيير رمز نميباشيد اين پنجره را بسته و ايميل را حذف کنيد.<br>
	3. پس از تغيير رمز اعتبار اين لينک نيز از بين خواهد رفت.<br>
	<br>
	</div>
	<?php
		echo $form->create('User', array('url' => array('controller' => 'users', 'action' => 'forget_password',$step ,$email, $key))).
			$form->input('password', array('label' => __('New Password', true), 'class' => 'input-eng')).'<br />'.
			$form->input('password_confirm', array('type' => 'password', 'label' => __('Password Confirm', true), 'class' => 'input-eng')).'<br />'.
			$form->end(__('Change Pass', true));     
    ?>
</div>
<?php } else { ?>
<div class=content_title>
	<h2>بازیابی رمز عبور</h2>
</div>
<div class="content_content">
    <?php
        echo $form->create('User',array('controller'=>'users' , 'action'=>'forget_password'))
            .$form->input('email',array('class' => 'input-eng'))
            .$form->end(__('send',true));
            
    ?>
</div>
<?php } ?>