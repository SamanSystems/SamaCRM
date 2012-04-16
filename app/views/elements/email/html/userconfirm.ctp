<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br>
<?php
if(isset($client))
{
	echo ' کاربر گرامی  آفا /خانم '.$client['User']['name'].'<br /> شناسه کاربری شما توسط ادمین فعال شده است <br />';
}elseif(isset($info))
{
	echo  ' کاربر گرامی  آفا /خانم '.$info['User']['name'].'<br /> برای فعال سازی شناسه کاربری خود در اینجا کلیک کنید <br />'
		.$html->link('فعال سازی شناسه کاربری',$setting['website'].'/users/confirmation/'.base64_encode($info['User']['email']).'/'.$key).'<br />';
}elseif(isset($user))
{
	echo ' کاربر گرامی  آفا /خانم '.$user['User']['name'].'<br /> شناسه کاربری شما به وسیله ادمین ساخته شده است برای فعال سازی آن برروی لینک زیر کلیک کنید <br /> با تشکر '.$html->link('فعال سازی شناسه کاربری',$setting['website'].'/users/confirmation/'.base64_encode($user['User']['email']).'/'.$key).'<br />
	رمز عبور شما'.$user['User']['password_confirm'].'<br />';
}

?>
</div>
