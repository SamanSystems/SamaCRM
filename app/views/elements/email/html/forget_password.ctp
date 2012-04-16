<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br>
<?php
	echo  ' کاربر گرامی  آفا /خانم '.$user['User']['name'].'<br />به استحضار ميرساند درخواستی مبنی بر فراموشی کلمه عبور برای شناسه کاربری شما ثبت شده است. <br /> جهت ايجاد کلمه عبور جديد روی لينک زير کليک کنيد. <br />'
		.$html->link('ايجاد رمز عبور جديد',$setting['website'].'/users/forget_password/step2/'.base64_encode($user['User']['email']).'/'.$key).'<br />';
?>
</div>
