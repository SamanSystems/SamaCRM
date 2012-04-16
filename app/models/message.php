<?php
class Message extends AppModel
{
	var $name="Message";
	var $validate=array(
						'name'=>array(
										'rule'=>'notEmpty',
										'message'=>'شما باید حتما نام خود را وارد کنید'
									),

						'email'=>array(
										'rule'=>'email',
										'message'=>'  پست الکترونیکی وارد شده  معتبر نیست'
									),
						'content'=>array(
										'rule'=>'notEmpty',
										'message'=>'شما باید حتما متن تماس را وارد کنید'
									)
		
						);

}
?>