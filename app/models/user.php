<?php

class User extends AppModel
{
	var $name = 'User';

	var $validate=array( 
						'password_confirm' => array(
												'notempty' => array('rule' => 'notEmpty', 'message' => 'رمز عبور نمی تواند خالی باشد'),
												'6-character' => array('rule' => array('minLength', '6'), 'message' => 'رمز عبور باید بیشتر از 6 کاراکتر باشد')
												),

						'name' => array(
										'notempty' => array('rule' => 'notEmpty', 'message' => 'نام ونام خانوادگی نمی تواند خالی باشد')
										),
										
						'cellnum' => array(
										'notempty' => array('rule' => 'notEmpty', 'message' => 'شماره تلفن همراه نمی تواند خالی باشد')
										),

						'email' => array(
										'notempty' => array('rule' => 'notEmpty', 'message' => 'آدرس پست الکترونیکی نمی تواند خالی باشد'),								
										'mail' => array('rule' => 'email', 'message'=>'آدرس پست الکترونیکی معتبر نمی باشد'),
										'isunique' => array('rule' => 'isUnique', 'message' => ' این نام کاربری وجود دارد لطفا نام کاربری دیگری انتخاب کنید')
										)
						);
}

?>
