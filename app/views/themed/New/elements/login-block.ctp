<?php
			if($logged_as == true)	echo '<center>'.$html->link($html->image('/img/icons/profile.png').__('Back to admin',true),array('controller'=>'managers','action'=>'admin_back'), array('class'=>'button' , 'title'=>__('register',true), 'escape'=>false)).'</center><br />';
			
			echo "<h2> سلام ".$user['User']['name'].'</h2>'.
			'<ul class="list">'.
			'<li>'.$html->link('صفحه اصلی محيط کاربری',array('controller'=>'users','action'=>'home')).'</li>'.
			'<li>'.$html->link('سفارشات من', array('controller'=>'users','action'=>'orders')).'</li>'.
			'<li>'.$html->link('گردش حساب من', array('controller'=>'users','action'=>'accounting')).'</li>'.
			'<li>'.$html->link('افزایش اعتبار',array('controller'=>'users','action'=>'charge')).'</li>'.
			'<li>'.$html->link('تيکت ها',array('controller'=>'users','action'=>'tickets')).'</li>'.
			'<li>'.$html->link('جستجوی دامنه',array('controller'=>'users','action'=>'whois')).'</li>'.
			'<li>'.$html->link('کاربران زير مجموعه',array('controller'=>'users','action'=>'refer_user')).'</li>'.
			'<li>'.$html->link('ویرایش مشخصات من',array('controller'=>'users','action'=>'update')).'</li>'.
			'<li>'.$html->link(__('Change Pass',true),array('controller'=>'users','action'=>'change_password')).'</li>';
			if($user['User']['role'] > 0) echo '<li>'.$html->link(__('Management Panel',true),array('controller'=>'managers','action'=>'home')).'</li>';
			echo '<li>'.$html->link(__('logout',true),array('controller'=>'users','action'=>'logout')).'</li>'.
			'</ul>';
?>